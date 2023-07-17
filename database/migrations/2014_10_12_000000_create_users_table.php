<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\UserWorkDataContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(UserContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(UserContract::FIELD_EMAIL)->unique();
            $table->timestamp(UserContract::FIELD_EMAIL_VERIFIED_AT)->nullable();
            $table->string(UserContract::FIELD_PASSWORD);
            $table->string(UserContract::FIELD_PHOTO)->nullable();
            $table->integer(UserContract::FIELD_STATUS)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create(UserPersonalDataContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(UserPersonalDataContract::FIELD_USER_ID)
                ->constrained(UserContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string(UserPersonalDataContract::FIELD_LAST_NAME)->nullable();
            $table->string(UserPersonalDataContract::FIELD_FIRST_NAME)->nullable();
            $table->string(UserPersonalDataContract::FIELD_MIDDLE_NAME)->nullable();
            $table->string(UserPersonalDataContract::FIELD_PHONE)->nullable();
            $table->string(UserPersonalDataContract::FIELD_PHONE_ADDITIONAL)->nullable();
            $table->timestamp(UserPersonalDataContract::FIELD_BIRTHDAY)->nullable();
            $table->integer(UserPersonalDataContract::FIELD_GENDER)->default(1);
            $table->integer(UserPersonalDataContract::FIELD_MARITAL_STATUS)->default(1);
            $table->integer(UserPersonalDataContract::FIELD_EDUCATION)->default(1);
            $table->string(UserPersonalDataContract::FIELD_EMAIL)->nullable();
            $table->text(UserPersonalDataContract::FIELD_REGISTERED_ADDRESS)->nullable();
            $table->text(UserPersonalDataContract::FIELD_ADDRESS)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create(UserWorkDataContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(UserWorkDataContract::FIELD_USER_ID)
                ->constrained(UserContract::TABLE)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer(UserWorkDataContract::FIELD_CITY_ID)->nullable();
            $table->integer(UserWorkDataContract::FIELD_POSITION_ID)->nullable();
            $table->integer(UserWorkDataContract::FIELD_STATUS)->default(1);
            $table->date(UserWorkDataContract::FIELD_DATE_OF_EMPLOYMENT)->nullable();
            $table->date(UserWorkDataContract::FIELD_DATE_OF_TERMINATION)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists(UserContract::TABLE);
        Schema::dropIfExists(UserPersonalDataContract::TABLE);
        Schema::dropIfExists(UserWorkDataContract::TABLE);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
