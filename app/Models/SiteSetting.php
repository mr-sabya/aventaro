<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SiteSetting extends Model { protected $fillable=['site_name','tagline','logo','favicon','phone','email','address','facebook_url','instagram_url','twitter_url','linkedin_url','header_button_text','header_button_url','newsletter_title','footer_about_title','copyright_text','play_store_url','app_store_url']; }
