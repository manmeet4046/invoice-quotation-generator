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
        Schema::create('seals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies', 'id')
                ->cascadeOnDelete();
              $table->enum('seal_type', [
                'proprietor',
                'director',
                'company_seal',
                'business_head',
                'authorized_signatory',
                'manager',
                'stamp_only'
            ])->nullable();
            $table->string('seal_path')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seals');
    }
};
