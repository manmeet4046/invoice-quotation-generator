<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class CompanyCreate extends Component
{
    use WithFileUploads;

    public $company = [];

    public function mount()
    {


        $this->company['name'] = '';
        $this->company['email'] = '';
        $this->company['phone'] = '';
        $this->company['website'] = '';
        $this->company['gstin'] = '12';
        $this->company['msme'] = '21';
        $this->company['uam_no'] = '21';
        $this->company['pan'] = '21';
        $this->company['tan'] = '12';

        $this->company['address'] = '';
        $this->company['city'] = '';
        $this->company['state'] = 'Uttar Pradesh';
        $this->company['country'] = 'India';
        $this->company['pincode'] = '';

        $this->company['bank_name'] = '';
        $this->company['bank_account_number'] = 'qw';
        $this->company['bank_ifsc'] = '21';
        $this->company['bank_branch'] = '';
        $this->company['bank_address'] = '';

        $this->company['logo_path'] = '';
     
        $this->company['default_terms_conditions'] = '';

        $this->company['default_color_scheme'] = '000000';
        $this->company['header_color'] = '#ffffff';
        $this->company['footer_color'] = '#ffffff';
        $this->company['default_footer_text'] = '';
        $this->company['default_header_text'] = '';
    }


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

    public function save()
    {
        // dd($this->company);
        $this->validate();
  if ($this->getErrorBag()->isNotEmpty()) {
        // Validation failed, emit event to scroll
        $this->emit('validationFailed');
        return;  // stop execution so save logic doesn't run
    }
        $this->company['company_unique_id'] = $this->generateCompanyId($this->company['name']);
        $this->company['user_id'] = auth()->user()->id;

        Company::create($this->company);

        session()->flash('success', 'Company created successfully.');
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.company.company-create');
    }

    protected function generateCompanyId($companyName)
    {
        $userIdPadded = str_pad(auth()->id(), 3, '0', STR_PAD_LEFT);
        $companyCode = strtoupper(substr($companyName, 0, 4));
        $year = now()->year;

        return "{$userIdPadded}-{$companyCode}-{$year}";
    }
}
