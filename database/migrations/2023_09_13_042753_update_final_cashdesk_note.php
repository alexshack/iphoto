<?php

use App\Contracts\WorkShift\WorkShiftFinalCashDeskContract as Contract;
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
        Schema::table('work_shift_final_cash_desks', function (Blueprint $table) {
            $table->text(Contract::FIELD_NOTE)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_shift_final_cash_desks', function (Blueprint $table) {
            //
        });
    }
};
