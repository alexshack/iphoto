<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Structure\PlaceContract;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(PlaceContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(PlaceContract::FIELD_NAME);
            $table->integer(PlaceContract::FIELD_CITY_ID);
            $table->dateTime(PlaceContract::FIELD_OPENING_DATE)->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->float(PlaceContract::FIELD_CURRENT_BALANCE)->default(0);
            $table->integer(PlaceContract::FIELD_STATUS)->default(PlaceContract::DEFAULT_STATUS);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PlaceContract::TABLE);
    }
};
