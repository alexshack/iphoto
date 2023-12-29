<?php

use App\Contracts\WorkShift\WorkShiftEmployeeContract as Contract;
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
        Schema::create('work_shift_employees', function (Blueprint $table) {
            $table->id();
            $table->integer(Contract::FIELD_WORK_SHIFT_ID);
            $table->integer(Contract::FIELD_POSITION_ID)->nullable();
            $table->dateTime(Contract::FIELD_START_TIME)->nullable();
            $table->dateTime(Contract::FIELD_END_TIME)->nullable();
            $table->integer(Contract::FIELD_WORK_TIME)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shift_employees');
    }
};
