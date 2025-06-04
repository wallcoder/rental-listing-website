<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop old columns
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');

            $table->dropForeign(['post_id']);
            $table->dropColumn('post_id');

            $table->dropColumn('failure_reason');
            $table->dropColumn('purpose');

            // Add new booking_id foreign key
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Rollback changes
            $table->dropForeign(['booking_id']);
            $table->dropColumn('booking_id');

            $table->enum('purpose', ['subscription', 'listing_feature']);
            $table->foreignId('plan_id')->nullable()->constrained('plans')->onDelete('set null');
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('set null');
            $table->string('failure_reason')->nullable();
        });
    }
};
