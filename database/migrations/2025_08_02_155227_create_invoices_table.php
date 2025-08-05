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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

           
    // Link to company
    $table->foreignId('company_id')->constrained()->cascadeOnDelete();

    // Invoice metadata
    $table->string('invoice_number')->unique();
    $table->date('invoice_date')->nullable();
    $table->date('order_date')->nullable();
    $table->string('order_number')->nullable();

    // Billing snapshot (for archiving at time of invoice)
    $table->string('billing_name')->nullable();
    $table->string('billing_email')->nullable();
    $table->text('billing_address')->nullable();
    $table->string('billing_gstin')->nullable();

    // Tax & charges
    $table->enum('tax_type', ['GST', 'IGST', 'CGST_SGST'])->default('GST');
    $table->decimal('tax_rate', 5, 2)->default(18.00); // Percent
    $table->decimal('shipping_charges', 10, 2)->default(0);
    $table->decimal('round_off', 10, 2)->default(0);

    // Archived totals (for accurate record keeping)
    $table->decimal('subtotal', 10, 2)->default(0);
    $table->decimal('total_discount', 10, 2)->default(0);
    $table->decimal('tax_amount', 10, 2)->default(0);
    $table->decimal('grand_total', 10, 2)->default(0);

    // Payment and compliance
    $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
    $table->date('due_date')->nullable();
    $table->string('pdf_path')->nullable();
    $table->boolean('is_emailed')->default(false);

    $table->text('override_terms_and_conditions')->nullable();
    $table->text('legal_notes')->nullable();
          
            

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
