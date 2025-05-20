<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transfer_requests', function (Blueprint $table) {
            $table->string('current_department')->nullable()->after('current_institution');
            $table->string('current_faculty')->nullable()->after('current_department');
            $table->string('current_specialization')->nullable()->after('current_faculty');
        });
    }

    public function down()
    {
        Schema::table('transfer_requests', function (Blueprint $table) {
            $table->dropColumn(['current_department', 'current_faculty', 'current_specialization']);
        });
    }
}; 