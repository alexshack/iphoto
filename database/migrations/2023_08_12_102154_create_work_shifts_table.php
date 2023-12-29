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
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->id();
            $table->date(WorkShiftContract::FIELD_DATE);
            $table->integer(WorkShiftContract::FIELD_CITY_ID);
            $table->integer(WorkShiftContract::FIELD_PLACE_ID);
            $table->boolean(WorkShiftContract::FIELD_CLOSED)->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shifts');
    }
};
