<?php

namespace App\Jobs;

use App\Contracts\Service\PaysGeneratorContract;
use App\Http\Controllers\Salary\PayCalculateController;
use App\Models\Service\PaysGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SalaryListsGeneratorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected PaysGenerator $paysGenerator;

    /**
     * Create a new job instance.
     */
    public function __construct(PaysGenerator $paysGenerator)
    {
        $this->paysGenerator = $paysGenerator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $month = $this->paysGenerator->{PaysGeneratorContract::FIELD_MONTH};
        $year = $this->paysGenerator->{PaysGeneratorContract::FIELD_YEAR};
        app(PayCalculateController::class)->calculatePayments($month, $year);
    }
}
