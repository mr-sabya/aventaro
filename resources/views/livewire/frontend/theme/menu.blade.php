<nav id="mobile-menu">
    <ul>
        <li class="active">
            <a href="{{ route('home') }}" wire:navigate>
                Home
            </a>
        </li>
        <li class="">
            <a href="{{ route('tour.index') }}" wire:navigate>
                Tour Packages
            </a>
        </li>
        <li>
            <a href="{{ route('destination.index') }}" wire:navigate>
                Destinations
            </a>
        </li>
        
        <li>
            <a href="{{ route('news.index') }}" wire:navigate>
                News
            </a>
        </li>
        <li>
            <a href="{{ route('pages.about') }}" wire:navigate>
                About Us
            </a>
        </li>
        <li>
            <a href="{{ route('pages.conatct') }}" wire:navigate>
                Contact
            </a>
        </li>
    </ul>
</nav>