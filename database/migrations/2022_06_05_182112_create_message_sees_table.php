<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('message_sees', static function (Blueprint $table): void {
            $table->id();

            $table->integer('chat_id')->unsigned();
            $table->foreign('chat_id')->on('chats')->references('id')->cascadeOnDelete();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->nullOnDelete();
            $table->integer('message_id')->unsigned();
            $table->boolean('is_seen')->default(false);

            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('message_sees');
    }
};
