<?php

use App\Contracts\Money\MovesContract;
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
        Schema::create('moves', function (Blueprint $table) {
            $table->id();
            $table->date(MovesContract::FIELD_DATE);
            $table->string(MovesContract::FIELD_PAYER_TYPE, 50);
            $table->integer(MovesContract::FIELD_PAYER_ID);
            $table->string(MovesContract::FIELD_RECIPIENT_TYPE, 50);
            $table->integer(MovesContract::FIELD_RECIPIENT_ID);
            $table->integer(MovesContract::FIELD_CITY_ID);
            $table->float(MovesContract::FIELD_AMOUNT);
            $table->text(MovesContract::FIELD_NOTE)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moves');
    }
};
