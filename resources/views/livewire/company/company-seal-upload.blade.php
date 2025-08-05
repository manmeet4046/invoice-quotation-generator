<div class=" p-4 mx-auto">
    @if (session()->has('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif
    <div>
        <h1 class="text-2xl font-bold mb-4">Add Seals Company</h1>
        <p class="text-gray-600 dark:text-gray-200 mb-6">Fill in the details below to create a new company profile.</p>
    </div>

    <div class="flex flex-col gap-4 rounded-xl border p-4 border-neutral-200 dark:border-neutral-700">

        <form wire:submit.prevent="uploadSeal" class="space-y-4 w-1/2 mx-auto" enctype="multipart/form-data">
            <div>
                <label class="block text-sm font-medium">Seal Type</label>
                <select name="seal_type" wire:model.defer="seal_type" class="w-full mt-1 py-2 border rounded-lg">
                    <option value="">-- Select --</option>
                    @foreach (['proprietor', 'director', 'company_seal', 'business_head', 'authorized_signatory', 'manager', 'stamp_only'] as $type)
                        <option value="{{ $type }}">{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                    @endforeach
                </select>
                @error('seal_type')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>

                <flux:input type="file" wire:model.defer="seal_image" label="Seal Image" />
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Upload Seal
            </button>
        </form>
    </div>
    <flux:button class="mt-4 mx-auto" variant="primary" >Next (Add Signatures)</flux:button>
</div>
