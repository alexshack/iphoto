<?php

use App\Contracts\WorkShift\WorkShiftPayrollContract;
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
        Schema::create(WorkShiftPayrollContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID);
            $table->integer(WorkShiftPayrollContract::FIELD_EMPLOYEE_ID);
            $table->integer(WorkShiftPayrollContract::FIELD_CALC_TYPE_ID);
            $table->integer(WorkShiftPayrollContract::FIELD_WORK_SHIFT_GOOD_ID)->nullable();
            $table->float(WorkShiftPayrollContract::FIELD_AMOUNT);
            $table->text(WorkShiftPayrollContract::FIELD_CUSTOM_DATA)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shift_payrolls');
    }
};
