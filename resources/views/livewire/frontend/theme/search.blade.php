<div class="header-search-bar d-flex align-items-center">
    <button class="search-close">×</button>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="search-bar">
                    <div class="contact-form-box contact-search-form-box">
                        <form action="{{route('search')}}" method="GET">
                            <input type="search" name="q" minlength="2" placeholder="Search tours, destinations, and articles..." required>
                            <button type="submit"><i class="far fa-search"></i></button>
                        </form>
                        <p>Type above and press Enter to search. Press Close to cancel.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
