<div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a href="{{route('home')}}">
                            <img src="{{ url('assets/frontend/img/logo/aventro.png') }}" alt="logo-img">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <h3 class="offcanvas-title">Hello There!</h3>
                <p>Lorem ipsum dolor sit amet, consectetur <br> adipiscing elit, </p>
                <div class="mobile-menu fix mb-3"></div>
                <div class="offcanvas__contact">
                    <h3>Get Appointment</h3>
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
                            <div class="col-lg-12"><button type="submit" class="theme-btn"><span>Request Appointment</span></button></div>
                        </div>
                    </form>
                    <div class="social-icon d-flex align-items-center">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
