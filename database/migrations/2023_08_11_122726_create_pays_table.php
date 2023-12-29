<?php

use App\Contracts\Salary\PaysContract;
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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->date(PaysContract::FIELD_DATE);
            $table->date(PaysContract::FIELD_BILLING_MONTH);
            $table->integer(PaysContract::FIELD_TYPE_ID);
            $table->integer(PaysContract::FIELD_CITY_ID);
            $table->integer(PaysContract::FIELD_TYPE);
            $table->integer(PaysContract::FIELD_SOURCE_TYPE);
            $table->integer(PaysContract::FIELD_SOURCE_ID);
            $table->integer(PaysContract::FIELD_PLACE_ID);
            $table->integer(PaysContract::FIELD_USER_ID);
            $table->integer(PaysContract::FIELD_AGENT_ID)->nullable();
            $table->float(PaysContract::FIELD_AMOUNT)->nullable();
            $table->string(PaysContract::FIELD_NOTE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};
