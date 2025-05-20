<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transfer_request_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_request_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'accepted', 'rejected']);
            $table->text('notes')->nullable();
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('changed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfer_request_status_history');
    }
}; 