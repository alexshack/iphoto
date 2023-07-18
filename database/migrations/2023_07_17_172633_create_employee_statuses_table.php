<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Salary\EmployeeStatusContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(EmployeeStatusContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(EmployeeStatusContract::FIELD_NAME);
            $table->integer(EmployeeStatusContract::FIELD_STATUS)->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(EmployeeStatusContract::TABLE);
    }
};
