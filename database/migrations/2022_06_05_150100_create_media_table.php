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
        Schema::create('medias', static function (Blueprint $table): void {
            $table->id();

            // $table->integer('user_id')->unsigned();
            // $table->foreign('user_id')->on('users')->references('id')->nullOnDelete();
            $table->integer('media_able_id');
            $table->string('media_able_type');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('path');
            $table->string('mime_type');
            $table->string('type');
            $table->string('extension');
            $table->string('size');
            $table->string('user_file_name');
            $table->string('name');
            $table->string('full_path');
            $table->string('url');
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
        Schema::dropIfExists('media');
    }
};
