<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\FooterGallery;
use App\Models\FooterLink;
use App\Models\SiteSetting;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        $allGroups = FooterLink::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group_name')
            ->toBase();

        $preferredNames = ['Useful Links', 'About Aventaro'];
        $linkGroups = collect($preferredNames)
            ->filter(fn ($name) => $allGroups->has($name))
            ->mapWithKeys(fn ($name) => [$name => $allGroups->get($name)->take(5)]);

        if ($linkGroups->count() < 2) {
            $allGroups->except($linkGroups->keys()->all())->take(2 - $linkGroups->count())
                ->each(fn ($links, $name) => $linkGroups->put($name, $links->take(5)));
        }

        return view('livewire.frontend.theme.footer', [
            'settings' => SiteSetting::query()->firstOrCreate([], ['site_name' => 'Aventaro']),
            'linkGroups' => $linkGroups,
            'gallery' => FooterGallery::query()->where('is_active', true)->orderBy('sort_order')->limit(9)->get(),
        ]);
    }
}
