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
        Schema::create('new_york_times_articles', function (Blueprint $table) {
            $table->id();
            $table->mediumText('web_url')->nullable();
            $table->longText('snippet')->nullable();
            $table->longText('lead_paragraph')->nullable();
            $table->string('source');
            $table->string('headline');
            $table->timestamp('publication_date', $precision = 0);
            $table->string('document_type')->nullable();
            $table->string('news_desk')->nullable();
            $table->string('section_name')->nullable();
            $table->string('subsection_name')->nullable();
            $table->string('byline')->nullable();
            $table->string('type_of_material')->nullable();
            $table->integer('word_count')->default(0);
            $table->mediumText('uri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_york_times_articles');
    }
};
