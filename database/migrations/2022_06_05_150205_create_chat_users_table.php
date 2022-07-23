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
        Schema::create('users_chats', static function (Blueprint $table): void {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->nullOnDelete();
            $table->integer('chat_id')->unsigned();
            $table->foreign('chat_id')->on('chats')->references('id')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->boolean('is_private')->default(false);
            
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
        Schema::dropIfExists('chat_users');
    }
};
