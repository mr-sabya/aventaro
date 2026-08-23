<div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a href="{{route('home')}}">
                            <img src="{{ $settings->logo ? asset('storage/'.$settings->logo) : asset('assets/frontend/img/logo/aventro.png') }}" alt="{{ $settings->site_name }}">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <h3 class="offcanvas-title">{{ $settings->site_name }}</h3>
                <p>{{ $settings->tagline ?: 'Plan your next memorable journey with us.' }}</p>
                <div class="mobile-menu fix mb-3"></div>
                <div class="offcanvas__contact">
                    <h3>Travel Enquiry</h3>
                    @if(session('contact_success'))<div class="alert alert-success">{{session('contact_success')}}</div>@endif
                    <form action="{{route('appointment.store')}}" id="contact-form" method="POST" class="contact-form-items">
                        @csrf
                        <input type="hidden" name="type" value="appointment">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="form-clt">
                                    <input type="text" name="name" id="name33" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-clt">
                                    <input type="email" name="email" id="email33" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-clt">
                                    <textarea name="message" id="message2" minlength="10" required placeholder="Enter message..."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12"><button type="submit" class="theme-btn"><span>Send Enquiry</span></button></div>
                        </div>
                    </form>
                    <div class="social-icon d-flex align-items-center">
                        @foreach(['facebook'=>'facebook-f','instagram'=>'instagram','twitter'=>'twitter','linkedin'=>'linkedin-in'] as $network=>$icon) @if($settings->{$network.'_url'})<a href="{{ $settings->{$network.'_url'} }}" target="_blank" rel="noopener"><i class="fab fa-{{ $icon }}"></i></a>@endif @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
