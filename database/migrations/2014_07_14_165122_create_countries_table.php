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
        Schema::create('countries', static function (Blueprint $table): void {
            $table->id();

            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('phone_code')->nullable();
            $table->string('flag')->nullable()->unique();
            $table->string('flag_png')->nullable();
            $table->string('flag_svg')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
