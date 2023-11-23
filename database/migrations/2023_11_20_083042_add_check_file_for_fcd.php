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
        Schema::table(WorkShiftFinalCashDeskContract::TABLE, function ($table) {
            $table->text(WorkShiftFinalCashDeskContract::FIELD_CHECK_FILE)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
