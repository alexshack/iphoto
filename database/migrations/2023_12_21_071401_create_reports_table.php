<?php

use App\Contracts\Service\ReportContract;
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
        Schema::create(ReportContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(ReportContract::FIELD_TYPE);
            $table->integer(ReportContract::FIELD_USER_ID);
            $table->dateTime(ReportContract::FIELD_COMPLETED_AT)->nullable();
            $table->longText(ReportContract::FIELD_CUSTOM_DATA)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ReportContract::TABLE);
    }
};
