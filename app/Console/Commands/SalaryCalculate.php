<?php

namespace App\Console\Commands;

use App\Http\Controllers\Salary\PayCalculateController;
use App\Http\Controllers\Service\ExcelGeneratorController;
use Illuminate\Console\Command;

class SalaryCalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:salary-calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $month = 12;
        $year = 2023;

        app(PayCalculateController::class)->calculatePayments($month, $year);
        app(ExcelGeneratorController::class)->generatePaysLists($month, $year);
    }
}
