<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->decimal('selling_price',10,0);
            $table->decimal('buying_price',10,0)->nullable();
            $table->integer('stock')->default(0);
            $table->longText('description')->nullable();
            $table->string('image');
            $table->integer('book_page')->default(0)->nullable();
            $table->decimal('weight', 10, 2)->nullable()
                ->default(0.00)
                ->unsigned();
            $table->enum('type_cover',['hard_cover', 'soft_cover']);
            $table->boolean('is_visible')->default(true);
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
            $table->foreign('publisher_id')
                ->references('id')
                ->on('publishers')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};
