<?php

use App\Contracts\WorkShift\WorkShiftVisitorContract;
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
        Schema::create(WorkShiftVisitorContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(WorkShiftVisitorContract::FIELD_WORK_SHIFT_ID);
            $table->integer(WorkShiftVisitorContract::FIELD_TYPE);
            $table->integer(WorkShiftVisitorContract::FIELD_TOTAL)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shift_visitors');
    }
};
