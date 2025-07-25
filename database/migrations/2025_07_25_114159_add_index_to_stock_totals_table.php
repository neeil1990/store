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
        Schema::table('stock_totals', function (Blueprint $table) {
            $table->index(['assortmentId', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_totals', function (Blueprint $table) {
            $table->dropIndex(['assortmentId', 'created_at']);
        });
    }
};
