<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('source_id');
            $table->string('source_name');
            $table->string('author')->nullable();;
            $table->string('title');
            $table->longText('description')->nullable();;
            $table->mediumText('url')->nullable();;
            $table->mediumText('url_to_image')->nullable();;
            $table->timestamp('published_at', $precision = 0);
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
