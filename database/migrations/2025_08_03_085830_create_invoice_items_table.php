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
        Schema::create('invoice_items', function (Blueprint $table) {
             $table->id();
    $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();

    $table->string('item_name');
     $table->string('item_description');
    
    $table->integer('quantity')->default(1);
    $table->decimal('rate', 10, 2)->default(0);
    $table->decimal('discount', 10, 2)->default(0); // per item
    $table->decimal('total', 10, 2)->default(0);    // (qty * rate) - discount

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
