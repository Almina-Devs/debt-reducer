<?php

namespace App\Listeners;

use App\Events\BuildPaydownSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BuildPaydown
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BuildPaydownSchedule  $event
     * @return void
     */
    public function handle(BuildPaydownSchedule $event)
    {
        //
    }
}
