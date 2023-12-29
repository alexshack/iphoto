<?php

use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_shift_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->integer(WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID);
            $table->float(WorkShiftWithdrawalContract::FIELD_SUM);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shift_withdrawals');
    }
};
