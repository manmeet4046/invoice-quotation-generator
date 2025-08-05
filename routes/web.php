<?php


use App\Livewire\Company\CompanyCreate;
use App\Livewire\Company\CompanyEdit;
use App\Livewire\Company\CompanyIndex;
use App\Livewire\Company\CompanySealUpload;
use App\Livewire\Company\CompanySignature;
use App\Livewire\Invoice\InvoiceCreate;
use App\Livewire\Invoice\InvoiceGenerator;
use App\Livewire\Invoice\InvoiceShow;
use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])
    ->prefix('companies')
    ->name('companies.')
    ->group(function () {
        Route::get('/', CompanyIndex::class)->name('index');
        Route::get('/create', CompanyCreate::class)->name('create');
        // Add other company-related routes here
        Route::get('/{companyId}/edit', CompanyEdit::class)->name('edit');
        Route::get('/company/{id}/seal-upload', CompanySealUpload::class)->name('seal-upload');
        Route::get('/company/{id}/signature-upload', CompanySignature::class)->name('signature-upload');
    Route::get('/invoice/create', InvoiceCreate::class)->name('invoice_create');
    
    });
    Route::get('/invoices/create', InvoiceGenerator::class)->name('invoices.create');
Route::get('/invoices/{invoice}', InvoiceShow::class)->name('invoices.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
