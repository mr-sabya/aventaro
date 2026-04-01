<?php

namespace App\Livewire\Backend\Tour;

use App\Models\Tour;
use App\Models\TourPlan;
use Livewire\Component;

class PlanManager extends Component
{
    // Context
    public $tour;
    public $tourId;

    // Form Properties
    public $planId, $day_number, $title, $description;

    // UI State
    public $isEditMode = false;

    /**
     * Initialize with the Tour ID from the route
     */
    public function mount($tourId)
    {
        $this->tourId = $tourId;
        $this->tour = Tour::findOrFail($tourId);

        // Auto-suggest the next day number
        $this->day_number = ($this->tour->plans()->max('day_number') ?? 0) + 1;
    }

    public function resetFields()
    {
        $this->reset(['planId', 'title', 'description', 'isEditMode']);
        $this->day_number = ($this->tour->plans()->max('day_number') ?? 0) + 1;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->isEditMode = true;
        $plan = TourPlan::findOrFail($id);
        $this->planId = $id;
        $this->day_number = $plan->day_number;
        $this->title = $plan->title;
        $this->description = $plan->description;
    }

    public function save()
    {
        $this->validate([
            'day_number' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        TourPlan::updateOrCreate(
            ['id' => $this->planId],
            [
                'tour_id' => $this->tourId,
                'day_number' => $this->day_number,
                'title' => $this->title,
                'description' => $this->description,
            ]
        );

        session()->flash('message', $this->isEditMode ? 'Plan Updated.' : 'New Day Added.');
        $this->resetFields();
    }

    public function delete($id)
    {
        TourPlan::find($id)->delete();
        session()->flash('message', 'Day plan deleted.');
    }

    public function render()
    {
        return view('livewire.backend.tour.plan-manager', [
            'plans' => TourPlan::where('tour_id', $this->tourId)
                ->orderBy('day_number', 'asc')
                ->get()
        ]);
    }
}
