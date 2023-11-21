<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use DateTime;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $peminjamanSql = new SqlPeminjamanRepository();
            $peminjaman = $peminjamanSql->getAllPeminjaman("SETLED");

            foreach ($peminjaman as $p) {
                $interval = $p->getPaidAt()->diff(new DateTime());
                if ($interval->time > 86400) {
                    $p->setStatus("RETURNED");
                    $peminjamanSql->persist($p);
                }
            }
        })->everyFiveMinutes();
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
