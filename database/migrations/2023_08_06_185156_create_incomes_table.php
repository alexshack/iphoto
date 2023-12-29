<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Money\IncomeContract;
use Illuminate\Support\Facades\DB;
use App\Contracts\Money\IncomesTypeContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(IncomeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->dateTime(IncomeContract::FIELD_DATE)->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->foreignId(IncomeContract::FIELD_TYPE_ID)
                ->references(IncomesTypeContract::FIELD_ID)
                ->on(IncomesTypeContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId(IncomeContract::FIELD_CITY_ID)
                ->references(CityContract::FIELD_ID)
                ->on(CityContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId(IncomeContract::FIELD_PLACE_ID)
                ->nullable()
                ->references(PlaceContract::FIELD_ID)
                ->on(PlaceContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId(IncomeContract::FIELD_MANAGER_ID)
                ->nullable()
                ->references(UserContract::FIELD_ID)
                ->on(UserContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer(IncomeContract::FIELD_TYPE)->default(1);
            $table->float(IncomeContract::FIELD_AMOUNT);
            $table->string(IncomeContract::FIELD_NOTE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(IncomeContract::TABLE);
    }
};
