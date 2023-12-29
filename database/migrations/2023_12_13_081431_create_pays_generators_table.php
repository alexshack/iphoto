<?php

use App\Contracts\Service\PaysGeneratorContract;
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
        Schema::create(PaysGeneratorContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->dateTime(PaysGeneratorContract::FIELD_COMPLETED_AT)->nullable();
            $table->integer(PaysGeneratorContract::FIELD_MONTH);
            $table->integer(PaysGeneratorContract::FIELD_YEAR);
            $table->integer(PaysGeneratorContract::FIELD_USER_ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PaysGeneratorContract::TABLE);
    }
};
