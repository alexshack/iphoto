<?php

use App\Contracts\UserWorkDataContract;
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
        Schema::table(UserWorkDataContract::TABLE, function (Blueprint $table) {
            $table->float(UserWorkDataContract::FIELD_CURRENT_BALANCE)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(UserWorkDataContract::TABLE, function (Blueprint $table) {
        });
    }
};
