<?php

namespace App\Livewire\Invoice;

use App\Models\Company;
use App\Models\Invoice;
use Livewire\Component;
use Illuminate\Support\Str;

class InvoiceCreate extends Component
{
    public $companies;
    public $company_id =1;
    public $invoice_number;
    public $invoice_date;
    public $order_date;
    public $order_number;

    public $billing_name;
    public $billing_email;
    public $billing_address;
    public $billing_gstin;

    public $tax_type = 'GST';
    public $tax_rate = 18.00;
    public $tax_amount = 0;

    public $subtotal = 0;
    public $discount = 0;
    public $total_discount = 0;
    public $shipping_charges = 0;
    public $round_off = 0;
    public $grand_total = 0;

    public $payment_status = 'pending';
    public $due_date;

    public $override_terms_and_conditions;
    public $legal_notes;

    public function mount()
    {
        $this->companies = Company::all();
        $this->invoice_number = 'INV-' . strtoupper(Str::random(6));
        $this->invoice_date = now()->format('Y-m-d');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['subtotal', 'discount', 'shipping_charges', 'round_off', 'tax_rate'])) {
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {
        $taxable = $this->subtotal - $this->discount;
        $this->tax_amount = round(($taxable * $this->tax_rate) / 100, 2);
        $this->grand_total = round($taxable + $this->tax_amount + $this->shipping_charges + $this->round_off, 2);
    }

    public function save()
    {
        $this->validate([
            'id' => 'required|exists:companies,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'billing_name' => 'nullable|string|max:255',
            'grand_total' => 'required|numeric|min:0',
        ]);

        Invoice::create($this->only([
            'company_id', 'invoice_number', 'invoice_date', 'order_date', 'order_number',
            'billing_name', 'billing_email', 'billing_address', 'billing_gstin',
            'tax_type', 'tax_rate', 'tax_amount',
            'subtotal', 'discount', 'total_discount', 'shipping_charges', 'round_off', 'grand_total',
            'payment_status', 'due_date',
            'override_terms_and_conditions', 'legal_notes'
        ]));

        session()->flash('success', 'Invoice created successfully!');
        return redirect()->route('invoices.index');
    }

    public function render()
    {
        return view('livewire.invoice.invoice-create');
    }
}