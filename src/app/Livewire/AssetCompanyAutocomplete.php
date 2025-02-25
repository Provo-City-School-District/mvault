<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AssetCompany;

class AssetCompanyAutocomplete extends Component
{
    public $query = '';
    public $companies = [];
    public $showDropdown = false;

    public function updatedQuery()
    {
        if (strlen($this->query) > 1) {
            $this->companies = AssetCompany::where('name', 'like', "%$this->query%")
                ->orderBy('name')
                ->limit(5)
                ->get();
            $this->showDropdown = true;
        } else {
            $this->showDropdown = false;
        }
    }

    public function selectCompany($name)
    {
        $this->query = $name;
        $this->showDropdown = false;
    }

    public function render()
    {
        return view('livewire.asset-company-autocomplete');
    }
}
