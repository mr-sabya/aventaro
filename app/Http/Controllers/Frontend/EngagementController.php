<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Destination;
use App\Models\NewsPost;
use App\Models\NewsletterSubscriber;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EngagementController extends Controller
{
    public function contact(Request $request)
    {
        $data=$request->validate(['type'=>['nullable','in:contact,appointment'],'name'=>['required','string','max:120'],'email'=>['required','email','max:255'],'phone'=>['nullable','string','max:40'],'subject'=>['nullable','string','max:180'],'message'=>['required','string','min:10','max:3000'],'website'=>['nullable','max:0']]);unset($data['website']);
        $message=ContactMessage::create($data+['type'=>$data['type']??'contact','ip_address'=>$request->ip(),'user_agent'=>Str::limit((string)$request->userAgent(),1000)]);
        try{Mail::to(config('mail.contact_to'))->send(new ContactMessageReceived($message));}catch(\Throwable $e){Log::warning('Contact notification failed',['id'=>$message->id,'error'=>$e->getMessage()]);}
        return back()->with('contact_success','Thank you. Your message has been received.');
    }
    public function subscribe(Request $request)
    {
        $data=$request->validate(['newsletter_email'=>['required','email','max:255'],'website'=>['nullable','max:0']]);
        $subscriber=NewsletterSubscriber::firstOrNew(['email'=>strtolower($data['newsletter_email'])]);$subscriber->fill(['unsubscribe_token'=>$subscriber->unsubscribe_token?:Str::random(64),'is_active'=>true,'subscribed_at'=>now(),'unsubscribed_at'=>null])->save();
        return back()->with('newsletter_success','You are subscribed to the newsletter.');
    }
    public function unsubscribe(NewsletterSubscriber $subscriber){return view('frontend.newsletter.unsubscribe',compact('subscriber'));}
    public function destroySubscription(NewsletterSubscriber $subscriber){$subscriber->update(['is_active'=>false,'unsubscribed_at'=>now()]);return redirect()->route('home')->with('newsletter_success','You have been unsubscribed.');}
    public function search(Request $request)
    {
        $q=$request->validate(['q'=>['required','string','min:2','max:100']])['q'];
        return view('frontend.search.index',['q'=>$q,'tours'=>Tour::with('city.country')->where('is_active',true)->where(fn($x)=>$x->where('title','like',"%{$q}%")->orWhere('description','like',"%{$q}%"))->limit(12)->get(),'destinations'=>Destination::with('city.country')->where('is_active',true)->where(fn($x)=>$x->where('name','like',"%{$q}%")->orWhere('description','like',"%{$q}%"))->limit(12)->get(),'articles'=>NewsPost::published()->where(fn($x)=>$x->where('title','like',"%{$q}%")->orWhere('excerpt','like',"%{$q}%")->orWhere('content','like',"%{$q}%"))->limit(12)->get()]);
    }
}
