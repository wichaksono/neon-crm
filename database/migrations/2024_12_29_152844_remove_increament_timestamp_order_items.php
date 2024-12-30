<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // First modify the auto-increment column to be a regular integer
            $table->integer('id')->change();

            // Now we can drop the primary key and id
            $table->dropPrimary();
            $table->dropColumn('id');

            // Add composite primary key
            $table->primary(['order_id', 'product_id']);

            // Drop timestamps columns
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop composite primary key
            $table->dropPrimary(['order_id', 'product_id']);

            // Add back the id column as auto-incrementing primary key
            $table->id();

            // Add timestamps columns back
            $table->timestamps();
        });
    }
};
