<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\CityManagerContract;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(CityContract::TABLE, function (Blueprint $table) {
            $table->integer(CityContract::FIELD_MANAGER_ID)->nullable();
            $table->dateTime(CityContract::FIELD_OPENING_DATE)->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
        });
        Schema::create(CityManagerContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(CityManagerContract::FIELD_CITY_ID);
            $table->integer(CityManagerContract::FIELD_MANAGER_ID);
            $table->dateTime(CityManagerContract::FIELD_APPOINTMENT_DATE)->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(CityContract::TABLE, function (Blueprint $table) {
            $table->dropColumn(CityContract::FIELD_MANAGER_ID);
            $table->dropColumn(CityContract::FIELD_OPENING_DATE);
        });
        Schema::dropIfExists(CityManagerContract::TABLE);
    }
};
