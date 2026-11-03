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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
             $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
              $table->string('nom');
              $table->unsignedInteger('prix');
              $table->unsignedInteger('stock')->default(0);
               $table->text('description')->nullable();
                $table->string('image')->nullable();
                 $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
