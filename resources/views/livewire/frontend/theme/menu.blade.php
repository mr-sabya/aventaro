<nav id="mobile-menu">
    <ul>
        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" wire:navigate>
                Home
            </a>
        </li>
        <li class="{{ request()->routeIs('tour.*') ? 'active' : '' }}">
            <a href="{{ route('tour.index') }}" wire:navigate>
                Tour Packages
            </a>
        </li>
        <li class="{{ request()->routeIs('destination.*') ? 'active' : '' }}">
            <a href="{{ route('destination.index') }}" wire:navigate>
                Destinations
            </a>
        </li>
        
        <li class="{{ request()->routeIs('news.*') ? 'active' : '' }}">
            <a href="{{ route('news.index') }}" wire:navigate>
                News
            </a>
        </li>
        <li class="{{ request()->routeIs('pages.about') ? 'active' : '' }}">
            <a href="{{ route('pages.about') }}" wire:navigate>
                About Us
            </a>
        </li>
        <li class="{{ request()->routeIs('pages.contact') ? 'active' : '' }}">
            <a href="{{ route('pages.contact') }}" wire:navigate>
                Contact
            </a>
        </li>
    </ul>
</nav>
