<?php

namespace App\Console\Commands;

use App\Helpers\WorkShiftHelper;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Console\Command;

class WorkShiftStats extends Command
{
    private WorkShiftRepositoryInterface $repo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:work-shift-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display today workshift stats';

    public function __construct(WorkShiftRepositoryInterface $repo) {
        $this->repo = $repo;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $workshifts = $this->repo->getToday();
        foreach ($workshifts as $workshift) {
            $this->info("{$workshift->city->name} -> {$workshift->place->name}");
            $stats = WorkShiftHelper::recalculateStats($workshift);
            $statsTable = [];
            foreach ($stats as $key => $value) {
                $statsTable[] = [
                    'name' => $key,
                    'value' => $value,
                ];
            }
            $this->table(['name', 'value'], $statsTable);
            $this->newLine();
        }
    }
}
