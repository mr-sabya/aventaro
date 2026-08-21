<?php
namespace App\Livewire\Frontend\Components;
use App\Models\TeamMember;
use Livewire\Component;
class TeamSection extends Component { public int $limit=4; public function render(){return view('livewire.frontend.components.team-section',['members'=>TeamMember::where('is_active',true)->orderBy('sort_order')->limit($this->limit)->get()]);} }
