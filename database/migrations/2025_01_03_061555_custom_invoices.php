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
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('issue_date');
            $table->dropColumn('status');

            $table->string('payment_method')->after('total_amount');
            $table->string('payment_method_name')
                ->after('payment_method')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('issue_date');
            $table->string('status');

            $table->dropColumn(['payment_method', 'payment_method_name']);
        });
    }
};
