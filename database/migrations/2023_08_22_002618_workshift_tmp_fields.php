<?php

use App\Contracts\WorkShift\WorkShiftContract;
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
        Schema::table('work_shifts', function (Blueprint $table) {
            $table->float(WorkShiftContract::FIELD_TOTAL_SALES)->nullable();
            $table->float(WorkShiftContract::FIELD_EXPENSES)->nullable();
            $table->float(WorkShiftCOntract::FIELD_SALARY)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_shift_employees', function (Blueprint $table) {
            //
        });
    }
};
