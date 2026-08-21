<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index()
    {
        return view('frontend.team.index',['members'=>TeamMember::where('is_active',true)->orderBy('sort_order')->paginate(12)]);
    }

    public function show(TeamMember $member)
    {
        abort_unless($member->is_active,404);
        $others=TeamMember::where('is_active',true)->where('id','!=',$member->id)->orderBy('sort_order')->limit(4)->get();
        return view('frontend.team.show',compact('member','others'));
    }
}
