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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index()->unique();
            $table->string('subtitle')->nullable();
            $table->string('slug')->index()->unique();
            $table->longText('description');
            $table->string('ISBN_10')->index()->unique();
            $table->string('ISBN_13')->index()->unique();
            $table->decimal('price',10)->index();
            $table->unsignedBigInteger('author_id')->index();
            $table->unsignedBigInteger('publisher_id')->index();
            $table->unsignedBigInteger('stock_quantity')->index();
            $table->enum('status', ['available', 'out_of_stock', 'coming_soon'])->default('available')->index();
            $table->decimal('weight')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('depth')->nullable();
            $table->string('language')->default('english')->index();
            $table->timestamp('publication_date')->useCurrent()->index();
            $table->boolean('is_preorder')->default(false);
            $table->string('binding_type')->default(false);
            $table->unsignedBigInteger('attachment_id')->nullable()->comment('This will be the id of the attachment where cover image of the books will be saved');
            $table->unsignedBigInteger('number_of_pages');
            $table->unsignedBigInteger('created_by')->default(0);
//            $table->string('genre')->nullable()->index();
//            $table->string('series_name')->nullable()->index();
//            $table->unsignedInteger('series_position')->nullable();
//            $table->string('barcode')->nullable()->index();
//            $table->string('age_group')->nullable();
//            $table->json('contributors')->nullable();
//            $table->text('table_of_contents')->nullable();
//            $table->string('sample_pages_link')->nullable();
//            $table->string('region')->nullable()->index();
//            $table->unsignedBigInteger('best_seller_rank')->nullable();
//            $table->boolean('is_digital')->default(false);
//            $table->string('digital_format')->nullable();
//            $table->unsignedBigInteger('file_size')->nullable();
//            $table->string('edition')->nullable();
//            $table->decimal('average_rating', 3)->default(0)->index();
//            $table->unsignedBigInteger('review_count')->default(0);
//            $table->boolean('is_featured')->default(false);
//            $table->string('format')->nullable()->index();
//            $table->json('metadata')->nullable();
//            $table->string('external_link')->nullable();
//            $table->boolean('has_audible')->default(false);
//            $table->string('audible_link')->nullable();
//            $table->string('audible_preview_link')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
