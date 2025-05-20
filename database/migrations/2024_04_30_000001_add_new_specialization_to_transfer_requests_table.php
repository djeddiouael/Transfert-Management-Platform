<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Schema::table('transfer_requests', function (Blueprint $table) {
        //     $table->string('specialization_new')->nullable();
        // });

        // Copier les données de l'ancienne colonne vers la nouvelle
        // DB::table('transfer_requests')->update([
        //     'specialization_new' => DB::raw('specialization')
        // ]);

        // Supprimer l'ancienne colonne
        // Schema::table('transfer_requests', function (Blueprint $table) {
        //     $table->dropColumn('specialization');
        // });

        // // Renommer la nouvelle colonne
        // Schema::table('transfer_requests', function (Blueprint $table) {
        //     $table->renameColumn('specialization_new', 'specialization');
        // });
    }

    public function down()
    {
        // Schema::table('transfer_requests', function (Blueprint $table) {
        //     $table->string('specialization')->nullable(false)->change();
        // });
    }
};
