<?php

namespace App\Livewire\Backend\Booking;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;

class CouponManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $couponId, $code, $type='percent', $value, $minimum_total=0, $usage_limit, $starts_at, $expires_at, $is_active=true;

    public function save(): void
    {
        $data=$this->validate(['code'=>'required|string|max:50','type'=>'required|in:fixed,percent','value'=>'required|numeric|min:0.01','minimum_total'=>'required|numeric|min:0','usage_limit'=>'nullable|integer|min:1','starts_at'=>'nullable|date','expires_at'=>'nullable|date|after:starts_at','is_active'=>'boolean']);
        if ($data['type'] === 'percent' && $data['value'] > 100) { $this->addError('value', 'Percentage coupons cannot exceed 100%.'); return; }
        $data['code']=strtoupper($data['code']);
        $this->validate(['code'=>'unique:coupons,code,'.($this->couponId ?: 'NULL')]);
        Coupon::updateOrCreate(['id'=>$this->couponId],$data);
        $this->resetForm(); session()->flash('message','Coupon saved.');
    }
    public function edit(int $id): void { $c=Coupon::findOrFail($id); foreach(['code','type','value','minimum_total','usage_limit','is_active'] as $field)$this->$field=$c->$field; $this->starts_at=$c->starts_at?->format('Y-m-d\TH:i'); $this->expires_at=$c->expires_at?->format('Y-m-d\TH:i'); $this->couponId=$id; }
    public function delete(int $id): void { Coupon::findOrFail($id)->delete(); session()->flash('message','Coupon deleted.'); }
    public function resetForm(): void { $this->reset(['couponId','code','value','usage_limit','starts_at','expires_at']); $this->type='percent';$this->minimum_total=0;$this->is_active=true; }
    public function render() { return view('livewire.backend.booking.coupon-manager',['coupons'=>Coupon::latest()->paginate(15)]); }
}
