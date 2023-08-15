<?php

use App\Contracts\WorkShift\WorkShiftGoodsContract;
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
        Schema::create('work_shift_goods', function (Blueprint $table) {
            $table->id();
            $table->integer(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID);
            $table->integer(WorkShiftGoodsContract::FIELD_EMPLOYEE_ID)->nullable();
            $table->integer(WorkShiftGoodsContract::FIELD_GOOD_ID);
            $table->float(WorkShiftGoodsContract::FIELD_QTY)->nullable();
            $table->float(WorkShiftGoodsContract::FIELD_PRICE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shift_goods');
    }
};
