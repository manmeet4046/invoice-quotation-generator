<?php

namespace App\Livewire\Invoice;

use App\Models\Company;
use Livewire\Component;
use App\Models\Invoice;
class InvoiceShow extends Component
{
    public Invoice $invoice;
    public $company;

    // This runs when the component is initialized, e.g., from a route like /invoices/{invoice}
    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice->load('items'); // Load related invoice items
             $this->company = $this->invoice->company; // 
    }

    public function render()
    {
        return view('livewire.invoice.invoice-show', [
            'invoice' => $this->invoice,
            'company'=>$this->company,
        ]);
    }
}