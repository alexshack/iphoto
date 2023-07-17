<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\UserRoleContract;
use App\Contracts\UserContract;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(UserRoleContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(UserRoleContract::FIELD_SLUG);
            $table->string(UserRoleContract::FIELD_NAME);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table(UserContract::TABLE, function (Blueprint $table) {
            $table->integer(UserContract::FIELD_ROLE_ID)->default(1)->after(UserContract::FIELD_STATUS);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UserRoleContract::TABLE);
        Schema::table(UserContract::TABLE, function (Blueprint $table) {
            $table->dropColumn(UserContract::FIELD_ROLE_ID);
        });
    }
};
