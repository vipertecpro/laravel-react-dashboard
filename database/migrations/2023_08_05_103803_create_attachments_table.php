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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->unsignedBigInteger('type_id')->index();
            $table->string('original_file_name')->index();
            $table->string('file_name')->index();
            $table->string('file_path')->index();
            $table->string('file_size')->index();
            $table->string('file_extension')->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
