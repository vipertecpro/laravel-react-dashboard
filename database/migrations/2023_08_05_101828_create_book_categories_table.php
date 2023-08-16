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
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->string('icon_file_path')->nullable();
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->tinyInteger('is_active')->default(1)->comment('Default : 1 means active and 0 means inactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_categories');
    }
};
