<?php

namespace App\Console\Commands;

use App\Helpers\ReportHelper;
use App\Repositories\Interfaces\ReportsRepositoryInterface;
use Illuminate\Console\Command;

class GenerateReport extends Command
{

    protected ReportsRepositoryInterface $reportsRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-report {reportID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force generate report';

    public function __construct(ReportsRepositoryInterface $reportsRepository)
    {
        parent::__construct();
        $this->reportsRepository = $reportsRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $report = $this->reportsRepository->find($this->argument('reportID'));
        if ($report) {
            ReportHelper::generateReport($report);
        }
    }
}
