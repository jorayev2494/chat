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
        Schema::create('messages', static function (Blueprint $table): void {
            $table->id();

            $table->integer('chat_id');
            $table->foreign('chat_id')->on('chats')->references('id')->cascadeOnDelete();
            $table->integer('user_id');
            $table->foreign('user_id')->on('users')->references('id')->nullOnDelete();            
            $table->string('text')->nullable();
            
            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->on('messages')->references('id');

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
        Schema::dropIfExists('messages');
    }
};
