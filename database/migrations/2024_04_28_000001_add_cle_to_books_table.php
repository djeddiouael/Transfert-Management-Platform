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
        if (!Schema::hasColumn('books', 'CLE')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('CLE')->nullable()->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('books', 'CLE')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('CLE');
            });
        }
    }
};
