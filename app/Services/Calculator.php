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
        // Revolving Credit Calc
        // (balance * rate * number of days in given month) / 365
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
    public function paydownSchedule($loans)
    {

        $userId = Auth::user()->id;

        foreach($loans as $loan) {

            $amSchedule = $this->getAmortizationSchedule($loan->id);

            $loanDataArray = [];

            foreach ($amSchedule as $item) {

                $data = [
                    'user_id' => $userId,
                    'loan_id' => $loan->id,
                    'payment' => (double)$item['payment'],
                    'balance' => (double)$item['balance'],
                    'payment_date' => $item['payment_date'],
                    'created_at' => Carbon::now()
                ];

                array_push($loanDataArray, $data);

            }
        
            PaydownSchedule::where('loan_id', $loan->id)->delete();
            PaydownSchedule::insert($loanDataArray);
        
        }

        $paydown = PaydownSchedule::where('user_id', $userId)->get();
        
        return $paydown;

    }

    public function getTotalMonthlyPayments()
    {
        $loans = Loan::where('user_id', Auth::user()->id)->get();

        return $loans->sum('min_payment');
    }
}

