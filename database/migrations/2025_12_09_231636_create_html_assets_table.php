<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('html_assets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama human readable, contoh: "Bootstrap 5 CSS"
            $table->string('logical_key')->nullable();
            // logical_key dipakai untuk mapping dari AI:
            // contoh: "fontawesome", "swiper", "aos", "gsap"
            // Boleh null untuk asset default per-library (bootstrap/tailwind).

            $table->enum('library', ['bootstrap', 'tailwind', 'pure', 'custom', 'global'])
                  ->default('global');

            $table->enum('type', ['css', 'js']); // jenis asset
            $table->string('url');               // CDN URL

            $table->enum('position', ['head', 'body_end'])
                  ->default('head'); // load di <head> atau sebelum </body>

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('html_assets');
    }
};
