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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer("category_id");
            $table->integer("author_id");
            $table->string("course_title");
            $table->longText("course_description");
            $table->string("course_image")->nullable();
            $table->integer("course_duration");
            $table->integer("course_price");
            $table->longText("course_about");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
