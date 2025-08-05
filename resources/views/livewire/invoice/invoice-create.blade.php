<div class="max-w-4xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold mb-6">Create New Invoice</h2>

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Company --}}
        <div>
            <flux:select
                label="Company"
                wire:model="company_id"
                :options="$companies->pluck('name', 'id')"
                placeholder="Select a company"
            />
            @error('company_id')
                <flux:error :message="$message" />
            @enderror
        </div>

        {{-- Invoice Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Invoice Number" wire:model="invoice_number" readonly />
            <flux:input label="Invoice Date" type="date" wire:model="invoice_date" />
            <flux:input label="Order Date" type="date" wire:model="order_date" />
            <flux:input label="Order Number" wire:model="order_number" />
        </div>

        {{-- Billing Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Billing Name" wire:model="billing_name" />
            <flux:input label="Billing Email" type="email" wire:model="billing_email" />
            <div class="md:col-span-2">
                <flux:textarea label="Billing Address" wire:model="billing_address" rows="3" />
            </div>
        </div>

        {{-- Financial Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Subtotal" type="number" step="0.01" wire:model="subtotal" />
            <flux:input label="Discount" type="number" step="0.01" wire:model="discount" />
            
            
             <flux:input label="Shipping Charges" type="number" step="0.01" wire:model="shipping_charges" />
  <flux:select wire:model="tax_type" placeholder="Select tax type" label="Tax type">
    <flux:select.option value="GST">GST</flux:select.option>
    <flux:select.option value="IGST">IGST</flux:select.option>
    <flux:select.option value="CGST_SGST">CGST + SGST</flux:select.option>
</flux:select>
  <flux:select wire:model="tax_rate" placeholder="Select tax Rate" label="Tax Rate">
    <flux:select.option value="5">5</flux:select.option>
    <flux:select.option value="18">18</flux:select.option>
    <flux:select.option value="24">24</flux:select.option>
</flux:select>
            
            <flux:input label="Tax Amount" type="number" wire:model="tax_amount" readonly />
            <flux:input label="Grand Total" type="number" wire:model="grand_total" readonly />
        </div>

        {{-- Legal --}}
        <div>
            <flux:textarea label="Legal Notes" wire:model="legal_notes" rows="3" />
        </div>

        {{-- Submit --}}
        <div>
            <flux:button type="submit">
                Save Invoice
            </flux:button>
        </div>
    </form>
</div>
