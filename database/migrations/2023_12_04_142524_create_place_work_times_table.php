<?php

use App\Contracts\Structure\PlaceWorkTimeContract as Contract;
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
        Schema::create(Contract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(Contract::FIELD_PLACE_ID);
            $table->integer(Contract::FIELD_WEEK_DAY);
            $table->time(Contract::FIELD_START_TIME)->nullable();
            $table->time(Contract::FIELD_END_TIME)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_work_times');
    }
};
