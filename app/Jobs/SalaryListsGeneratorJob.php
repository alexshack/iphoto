<?php

namespace App\Jobs;

use App\Contracts\Service\PaysGeneratorContract;
use App\Http\Controllers\Salary\PayCalculateController;
use App\Http\Controllers\Service\ExcelGeneratorController;
use App\Models\Service\PaysGenerator;
use App\Models\User;
use Auth;
use Carbon\Carbon;
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
        $user = User::find($this->paysGenerator->{PaysGeneratorContract::FIELD_USER_ID});
        Auth::setUser($user);
        $month = $this->paysGenerator->{PaysGeneratorContract::FIELD_MONTH};
        $year = $this->paysGenerator->{PaysGeneratorContract::FIELD_YEAR};
        app(PayCalculateController::class)->calculatePayments($month, $year);
        app(ExcelGeneratorController::class)->generatePaysLists($month, $year);
        $this->paysGenerator->{PaysGeneratorContract::FIELD_COMPLETED_AT} = Carbon::now();
        $this->paysGenerator->save();
    }
}
