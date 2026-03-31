<?php

namespace App\Livewire\Backend\Destination;

use App\Models\DestinationFaq;
use Livewire\Component;
use Livewire\WithPagination;

class FaqManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $faqId, $question, $answer, $is_active = true;
    public $search = '', $perPage = 10, $isEditMode = false;

    public function resetFields()
    {
        $this->reset(['faqId', 'question', 'answer', 'is_active', 'isEditMode']);
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $faq = DestinationFaq::findOrFail($id);
        $this->faqId = $id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->is_active = $faq->is_active;
        $this->dispatch('show-faq-modal');
    }

    public function save()
    {
        $this->validate(['question' => 'required', 'answer' => 'required']);
        DestinationFaq::updateOrCreate(['id' => $this->faqId], [
            'question' => $this->question,
            'answer' => $this->answer,
            'is_active' => $this->is_active,
        ]);
        $this->dispatch('hide-faq-modal');
        $this->resetFields();
    }

    public function render()
    {
        return view('livewire.backend.destination.faq-manager', [
            'faqs' => DestinationFaq::where('question', 'like', '%' . $this->search . '%')->paginate($this->perPage)
        ]);
    }
}
