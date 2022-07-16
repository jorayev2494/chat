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
        Schema::create('user_codes', static function (Blueprint $table): void {
            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete();

            $table->string('type')->nullable();
            $table->integer('code')->unique();
            $table->timestamp('expired_at');

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
        Schema::dropIfExists('codes');
    }
};
