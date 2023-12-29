<?php

namespace App\Console\Commands;

use App\Http\Controllers\Money\Workshift\WorkShiftController;
use App\Helpers\WorkShiftHelper;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CloseWorkShift extends Command
{
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(WorkShiftRepositoryInterface $workShiftRepo) {
        parent::__construct();
        $this->workShiftRepo = $workShiftRepo;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-work-shift {workShiftID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close workshift';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $workShiftID = $this->argument('workShiftID');
        $workShift = $this->workShiftRepo->find($workShiftID);
        app(WorkShiftController::class)->closeAction($workShift);
    }
}
