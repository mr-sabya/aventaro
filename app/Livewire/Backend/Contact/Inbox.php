<?php
namespace App\Livewire\Backend\Contact;
use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;
class Inbox extends Component
{
    use WithPagination; protected $paginationTheme='bootstrap'; public string $search='';public string $status='all';public string $type='all';public ?int $selectedId=null;
    public function updatedSearch(){ $this->resetPage(); } public function updatedStatus(){ $this->resetPage(); }
    public function open(int $id):void{$message=ContactMessage::findOrFail($id);if($message->status==='new')$message->update(['status'=>'read','read_at'=>now()]);$this->selectedId=$id;}
    public function markReplied(int $id):void{ContactMessage::findOrFail($id)->update(['status'=>'replied','read_at'=>now(),'replied_at'=>now()]);session()->flash('message','Message marked replied.');}
    public function delete(int $id):void{ContactMessage::findOrFail($id)->delete();if($this->selectedId===$id)$this->selectedId=null;session()->flash('message','Message deleted.');}
    public function render(){return view('livewire.backend.contact.inbox',['messages'=>ContactMessage::query()->when($this->status!=='all',fn($q)=>$q->where('status',$this->status))->when($this->type!=='all',fn($q)=>$q->where('type',$this->type))->when($this->search,fn($q)=>$q->where(fn($x)=>$x->where('name','like',"%{$this->search}%")->orWhere('email','like',"%{$this->search}%")->orWhere('subject','like',"%{$this->search}%")))->latest()->paginate(15),'selected'=>$this->selectedId?ContactMessage::find($this->selectedId):null]);}
}
