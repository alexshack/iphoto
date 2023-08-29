<?php

use App\Contracts\WorkShift\WorkShiftFinalCashDeskContract;
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
        Schema::create(WorkShiftFinalCashDeskContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(WorkShiftFinalCashDeskContract::FIELD_WORK_SHIFT_ID);
            $table->float(WorkShiftFinalCashDeskContract::FIELD_SUM);
            $table->integer(WorkShiftFinalCashDeskContract::FIELD_SALE_TYPE_ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shift_final_cash_desks');
    }
};
