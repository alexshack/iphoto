<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Contracts\Structure\PlaceCalcContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(PlaceCalcContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(PlaceCalcContract::FIELD_PLACE_ID);
            $table->integer(PlaceCalcContract::FIELD_CALCS_TYPE_ID);
            $table->dateTime(PlaceCalcContract::FIELD_START_DATE)->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->dateTime(PlaceCalcContract::FIELD_END_DATE)->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PlaceCalcContract::TABLE);
    }
};
