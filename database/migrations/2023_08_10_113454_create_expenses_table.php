<?php

use App\Contracts\Money\ExpenseContract;
use App\Contracts\Money\ExpensesTypeContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date(ExpenseContract::FIELD_DATE)->nullable();
            $table->foreignId(ExpenseContract::FIELD_TYPE_ID)
                ->references(ExpensesTypeContract::FIELD_ID)
                ->on(ExpensesTypeContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId(ExpenseContract::FIELD_CITY_ID)
                ->references(CityContract::FIELD_ID)
                ->on(CityContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId(ExpenseContract::FIELD_PLACE_ID)
                ->nullable()
                ->references(PlaceContract::FIELD_ID)
                ->on(PlaceContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId(ExpenseContract::FIELD_MANAGER_ID)
                ->nullable()
                ->references(UserContract::FIELD_ID)
                ->on(UserContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer(ExpenseContract::FIELD_TYPE)->default(1);
            $table->float(ExpenseContract::FIELD_AMOUNT);
            $table->string(ExpenseContract::FIELD_NOTE);
            $table->string(ExpenseContract::FIELD_CHECK_FILE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
