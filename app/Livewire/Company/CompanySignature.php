<?php

namespace App\Livewire\Company;

use App\Models\Signature;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanySignature extends Component
{
    use WithFileUploads;

    public $company_id;
    public $signature_type;
    public $signature_image;

    protected $rules = [
        'signature_type' => 'required|in:proprietor,director,business_head,authorized_signatory,manager,ceo',
        'signature_image' => 'required|image|max:2048' // max 2MB
    ];

    public function mount($id)
    {
        $this->company_id = $id;
    }

    public function uploadSignature()
    {

        $this->validate();
        $exists = Signature::where('company_id', $this->company_id)
            ->where('signature_type', $this->signature_type)
            ->exists();

        if ($exists) {
            // 👇 Throw a validation error on seal_type
            throw ValidationException::withMessages([
                'signature_type' => 'This Signature type has already been uploaded for this company.',
            ]);
        }
        $originalName = pathinfo($this->signature_image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $this->signature_image->getClientOriginalExtension();

        // Sanitize filename
        $sanitizedName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $originalName));
        $finalFilename = $sanitizedName . '.' . $extension;

        $path = $this->signature_image->storeAs(
            $this->company_id . '/company_signs/',
            $finalFilename,
            'public'
        );

        Signature::create([
            'company_id' => $this->company_id,
            'signature_type' => $this->signature_type,
            'signature_path' => $path,
        ]);

        session()->flash('success', 'Seal uploaded successfully!');
        $this->reset(['signature_type', 'signature_image']);
    }

    public function render()
    {
        return view('livewire.company.company-signature');
    }
}
