<?php

namespace App\Console;

use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {

            try {
                $body = json_encode(["count" => 900, "availableTaps" => 1500, "timestamp" => time()]);

                $client = new \GuzzleHttp\Client();
                $client->request('POST', 'https://api.hamsterkombatgame.io/clicker/tap', [
                    'body' => $body,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'authorization' => 'Bearer 1723278951750H45BhuOUH0fPhEhxeqyBHhtc95bNbO0xklQDy5O8RKIM2FzU2IzWrhSOmJ3P1we4238244752',
                    ],
                ]);
            } catch (Exception $exception) { }

        })->everyFiveMinutes();

        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
