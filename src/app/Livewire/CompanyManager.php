<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asset;
use App\Models\AssetCompany;

class CompanyManager extends Component
{
    public $name;
    public $companies;

    public function mount()
    {
        $this->companies = AssetCompany::all();
    }

    public function addCompany()
    {
        $this->validate([
            'name' => 'required|min:3'
        ]);

        $company = AssetCompany::create(['name' => $this->name]);
        $this->companies->push($company);
        $this->name = '';
    }

    public function removeCompany($id)
    {
        $num_assets_using_company = Asset::where('company', $id)->count();
        if ($num_assets_using_company > 0) {
            session()->flash('error', 'Cannot delete this company. Other assets are using it');
            return;
        }
        AssetCompany::where('id', $id)->delete();
        $this->companies = $this->companies->reject(fn ($company) => $company->id == $id);
    }

    public function render()
    {
        return view('livewire.company-manager');
    }
}
