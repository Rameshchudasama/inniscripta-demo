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
        Schema::create('gurdian_articles', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();;
            $table->string('section_id');
            $table->string('section_name');
            $table->timestamp('web_publication_date', $precision = 0);
            $table->string('web_title');
            $table->mediumText('web_url')->nullable();;
            $table->mediumText('api_url')->nullable();;
            $table->boolean('is_hosted')->default(false);
            $table->string('pillar_id')->nullable();;
            $table->string('pillar_name')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurdian_articles');
    }
};
