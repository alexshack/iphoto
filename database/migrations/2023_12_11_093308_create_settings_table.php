<?php

use App\Contracts\SettingContract;
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
        Schema::create(SettingContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(SettingContract::FIELD_NAME);
            $table->text(SettingContract::FIELD_VALUE)->nullable();
            $table->integer(SettingContract::FIELD_TYPE)->default(1);
            $table->string(SettingContract::FIELD_MODEL)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
