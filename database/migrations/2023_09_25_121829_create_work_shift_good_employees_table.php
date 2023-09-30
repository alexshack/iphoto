<?php

use App\Contracts\WorkShift\WorkShiftGoodEmployeeContract;
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
        Schema::create(WorkShiftGoodEmployeeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(WorkShiftGoodEmployeeContract::FIELD_EMPLOYEE_ID);
            $table->integer(WorkShiftGoodEmployeeContract::FIELD_WORK_SHIFT_GOOD_ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(WorkShiftGoodEmployeeContract::TABLE);
    }
};
