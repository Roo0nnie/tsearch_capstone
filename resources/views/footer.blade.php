<footer class=" footer text-center text-lg-start text-white">
    <!-- Grid container -->
    <div class="container p-4 pb-0">
        <!-- Section: Links -->
        <section class="footer-section">
            <!--Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3 text-center">
                    <div class="footer-logo ">
                        @php
                            $url_logo = route('landing.page');

                            if (Auth::guard('guest_account')->check()) {
                                $url_logo = route('guest.account.home');
                            }
                        @endphp
                        <a href="{{ $url_logo }}" class=" ">
                            <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand" />
                        </a>
                    </div>
                    <p>
                        T-Search is your comprehensive research companion, streamlining the process of accessing,
                        submitting, and managing academic theses.
                    </p>
                </div>
                <!-- Grid column -->

                <hr class="w-100 clearfix d-md-none" />

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    @php
                        $url_about = route('about.display');

                        if (Auth::guard('guest_account')->check()) {
                            $url_about = route('guest.about.display');
                        }
                    @endphp
                    <h6 class="text-uppercase mb-4 font-weight-bold"><a href="{{ $url_about }}">About</a></h6>
                    <p>CHED-JIP Recognized Journal as per CMO NO. 50, s. 2018.</p>
                    <p>Print ISSN: 0000-1234</p>
                    <p>Online ISSN: 0000000</p>
                </div>


                <!-- Grid column -->

                <hr class="w-100 clearfix d-md-none" />

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">
                        Useful links
                    </h6>
                    @php
                        $url_home = route('landing.page');
                        $url_browse = route('guest.page');
                        $url_about = route('about.display');

                        if (Auth::guard('guest_account')->check()) {
                            $url_about = route('guest.about.display');
                            $url_browse = route('guest.account.home');
                            $url_home = route('guest.account.home');
                        }
                    @endphp
                    <p>
                        <a class="text-white"><a href="{{ $url_home }}">Home</a></a>
                    </p>
                    <p>
                        <a class="text-white"><a href="{{ $url_browse }}">Browse</a></a>
                    </p>
                    <p>
                        <a class="text-white"><a href="{{ $url_about }}">About</a></a>
                    </p>
                </div>


                <!-- Grid column -->
                <hr class="w-100 clearfix d-md-none" />

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Contact Us</h6>
                    <p><i class="fa-solid fa-map-location-dot" style="font-size: 1.5em;"></i> Address: Magsaysay Street,
                        Salog (Pob.), Sorsogon City, Sorsogon, 4700</p>
                    <p><i class="fas fa-envelope mr-3" style="font-size: 1.5em;"></i> ssc@sorsu.edu.ph,
                        library@sorsu.edu.ph</p>
                    <p><i class="fas fa-phone mr-3" style="font-size: 1.5em;"></i> (056) 211-0103</p>



                </div>
                <!-- Grid column -->
            </div>
            <!--Grid row-->
        </section>
        <!-- Section: Links -->

        <hr class="my-3">

        <!-- Section: Copyright -->
        <section class="p-3 pt-0">
            <div class="row d-flex align-items-center">
                <!-- Grid column -->
                <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <!-- Copyright -->
                    <div class="p-3">
                        © 2024 Copyright:
                        T-search Management System. All rights reserved.
                    </div>
                    <!-- Copyright -->
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
                    <!-- Facebook -->
                    <a class="btn btn-outline-light btn-floating m-1"
                        href="https://web.facebook.com/sorsogonstateuniversityofficial" target="_blank"
                        class="text-white" role="button"><i class="fab fa-facebook-f"></i></a>

                    <!-- Google -->
                    <a class="btn btn-outline-light btn-floating m-1" href="https://sorsu.edu.ph/" target="_blank"
                        class="text-white" role="button"><i class="fas fa-globe-asia"></i></a>
                </div>
                <!-- Grid column -->
            </div>
        </section>
        <!-- Section: Copyright -->
    </div>
    <!-- Grid container -->
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
