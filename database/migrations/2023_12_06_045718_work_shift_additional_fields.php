<?php

use App\Contracts\WorkShift\WorkShiftContract;
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
        Schema::table(WorkShiftContract::TABLE, function (Blueprint $table) {
            $table->integer(WorkShiftContract::FIELD_VISITORS_TOTAL)->nullable();
            $table->float(WorkShiftContract::FIELD_CHECK_AVERAGE)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ww', function (Blueprint $table) {
            //
        });
    }
};
