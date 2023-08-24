<?php

namespace App\Console\Commands;

use App\Contracts\Structure\PlaceContract;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Traits\WorkshiftTrait;
use Illuminate\Console\Command;

class WorkShiftCreate extends Command
{
    use WorkshiftTrait;

    private PlaceRepositoryInterface $placeRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:work-shift-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(PlaceRepositoryInterface $placeRepository) {
        $this->placeRepository = $placeRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $places = $this->placeRepository->getOpen();
        foreach ($places as $place) {
            $this->createWorkShiftForPlace($place);
        }
    }
}
