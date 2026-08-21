<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContactMessage extends Model { protected $fillable=['type','name','email','phone','subject','message','status','ip_address','user_agent','read_at','replied_at']; protected $casts=['read_at'=>'datetime','replied_at'=>'datetime']; }
