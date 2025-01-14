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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('type', 50);
            $table->string('status', 50);
            $table->string('priority', 50);
            $table->string('assigned_type', 50);
            $table->unsignedBigInteger('assigned_to');

            $table->dateTime('start_date')->nullable();
            $table->dateTime('reminder_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->tinyInteger('order_index')->default(0);
            $table->tinyInteger('depth')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('tag_id')->references('id')->on('note_tags')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('tasks')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
