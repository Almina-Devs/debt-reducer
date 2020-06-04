<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\BuildAmortizationSchedule;
use App\Models\Loan;
use App\Services\Calculator;

class BuildSchedule implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->calc = new Calculator();
    }

    /**
     * Handle the event.
     *
     * @param  BuildAmortizationSchedule  $event
     * @return void
     */
    public function handle(BuildAmortizationSchedule $event)
    {
        $loan = Loan::where('id', $event->loanId)->first();
        $this->calc->makeAmortizationSchdule(
            $loan->id,
            $loan->starting_balance,
            ($loan->interest_rate / 100)
        );
    }
}
