<?php

use App\Contracts\Goods\GoodsContract;
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
        Schema::table(GoodsContract::TABLE, function (Blueprint $table) {
            $table->text(GoodsContract::FIELD_COMMENT)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
