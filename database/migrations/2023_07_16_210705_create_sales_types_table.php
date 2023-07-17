<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Money\SalesTypeContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SalesTypeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(SalesTypeContract::FIELD_NAME);
            $table->integer(SalesTypeContract::FIELD_RECIPIENT)->default(1);
            $table->float(SalesTypeContract::FIELD_VALUE)->nullable();
            $table->integer(SalesTypeContract::FIELD_STATUS)->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SalesTypeContract::TABLE);
    }
};
