<?php

namespace App\Livewire\Company;

use App\Models\Seal;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException;
class CompanySealUpload extends Component
{
    use WithFileUploads;

    public $company_id;
    public $seal_type;
    public $seal_image;

    protected $rules = [
        'seal_type' => 'required|in:proprietor,director,company_seal,business_head,authorized_signatory,manager,stamp_only',
        'seal_image' => 'required|image|max:2048' // max 2MB
    ];

    public function mount($id)
    {
        $this->company_id = $id;
    }

   public function uploadSeal()
{
    
    $this->validate();
 $exists = Seal::where('company_id', $this->company_id)
        ->where('seal_type', $this->seal_type)
        ->exists();

    if ($exists) {
        // 👇 Throw a validation error on seal_type
        throw ValidationException::withMessages([
            'seal_type' => 'This seal type has already been uploaded for this company.',
        ]);
    }
    $originalName = pathinfo($this->seal_image->getClientOriginalName(), PATHINFO_FILENAME);
    $extension = $this->seal_image->getClientOriginalExtension();

    // Sanitize filename
    $sanitizedName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $originalName));
    $finalFilename = $sanitizedName . '.' . $extension;

    $path = $this->seal_image->storeAs(
         $this->company_id.'/company_seals/',
        $finalFilename,
        'public'
    );

    Seal::create([
        'company_id' => $this->company_id,
        'seal_type' => $this->seal_type,
        'seal_path' => $path,
    ]);

    session()->flash('success', 'Seal uploaded successfully!');
    $this->reset(['seal_type', 'seal_image']);
}

    public function render()
    {
        return view('livewire.company.company-seal-upload');
    }
}