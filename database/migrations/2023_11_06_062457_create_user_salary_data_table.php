<?php

use App\Contracts\UserSalaryDataContract;
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
        Schema::create(UserSalaryDataContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE);
            $table->integer(UserSalaryDataContract::FIELD_USER_ID);
            $table->date(UserSalaryDataContract::FIELD_START_DATE);
            $table->float(UserSalaryDataContract::FIELD_AMOUNT)->nullable();
            $table->text(UserSalaryDataContract::FIELD_CUSTOM_DATA)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_salary_data');
    }
};
