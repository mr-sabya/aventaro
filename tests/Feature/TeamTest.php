<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_team_members_have_listing_and_slug_detail_pages():void
    {
        $member=TeamMember::create(['name'=>'Alex Guide','role'=>'Senior Guide','bio'=>'Ten years of guiding experience.','email'=>'alex@example.com','image'=>'team/alex.jpg','sort_order'=>1,'is_active'=>true]);
        $inactive=TeamMember::create(['name'=>'Hidden Guide','role'=>'Guide','image'=>'team/hidden.jpg','is_active'=>false]);
        $this->get(route('team.index'))->assertOk()->assertSeeText('Alex Guide')->assertDontSeeText('Hidden Guide');
        $this->get(route('team.show',$member))->assertOk()->assertSeeText('Ten years of guiding experience.');
        $this->get(route('team.show',$inactive))->assertNotFound();
    }

    public function test_only_active_and_approved_testimonials_render():void
    {
        Testimonial::create(['name'=>'Approved Guest','quote'=>'Approved feedback.','rating'=>5,'is_active'=>true,'is_approved'=>true]);
        Testimonial::create(['name'=>'Pending Guest','quote'=>'Pending feedback.','rating'=>4,'is_active'=>true,'is_approved'=>false]);
        $this->get('/')->assertOk()->assertSeeText('Approved feedback.')->assertDontSeeText('Pending feedback.');
    }
}
