<?php

namespace App\Services;

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

}

