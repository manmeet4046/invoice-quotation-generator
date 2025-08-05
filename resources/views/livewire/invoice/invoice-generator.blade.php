<div class="space-y-6">

    {{-- ⚙️ Invoice Metadata --}}
    {{ $companies[0]->id }}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <select wire:model="company_id" class="py-2 border rounded">
            <option value="">Select a company</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>


        <flux:input wire:model="invoice_number" label="Invoice Number" />
        <flux:input wire:model="invoice_date" type="date" label="Invoice Date" />
        <flux:input wire:model="order_date" type="date" label="Order Date" />
        <flux:input wire:model="order_number" label="Order Number" />
    </div>

    {{-- 🧾 Billing Information --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <flux:input wire:model="billing_name" label="Billing Name" />
        <flux:input wire:model="billing_email" label="Billing Email" />
        <flux:input wire:model="billing_gstin" label="GSTIN" />
        <div class="md:col-span-2">
            <flux:textarea wire:model="billing_address" label="Billing Address" />
        </div>
    </div>

    {{-- 📦 Invoice Items --}}
    <div class="space-y-3">
        <h3 class="text-lg font-semibold">Invoice Items</h3>

        @foreach ($items as $index => $item)
            <div class="grid grid-cols-2 gap-2 items-end">
                <flux:input wire:model="items.{{ $index }}.item_name" label="Item Name" class="my-auto bg-gray-800" />
                <flux:input wire:model="items.{{ $index }}.item_description" label="Description" class=" bg-gray-800"  />
            </div>
            <div class="grid grid-cols-5 gap-2 items-end">
                <flux:input wire:model="items.{{ $index }}.quantity" type="number" label="Qty" class=" bg-gray-800" />
                <flux:input wire:model="items.{{ $index }}.rate" type="number" step="0.01" label="Rate"  class=" bg-gray-800"  />
                <flux:input wire:model="items.{{ $index }}.hsn" type="text" 
                    label="HSN Code" class=" bg-gray-800"  />
                <flux:input wire:model="items.{{ $index }}.total" readonly label="Total"  class=" bg-gray-800" />
                <div class="pt-5">
                    <button type="button" wire:click="removeItem({{ $index }})"
                        class="text-red-500 hover:underline">❌</button>
                </div>
            </div>
        @endforeach

        <button type="button" wire:click="addItem" class="text-blue-500 hover:underline mt-2">⊕ Add Item</button>
    </div>

    {{-- 💰 Totals & Tax --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <flux:select wire:model="tax_type" label="Tax Type" placeholder="Choose Tax Type">
            <flux:select.option value="GST">GST</flux:select.option>
            <flux:select.option value="IGST">IGST</flux:select.option>
            <flux:select.option value="CGST_SGST">CGST + SGST</flux:select.option>
        </flux:select>

        <flux:input wire:model="tax_rate" type="number" step="0.01" label="Tax Rate (%)" />
        <flux:input wire:model="shipping_charges" type="number" step="0.01" label="Shipping Charges" />
        <flux:input wire:model="round_off" type="number" step="0.01" label="Round Off" />
    </div>

    {{-- 📊 Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <flux:input wire:model="subtotal" readonly label="Subtotal" />
        <flux:input wire:model="total_discount" readonly label="Total Discount" />
        <flux:input wire:model="tax_amount" readonly label="Tax Amount" />
        <flux:input wire:model="grand_total" readonly label="Grand Total" />
    </div>

    {{-- 💳 Payment & Legal --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <flux:select wire:model="payment_status" label="Payment Status" placeholder="Select status">
            <flux:select.option value="pending">Pending</flux:select.option>
            <flux:select.option value="paid">Paid</flux:select.option>
            <flux:select.option value="failed">Failed</flux:select.option>
        </flux:select>

        <flux:input wire:model="due_date" type="date" label="Due Date" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<!-- Inside your Livewire view -->
<div wire:key="editor" class="mb-4">
    <!-- Hidden textarea that Livewire watches -->
    <flux:textarea id="hidden-editor" wire:model="override_terms_and_conditions" style="display: none;" label=" Terms & Conditions"/>

    <!-- Quill visible editor -->
     <div wire:ignore>
        <div id="quill-editor" style="min-height: 150px;"></div>
    </div>
    
</div>

        <flux:textarea wire:model="legal_notes" label="Legal Notes" />
    </div>

    {{-- ✅ Submit --}}
    <div class="pt-4">
        <flux:button wire:click="save">
            Save Invoice
        </flux:button>
    </div>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write something...',
        });

        // Set initial content from textarea
        const textarea = document.getElementById('hidden-editor');
        quill.root.innerHTML = textarea.value;

        // Update textarea when Quill content changes
        quill.on('text-change', function () {
            textarea.value = quill.root.innerHTML;
            textarea.dispatchEvent(new Event('input')); // Inform Livewire
        });
    });
</script>
</div>
