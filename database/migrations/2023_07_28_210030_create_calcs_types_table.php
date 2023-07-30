<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Salary\CalcsTypeContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(CalcsTypeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(CalcsTypeContract::FIELD_NAME);
            $table->integer(CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION)->default(null)->nullable();
            $table->integer(CalcsTypeContract::FIELD_SALARY_PAYMENT)->default(null)->nullable();
            $table->integer(CalcsTypeContract::FIELD_TYPE)->default(CalcsTypeContract::DEFAULT_TYPE);
            $table->text(CalcsTypeContract::FIELD_CUSTOM_DATA)->nullable();
            $table->integer(CalcsTypeContract::FIELD_STATUS)->default(CalcsTypeContract::DEFAULT_STATUS);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(CalcsTypeContract::TABLE);
    }
};
