<?php

namespace App\Services;

use Auth;
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
    public function amortizationSchdule($amount, $interest)
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
                'month' => $startDate->month . '/' . $startDate->year,
                'payment' => number_format($minPayment, 2, '.', ','),
                'balance' => number_format($amount, 2, '.', ',')
            ];

            array_push($schdule, $item);

        }

        return $schdule;

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

    public function paydownSchedule($loans)
    {

        $userId = Auth::user()->id;

        foreach($loans as $loan) {

            $amSchedule = $this->amortizationSchdule($loan->starting_balance, ($loan->interest_rate / 100));

            $loanDataArray = [];

            foreach ($amSchedule as $item) {
                
                $data = [
                    'user_id' => $userId,
                    'loan_id' => $loan->id,
                    'payment' => $item['payment'],
                    'balance' => $item['balance'],
                    'payment_date' => '2020-01-01'
                ];

                array_push($loanDataArray, $data);

            }
                       
            PaydownSchedule::insert($loanDataArray);
        
        }

        $paydown = Paydown::where('user_id', $userId)->get();
        
        dd($paydown);

    }
}

