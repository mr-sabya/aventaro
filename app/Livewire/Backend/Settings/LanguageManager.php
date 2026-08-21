<?php

namespace App\Livewire\Backend\Settings;

use App\Models\Language;
use Livewire\Component;
use Livewire\WithPagination;

class LanguageManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Model Properties
    public $name, $code, $is_active = true, $languageId;

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
        $this->reset(['name', 'code', 'languageId', 'isEditMode']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $language = Language::findOrFail($id);
        $this->languageId = $id;
        $this->name = $language->name;
        $this->code = $language->code;
        $this->is_active = $language->is_active;

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:100|unique:languages,name,' . $this->languageId,
            'code' => 'required|string|max:10|unique:languages,code,' . $this->languageId,
            'is_active' => 'boolean',
        ]);

        Language::updateOrCreate(['id' => $this->languageId], $validatedData);

        session()->flash('message', $this->isEditMode ? 'Language Updated Successfully.' : 'Language Created Successfully.');

        $this->dispatch('hide-modal');
        $this->resetFields();
    }

    public function delete($id)
    {
        Language::find($id)->delete();
        session()->flash('message', 'Language Deleted Successfully.');
    }

    public function render()
    {
        $languages = Language::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.settings.language-manager', ['languages' => $languages]);
    }
}
