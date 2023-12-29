<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Goods\GoodsCategoryContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(GoodsCategoryContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(GoodsCategoryContract::FIELD_NAME);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(GoodsCategoryContract::TABLE);
    }
};
