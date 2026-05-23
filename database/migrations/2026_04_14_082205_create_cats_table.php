<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cats', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('age')->nullable();
            $table->string('gender');
            $table->string('breed')->default('Abyssin');
            $table->string('color')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available')->index();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
