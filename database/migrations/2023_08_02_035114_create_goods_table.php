<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Goods\GoodsContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(GoodsContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(GoodsContract::FIELD_NAME);
            $table->integer(GoodsContract::FIELD_CATEGORY_ID);
            $table->string(GoodsContract::FIELD_NOTE)->nullable();
            $table->integer(GoodsContract::FIELD_TYPE)->default(GoodsContract::DEFAULT_TYPE);
            $table->float(GoodsContract::FIELD_PRIZE_AMOUNT)->nullable();
            $table->integer(GoodsContract::FIELD_MORE_THAN_ONE)->default(null)->nullable();
            $table->string(GoodsContract::FIELD_SERIAL_NUMBER)->nullable();
            $table->integer(GoodsContract::FIELD_ENTER_READINGS)->default(null)->nullable();
            $table->integer(GoodsContract::FIELD_PLACE_ID)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(GoodsContract::TABLE);
    }
};
