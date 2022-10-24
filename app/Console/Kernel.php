<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $orders = DB::table('orders')
                            ->select('id')
                            ->where('status_id', 1)
                            ->where('created_at', '<=', Carbon::yesterday())
                            ->whereNotIn('id', DB::table('suborders')
                                                    ->select(DB::raw('DISTINCT(order_id)'))
                                        )
                            ->get()
                            ->all();
            DB::table('orders')->where('status_id', 1)->whereIn('id', $orders)->delete();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
