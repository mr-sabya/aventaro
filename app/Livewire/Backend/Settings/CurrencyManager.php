<?php

namespace App\Livewire\Backend\Settings;

use App\Models\Currency;
use Livewire\Component;
use Livewire\WithPagination;

class CurrencyManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Model Properties
    public $name, $code, $symbol, $exchange_rate = 1, $is_active = true, $currencyId;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // UI State
    public $isEditMode = false;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFields()
    {
        $this->reset(['name', 'code', 'symbol', 'currencyId', 'isEditMode']);
        $this->exchange_rate = 1;
        $this->is_active = true;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $currency = Currency::findOrFail($id);
        $this->currencyId = $id;
        $this->name = $currency->name;
        $this->code = $currency->code;
        $this->symbol = $currency->symbol;
        $this->exchange_rate = $currency->exchange_rate;
        $this->is_active = $currency->is_active;

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:currencies,code,' . $this->currencyId,
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.000001',
            'is_active' => 'boolean',
        ]);

        Currency::updateOrCreate(['id' => $this->currencyId], $validatedData);

        session()->flash('message', $this->isEditMode ? 'Currency Updated Successfully.' : 'Currency Created Successfully.');

        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function delete($id)
    {
        Currency::find($id)->delete();
        session()->flash('message', 'Currency Deleted Successfully.');
    }

    public function render()
    {
        $currencies = Currency::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.settings.currency-manager', ['currencies' => $currencies]);
    }
}
