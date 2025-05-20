<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transfer_requests', function (Blueprint $table) {
            $table->enum('transfer_type', ['internal', 'faculty', 'department', 'external'])
                  ->after('student_id')
                  ->nullable();
        });
    }

    public function down()
    {
        Schema::table('transfer_requests', function (Blueprint $table) {
            $table->dropColumn('transfer_type');
        });
    }
}; 