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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('category', ['house', 'shop', 'home_stay']);
            $table->string('type');
            $table->string('thumbnail');
            $table->string('owner_name')->nullable;
            $table->string('phone');
            $table->string('email');
            $table->string('slug');
            $table->enum('duration_type', ['day', 'month']);
            $table->decimal('price', 10, 2);
            $table->decimal('area', 10, 2);
            $table->boolean('is_boosted')->default(false);
            $table->dateTime('boosted_until')->nullable(); 
            $table->integer('clicks')->default(0);
            $table->boolean('is_rented')->default(false);
            $table->enum('status', ['active', 'expired', 'deleted', 'inactive',])->default('active');
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
