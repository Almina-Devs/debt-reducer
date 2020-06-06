<?php

namespace App\Services;

use Auth;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\PaydownSchedule;
use Carbon\Carbon;

class Calculator
{
    /**
     * Undocumented function
     *
     * @param [type] $amount
     * @param [type] $interest
     * @return void
     */
    public function makeAmortizationSchdule($loanId, $amount, $interest)
    {

        $schdule = [];
        $startDate = Carbon::now();
        $minPaymentFloor = ($amount * .01);

        // delete old schedule
        $oldLoanPayment = LoanPayment::where('loan_id', $loanId)->delete();
        
        while ($amount > 0) {
            
            $startDate->addMonths(1);

            // get monthly interest
            $currentPayment = $this->getMonthlyPayment($amount, $interest, $startDate);
            
            // add interest to loan amount
            $amount = $amount + $currentPayment;

            // substract min payment from amount
            $minPayment = $this->getMinimumPayment($amount, $interest);
            $minPayment = $minPayment > $minPaymentFloor ? $minPayment : $minPaymentFloor;
            
            if($minPayment > $amount) {
                $amount = 0;
            } else {
                $amount = $amount - $minPayment;
            }
            
            $item = [
                'loan_id' => $loanId,
                'payment' => $minPayment,
                'payment_date' => $startDate->year . '-' . $startDate->month . '-' . $startDate->day,
                'balance' => $amount,
                'created_at' => Carbon::now()
            ];

            array_push($schdule, $item);

        }

        LoanPayment::insert($schdule);

        $loan = Loan::where('id', $loanId)->first();
        $loan->schedule_ready = 1;
        $loan->save();

        return $schdule;

    }

    /**
     * Undocumented function
     *
     * @param [type] $loanId
     * @return void
     */
    public function getAmortizationSchedule($loanId)
    {
        return LoanPayment::where('loan_id', $loanId)->get();
    }

    /**
     * Undocumented function
     *
     * @param [type] $amount
     * @param [type] $interest
     * @param [type] $month
     * @return void
     */
    private function getMonthlyPayment($amount, $interest, $month)
    {
        $daysInMonth = $month->daysInMonth;
        $payment = ($amount * $interest * $daysInMonth) / 365;
        return number_format($payment, 2, '.', ',');
    }

    /**
     * Undocumented function
     *
     * @param [type] $amount
     * @param [type] $interest
     * @return void
     */
    public function getMinimumPayment($amount, $interest)
    {
        return ($amount * $interest) / 12 + ($amount * .01);
    }

    /**
     * Undocumented function
     *
     * @param [type] $loans
     * @return void
     */
    public function paydownSchedule()
    {

        $userId = Auth::user()->id;

        paydownSchedule::where('user_id', $userId)->delete();

        // get all loans
        $loans = Loan::where('user_id', $userId)->get();

        $monthlyPayment = $loans->sum('min_payment');

        $currentBalance = $loans->sum('current_balance');

        $avgInterest = $loans->avg('interest_rate');

        $current = Carbon::now();

        $payment = $this->getMonthlyPayment($currentBalance, ($avgInterest / 100), $current);
        
        $interest = ($avgInterest / 100);

        $minPaymentFloor = ($currentBalance * .01);

        $loanDataArray = [];

        while ($currentBalance > 0) {
            
            $current->addMonths(1);

            // get monthly interest
            $currentPayment = $this->getMonthlyPayment($currentBalance, $interest, $current);
            
            // add interest to loan amount
            $currentBalance = $currentBalance + $currentPayment;

            // substract min payment from amount
            $minPayment = $this->getMinimumPayment($currentBalance, $interest);
            $minPayment = $minPayment > $minPaymentFloor ? $minPayment : $minPaymentFloor;
            
            if($minPayment > $currentBalance) {
                $currentBalance = 0;
            } else {
                $currentBalance = $currentBalance - $minPayment;
            }
            
            $data = [
                'user_id' => $userId,
                'loan_id' => 0,
                'payment' => (double)$minPayment,
                'balance' => (double)$currentBalance,
                'payment_date' => $current,
                'created_at' => Carbon::now()
            ];

            array_push($loanDataArray, $data);

        }

        PaydownSchedule::insert($loanDataArray);

        $paydown = PaydownSchedule::where('user_id', $userId)->get();
        
        return $paydown;

    }

    public function getTotalMonthlyPayments()
    {
        $loans = Loan::where('user_id', Auth::user()->id)->get();

        return $loans->sum('min_payment');
    }
}

