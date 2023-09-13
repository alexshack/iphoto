<?php

use App\Contracts\WorkShift\WorkShiftGoodsContract as Contract;
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
        Schema::table('work_shift_goods', function (Blueprint $table) {
            $table->float(Contract::FIELD_ON_START)->nullable();
            $table->float(Contract::FIELD_ON_END)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_shift_goods', function (Blueprint $table) {
            //
        });
    }
};
