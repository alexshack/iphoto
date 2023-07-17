<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Money\IncomesTypeContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(IncomesTypeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(IncomesTypeContract::FIELD_NAME);
            $table->integer(IncomesTypeContract::FIELD_STATUS)->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(IncomesTypeContract::TABLE);
    }
};
