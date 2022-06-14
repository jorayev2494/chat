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
        Schema::create('chats', static function (Blueprint $table): void {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->nullOnDelete();
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->on('chat_statuses')->references('id');
            $table->softDeletes();

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
        Schema::dropIfExists('chats');
    }
};
