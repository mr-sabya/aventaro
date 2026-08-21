<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('admin.dashboard') }}">
            <img alt="#" src="{{ url('assets/backend/images/logo/1.png') }}">
        </a>

        <span class="bg-light-primary toggle-semi-nav d-flex-center">
            <i class="ti ti-chevron-right"></i>
        </span>

        <div class="d-flex align-items-center nav-profile p-3">
            <span class="h-45 w-45 d-flex-center b-r-10 position-relative bg-danger m-auto">
                <img alt="avatar" class="img-fluid b-r-10" src="{{ url('assets/backend/images/avatar/woman.jpg') }}">
                <span class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
            </span>
            <div class="flex-grow-1 ps-2">
                <h6 class="text-primary mb-0">{{ auth()->user()?->name ?: 'Administrator' }}</h6>
                <p class="text-muted f-s-12 mb-0">Administrator</p>
            </div>


            <div class="dropdown profile-menu-dropdown">
                <a aria-expanded="false" data-bs-auto-close="true" data-bs-placement="top" data-bs-toggle="dropdown"
                    role="button">
                    <i class="ti ti-settings fs-5"></i>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a class="f-w-500" href="{{ route('admin.dashboard') }}">
                            <i class="ph-duotone  ph-user-circle pe-1 f-s-20"></i> Profile Details
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="f-w-500" href="{{ route('admin.site-settings.index') }}">
                            <i class="ph-duotone  ph-gear pe-1 f-s-20"></i> Settings
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <a class="f-w-500" href="#">
                                    <i class="ph-duotone  ph-detective pe-1 f-s-20"></i> Incognito
                                </a>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="form-check form-switch">
                                    <input class="form-check-input form-check-primary" id="incognitoSwitch"
                                        type="checkbox">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <a class="mb-0 text-secondary f-w-500" href="./sign_up.html" target="_blank">
                            <i class="ph-bold  ph-plus pe-1 f-s-20"></i> Add account
                        </a>
                    </li>

                    <li class="app-divider-v dotted py-1"></li>

                    <li class="dropdown-item">
                        <livewire:backend.auth.logout />
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
            <li class="menu-title">
                <span>Dashboard</span>
            </li>
            <li class="no-sub {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="" wire:navigate>
                    <svg stroke="currentColor" stroke-width="1.5">
                        <use xlink:href="{{ url('assets/backend/svg/_sprite.svg#home') }}"></use>
                    </svg>
                    dashboard
                </a>
            </li>
            <li>
                <a aria-expanded="false" data-bs-toggle="collapse" href="#apps">
                    <svg stroke="currentColor" stroke-width="1.5">
                        <use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use>
                    </svg>
                    Website
                </a>
                <ul class="collapse" id="apps">
                    <li><a href="{{ route('admin.website.slider.index') }}" wire:navigate>Hero Slider</a></li>
                    <!-- about section   -->
                    <li><a href="{{ route('admin.website.about-section.index') }}" wire:navigate>About Section</a></li>
                    <!-- partner -->
                    <li><a href="{{ route('admin.website.partner.index') }}" wire:navigate>Partners</a></li>
                    <!-- brand section -->
                    <li><a href="{{ route('admin.website.brand-section.index') }}" wire:navigate>Brand Section</a></li>
                    <!-- trending destination section -->
                    <li><a href="{{ route('admin.website.trending-section.index') }}" wire:navigate>Trending Section</a></li>
                    <!-- feature section -->
                    <li><a href="{{ route('admin.website.feature-section.index') }}" wire:navigate>Feature Section</a></li>
                    <!-- discover section -->
                    <li><a href="{{ route('admin.website.discover-section.index') }}" wire:navigate>Discover Section</a></li>
                    <li><a href="{{ route('admin.homepage-content.index') }}">Homepage Content</a></li>
                </ul>
            </li>
            <li>
                <a aria-expanded="false" data-bs-toggle="collapse" href="#location">
                    <svg stroke="currentColor" stroke-width="1.5">
                        <use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use>
                    </svg>
                    Locations
                </a>
                <ul class="collapse" id="location">
                    <li><a href="{{ route('admin.location.country.index') }}" wire:navigate>Country</a></li>
                    <li><a href="{{ route('admin.location.city.index') }}" wire:navigate>City</a></li>
                </ul>
            </li>

            <!-- Settings -->
            <li>
                <a aria-expanded="false" data-bs-toggle="collapse" href="#settings">
                    <svg stroke="currentColor" stroke-width="1.5">
                        <use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use>
                    </svg>
                    Settings
                </a>
                <ul class="collapse" id="settings">
                    <li><a href="{{ route('admin.settings.currency.index') }}" wire:navigate>Currency</a></li>
                    <li><a href="{{ route('admin.settings.language.index') }}" wire:navigate>Language</a></li>
                    <li><a href="{{ route('admin.site-settings.index') }}">General, Header & Footer</a></li>
                </ul>
            </li>

            <!-- Destinations -->
            <li>
                <a aria-expanded="false" data-bs-toggle="collapse" href="#destinations">
                    <svg stroke="currentColor" stroke-width="1.5">
                        <use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use>
                    </svg>
                    Destinations
                </a>
                <ul class="collapse" id="destinations">
                    <li><a href="{{ route('admin.destinations.index') }}" wire:navigate>Index</a></li>
                    <li><a href="{{ route('admin.destinations.faq') }}" wire:navigate>FAQ</a></li>
                </ul>
            </li>

            <!-- tours -->
            <li class="no-sub"><a href="{{ route('admin.bookings.index') }}" wire:navigate><svg stroke="currentColor" stroke-width="1.5"><use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use></svg>Bookings</a></li>
            <li class="no-sub"><a href="{{ route('admin.coupons.index') }}" wire:navigate><svg stroke="currentColor" stroke-width="1.5"><use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use></svg>Coupons</a></li>
            <li class="no-sub"><a href="{{ route('admin.news.index') }}"><svg stroke="currentColor" stroke-width="1.5"><use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use></svg>Blog & News</a></li>
            <li class="no-sub"><a href="{{ route('admin.contact.index') }}" wire:navigate><svg stroke="currentColor" stroke-width="1.5"><use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use></svg>Contact Inbox</a></li>

            <li>
                <a aria-expanded="false" data-bs-toggle="collapse" href="#tours">
                    <svg stroke="currentColor" stroke-width="1.5">
                        <use xlink:href="{{ url('assets/backend/svg/_sprite.svg#stack') }}"></use>
                    </svg>
                    Tours
                </a>
                <ul class="collapse" id="tours">
                    <li><a href="{{ route('admin.tours.index') }}" wire:navigate>Index</a></li>
                    <li><a href="{{ route('admin.tours.amenities') }}" wire:navigate>Amenities</a></li>
                    <li><a href="{{ route('admin.tours.reviews') }}" wire:navigate>Reviews</a></li>
                </ul>
            </li>

            <li class="no-sub">
                <a href="{{ route('admin.dashboard') }}">
                    <svg stroke="currentColor" stroke-width="1.5">
                        <use xlink:href="{{ url('assets/backend/svg/_sprite.svg#squares') }}"></use>
                    </svg>
                    Dashboard widgets
                </a>
            </li>

            <li class="menu-title"><span>Component</span></li>

        </ul>
    </div>

    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>

</nav>
