<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Money\ExpensesTypeContract;
use App\Contracts\Money\RoleExpensesTypeContract;
use App\Contracts\UserRoleContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(ExpensesTypeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(ExpensesTypeContract::FIELD_NAME);
            $table->integer(ExpensesTypeContract::FIELD_STATUS)->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create(RoleExpensesTypeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(RoleExpensesTypeContract::FIELD_EXPENSES_TYPE_ID);
            $table->unsignedBigInteger(RoleExpensesTypeContract::FIELD_ROLE_ID);
            $table->timestamps();

            $table->foreign(RoleExpensesTypeContract::FIELD_EXPENSES_TYPE_ID)->references(ExpensesTypeContract::FIELD_ID)->on(ExpensesTypeContract::TABLE)->onDelete('cascade');
            $table->foreign(RoleExpensesTypeContract::FIELD_ROLE_ID)->references(UserRoleContract::FIELD_ID)->on(UserRoleContract::TABLE)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists(ExpensesTypeContract::TABLE);
        Schema::dropIfExists(RoleExpensesTypeContract::TABLE);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
