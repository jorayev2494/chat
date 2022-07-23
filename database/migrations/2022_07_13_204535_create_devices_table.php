<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('devices', static function (Blueprint $table): void {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete();

            $table->string('refresh_token')->unique();
            $table->string('device_id');
            $table->string('device_name');
            $table->string('user_agent')->nullable();
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->string('ip_address', 20)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('ws_token', 50)->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
