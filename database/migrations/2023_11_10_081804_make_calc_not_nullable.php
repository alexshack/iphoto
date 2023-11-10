<?php

use App\Contracts\Salary\CalcsContract;
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
        Schema::table(CalcsContract::TABLE, function (Blueprint $table) {
            $table->text(CalcsContract::FIELD_NOTE)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(CalcsContract::TABLE, function (Blueprint $table) {
            //
        });
    }
};
