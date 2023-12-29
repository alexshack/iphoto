<?php

use App\Contracts\Goods\GoodsPlaceHistoryContract;
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
        Schema::table(GoodsPlaceHistoryContract::TABLE, function (Blueprint $table) {
            $table->text(GoodsPlaceHistoryContract::FIELD_NOTE)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(GoodsPlaceHistoryContract::TABLE, function (Blueprint $table) {
            //
        });
    }
};
