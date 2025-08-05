<div class="dark:text-gray-200">
    <style>
 

[data-flux-error] {
  margin-top: -5px; !important; /* 2px */

}
* {
   /* outline: 1px solid red;*/
}
        </style>
    <div>
        <h1 class="text-2xl font-bold mb-4">Edit  Company Details</h1>
        <p class="text-gray-600 dark:text-gray-200 mb-6">Alter the  details below to edit a  company's profile.</p>    
    </div>

    <div class="flex flex-col gap-4 rounded-xl border border-neutral-200 dark:border-neutral-700">
        <form wire:submit.prevent="update" enctype="multipart/form-data" class="space-y-12 m-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow">

            {{-- Section: Basic Information --}}
            <h2 class="text-lg font-semibold dark:text-gray-200 text-gray-700 mb-4">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ([
                    ['name', 'Name', 'text'],
                    ['email', 'Email', 'email'],
                    ['phone', 'Phone', 'text'],
                    ['gstin', 'GSTIN', 'text'],
                    ['msme', 'MSME', 'text'],
                    ['uam_no', 'UAM No', 'text'],
                    ['pan', 'PAN', 'text'],
                    ['tan', 'TAN', 'text'],
                ] as [$field, $label, $type])
                   <div> <flux:input
                        label="{{ $label }}"
                        type="{{ $type }}"
                        wire:model.defer="company.{{ $field }}"
                        name="company.{{ $field }}" class="mb-0 border border-gray-400 rounded-lg"
                    /></div>
                @endforeach
            </div>

            {{-- Section: Address --}}
            <h2 class="text-lg font-semibold dark:text-gray-200 text-gray-700 mb-4">Address</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ([
                    'address' => 'Address',
                    'city' => 'City',
                    'state' => 'State',
                    'country' => 'Country',
                    'pincode' => 'Pincode',
                ] as $field => $label)
                   <div> <flux:input
                        label="{{ $label }}"
                        type="text"
                        wire:model.defer="company.{{ $field }}"
                        name="company.{{ $field }}" class="border border-gray-400 rounded-lg"
                    /></div>
                @endforeach
            </div>

            {{-- Section: Bank Details --}}
            <h2 class="text-lg font-semibold dark:text-gray-200 text-gray-700 mb-4">Bank Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ([
                    'bank_name' => 'Bank Name',
                    'bank_account_number' => 'Account Number',
                    'bank_ifsc' => 'IFSC',
                    'bank_branch' => 'Branch',
                    'bank_address' => 'Bank Address',
                ] as $field => $label)
                   <div> <flux:input
                        label="{{ $label }}"
                        type="text"
                        wire:model.defer="company.{{ $field }}"
                        name="company.{{ $field }}" class="border border-gray-400 rounded-lg"
                    /></div>
                @endforeach
            </div>

            {{-- Section: Defaults & Misc --}}
            <h2 class="text-lg font-semibold dark:text-gray-200 text-gray-700 mb-4">Defaults & Misc</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                

                @foreach ([
                    
                   
                    'default_footer_text' => 'Footer Text',
                    'default_header_text' => 'Header Text',
                ] as $field => $label)
                  
                        <flux:textarea
                            label="{{ $label }}"
                            wire:model.defer="company.{{ $field }}"
                            name="company.{{ $field }}"
                            rows="4" class="border border-gray-400 rounded-lg"
                        />
                   
                 
                @endforeach

               
            </div>
<div class="flex flex-col sm:flex-row gap-4">
    <div class="sm:w-1/3 my-auto">
        <flux:input
            type="file"
            label="Logo"
            wire:model.defer="company.logo_path"
            name="company.logo_path"
            class="w-full border border-gray-400 rounded-lg"
        />
    </div>

    <div class="sm:w-2/3">
        <flux:textarea
            label="Terms & Conditions"
            wire:model.defer="company.default_terms_conditions"
            name="company.default_terms_conditions"
            rows="4"
            class="w-full border border-gray-400 rounded-lg"
        />
    </div>
</div>
            {{-- Section: Colors --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4 p-0" style="padding:0">
                @foreach ([
                    'default_color_scheme' => 'Default Color Scheme',
                    'header_color' => 'Header Color',
                    'footer_color' => 'Footer Color',
                ] as $field => $label)
                   <div> <flux:input
                        label="{{ $label }}"
                        type="color"
                        wire:model.defer="company.{{ $field }}"
                        name="company.{{ $field }}" class="border border-gray-400 rounded-lg max-w-1/4 " style="padding:0"
                    /></div>
                @endforeach
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end mt-8">
                <flux:button type="submit" variant="primary">
                    Update Company
                </flux:button>
            </div>
        </form>
    </div>
</div>
