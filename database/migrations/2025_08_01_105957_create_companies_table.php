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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // link to authenticated user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('company_unique_id')->unique(); // unique identifier for the company
            $table->string('name');
            $table->string('gstin')->nullable();
            $table->string('msme')->nullable();
            $table->string('uam_no')->nullable();
            $table->string('pan')->nullable();
            $table->string('tan')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_address')->nullable();
           

           

            $table->text('default_terms_conditions')->nullable(); // default terms and conditions for invoices, quotes, etc.
            
       

            $table->string('default_color_scheme')->default('#000000'); // default color scheme 

            $table->string('default_footer_text')->nullable(); // default footer text for documents
            $table->string('default_header_text')->nullable(); // default header text for documents
            $table->string('header_color')->default('#FFFFFF'); // default header color
            $table->string('footer_color')->default('#FFFFFF'); // default footer color

         
            $table->string('logo_path')->nullable(); // optional

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
