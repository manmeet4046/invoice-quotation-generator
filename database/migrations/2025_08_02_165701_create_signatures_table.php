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
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies', 'id')
                ->cascadeOnDelete();
             $table->enum('signature_type', [
                'proprietor',
                'director',
                'authorized_signatory',
                'business_head',
                'manager',
                'partner',
                'ceo'
            ])->nullable();
             $table->string('signature_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
