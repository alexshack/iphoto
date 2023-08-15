<?php

use App\Contracts\Salary\CalcsContract;
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
        Schema::create('calcs', function (Blueprint $table) {
            $table->id();
            $table->date(CalcsContract::FIELD_DATE);
            $table->integer(CalcsContract::FIELD_TYPE_ID);
            $table->integer(CalcsContract::FIELD_CITY_ID);
            $table->integer(CalcsContract::FIELD_TYPE);
            $table->integer(CalcsContract::FIELD_PLACE_ID);
            $table->integer(CalcsContract::FIELD_USER_ID);
            $table->integer(CalcsContract::FIELD_AGENT_ID)->nullable();
            $table->float(CalcsContract::FIELD_AMOUNT);
            $table->string(CalcsContract::FIELD_NOTE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calcs');
    }
};
