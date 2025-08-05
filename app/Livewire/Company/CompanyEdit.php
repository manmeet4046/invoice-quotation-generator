<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanyEdit extends Component
{
    use WithFileUploads;
    public $companyId;
    public $company = [];
    public Company $companyModel;
    protected $rules = [
        'company.name' => 'required|string|max:255',
        'company.email' => 'required|email|max:255',
        'company.phone' => 'required|string|max:20',
        'company.website' => 'nullable|url',

        'company.gstin' => 'nullable|string|max:15',
        'company.msme' => 'nullable|string|max:50',
        'company.uam_no' => 'nullable|string|max:50',
        'company.pan' => 'nullable|string|max:10',
        'company.tan' => 'nullable|string|max:10',

        'company.address' => 'required|string|max:255',
        'company.city' => 'required|string|max:100',
        'company.state' => 'required|string|max:100',
        'company.country' => 'required|string|max:100',
        'company.pincode' => 'required|string|max:10',

        'company.bank_name' => 'nullable|string|max:100',
        'company.bank_account_number' => 'nullable|string|max:20',
        'company.bank_ifsc' => 'nullable|string|max:11',
        'company.bank_branch' => 'nullable|string|max:100',
        'company.bank_address' => 'nullable|string|max:255',

        
        'company.logo_path' => 'nullable|file|image|max:2048',
        
        'company.default_terms_conditions' => 'nullable|string',

        'company.default_color_scheme' => 'nullable|regex:/^#?[0-9a-fA-F]{6}$/',
        'company.header_color' => 'nullable|regex:/^#?[0-9a-fA-F]{6}$/',
        'company.footer_color' => 'nullable|regex:/^#?[0-9a-fA-F]{6}$/',

        'company.default_footer_text' => 'nullable|string|max:255',
        'company.default_header_text' => 'nullable|string|max:255',
    ];

    public function mount($companyId){
        $this->companyId = $companyId;
         $this->companyModel  = Company::where('id', $companyId)->firstOrFail();
         if (auth()->user()->role !== 'admin' && $this->companyModel->user_id !== auth()->id()) {
        abort(403, 'Unauthorized access to this company.');
    }

         $this->company = $this->companyModel->toArray();

    }
    public function update(){
          if (auth()->user()->role !== 'admin' && $this->companyModel->user_id !== auth()->id()) {
        abort(403, 'Unauthorized access to this company.');
    }
    
        $this->validate();
             $this->companyModel->update($this->company);
       
    }
    public function render()
    {
        return view('livewire.company.company-edit');
    }
}
