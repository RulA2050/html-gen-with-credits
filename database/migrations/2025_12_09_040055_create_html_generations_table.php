<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('html_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('library', ['bootstrap', 'tailwind', 'pure', 'custom'])
                ->default('bootstrap');
            $table->enum('status', ['WAITING', 'GENERATING', 'DONE', 'FAILED'])
                ->default('WAITING');
            $table->json('form_payload');
            $table->text('extra_prompt')->nullable();
            $table->mediumText('html_full')->nullable();
            $table->mediumText('css_raw')->nullable();
            $table->mediumText('js_raw')->nullable();
            $table->json('editor_schema')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('html_generations');
    }
};
