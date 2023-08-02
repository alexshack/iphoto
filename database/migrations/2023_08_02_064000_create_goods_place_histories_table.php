<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Goods\GoodsPlaceHistoryContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(GoodsPlaceHistoryContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(GoodsPlaceHistoryContract::FIELD_PLACE_ID);
            $table->integer(GoodsPlaceHistoryContract::FIELD_GOODS_ID);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(GoodsPlaceHistoryContract::TABLE);
    }
};
