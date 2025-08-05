<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyIndex extends Component
{
  use WithPagination;

    public $search = '';

    public function delete($deleteId){
        $deleteCompany = Company::findOrFail($deleteId);
        $deleteCompany->delete();
    }

    public function render()
    {
        $companies = Company::query()
    ->when(
        auth()->user()->role !== 'admin',
        fn($q) =>  $q->where('user_id', auth()->id())
    )
    ->when(
        $this->search,
        fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
    )
            ->latest()
            ->paginate(10);

        return view('livewire.company.company-index', compact('companies'));
    }
}
