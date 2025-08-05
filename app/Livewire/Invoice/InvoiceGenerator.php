<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use App\Models\Company;
use App\Models\Invoice;
//use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class InvoiceGenerator extends Component
{
  // Invoice metadata
    public $company_id, $invoice_number, $invoice_date, $order_date, $order_number;

    // Billing details
    public $billing_name, $billing_email, $billing_address, $billing_gstin;

    // Tax and charges
    public $tax_type = 'GST', $tax_rate = 18.00, $shipping_charges = 0.00, $round_off = 0.00;

    // Totals (auto-calculated)
    public $subtotal = 0, $total_discount = 0, $tax_amount = 0, $grand_total = 0;

    // Payment
    public $payment_status = 'pending', $due_date;

    // Legal and compliance
    public $override_terms_and_conditions, $legal_notes;

    // Line items
    public $items = [];

    public function mount()
    {
        $this->invoice_date = now()->format('Y-m-d');
        $this->invoice_number = 'INV-' . strtoupper(Str::random(6));
        $this->items = [
            ['item_name' => '', 'quantity' => 1, 'rate' => 0, 'discount' => 0, 'total' => 0],
        ];
    }

    public function addItem()
    {
        $this->items[] = ['item_name' => '', 'quantity' => 1, 'rate' => 0, 'discount' => 0, 'total' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    public function updatedItems()
    {
        $this->calculateTotals();
    }

    public function updatedShippingCharges()
    {
        $this->calculateTotals();
    }

    public function updatedTaxRate()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        $this->total_discount = 0;

        foreach ($this->items as $index => $item) {
            $qty = (int) $item['quantity'];
            $rate = (float) $item['rate'];
            $discount = (float) $item['discount'];

            $line_total = ($qty * $rate) - $discount;
            $this->items[$index]['total'] = $line_total;

            $this->subtotal += ($qty * $rate);
            $this->total_discount += $discount;
        }

        $taxable_amount = $this->subtotal - $this->total_discount;
        $this->tax_amount = round(($taxable_amount * $this->tax_rate) / 100, 2);
        $this->grand_total = round($taxable_amount + $this->tax_amount + $this->shipping_charges + $this->round_off, 2);
    }

    public function save()
    {

        $this->validate([
            'company_id' => 'required|exists:companies,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
            'billing_name' => 'nullable|string|max:255',
            'billing_email' => 'nullable|email',
            'billing_address' => 'nullable|string',
            'billing_gstin' => 'nullable|string|max:20',
        ]);
$invoice = null;

    DB::transaction(function () use (&$invoice) {
        $invoice = Invoice::create([
            'company_id' => $this->company_id,
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'order_date' => $this->order_date,
            'order_number' => $this->order_number,
            'billing_name' => $this->billing_name,
            'billing_email' => $this->billing_email,
            'billing_address' => $this->billing_address,
            'billing_gstin' => $this->billing_gstin,
            'tax_type' => $this->tax_type,
            'tax_rate' => $this->tax_rate,
            'shipping_charges' => $this->shipping_charges,
            'round_off' => $this->round_off,
            'subtotal' => $this->subtotal,
            'total_discount' => $this->total_discount,
            'tax_amount' => $this->tax_amount,
            'grand_total' => $this->grand_total,
            'payment_status' => $this->payment_status,
            'due_date' => $this->due_date,
            'override_terms_and_conditions' => $this->override_terms_and_conditions,
            'legal_notes' => $this->legal_notes,
        ]);

        \Log::info('Invoice created inside transaction:', ['invoice' => $invoice]);

        if ($invoice) {
            foreach ($this->items as $item) {
                $invoice->items()->create($item);
            }
        }
    });

    \Log::info('Invoice after transaction:', ['invoice' => $invoice]);

    if ($invoice && $invoice->id) {
        session()->flash('success', 'Invoice created successfully!');
        return redirect()->route('invoices.show', $invoice->id);
    }

    session()->flash('error', 'Invoice creation failed.');

    }

    public function render()
    {
        return view('livewire.invoice.invoice-generator', [
            'companies' => Company::all(),
        ]);
    }
}


