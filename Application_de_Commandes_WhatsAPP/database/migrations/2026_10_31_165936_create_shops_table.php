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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                  $table->string('slug')->unique();
                  $table->string('nom');
                  $table->string('whatsapp');
                  $table->string('couleur')->default('#16a34a');
                  $table->text('description')->nullable();
                  $table->string('statut_abonnement')->default('essai');
                  $table->dateTime('expire_le')->nullable();
                       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
