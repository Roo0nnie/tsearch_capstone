@extends('layouts.app')

@section('header')
    @include('header')
@endsection
@section('nav')
    @include('nav')
@endsection

@section('content')
    <div class="mainWrapper" id="mainWrapper">
        <div class="left-container">
            <div class="left-item bg-white">
                @include('main_layouts.main_announcement')
            </div>
        </div>

        <div class="main-container item bg-white main-content p-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="title thesis-title roboto-bold my-2">E-Resources</div>
            </div>

            <!-- E-Resources Logo Section -->
            <div class="container my-4">
                <div class="row">
                    <!-- ProQuest -->
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://journal.bicol-u.edu.ph/" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/bu.png') }}" alt="ProQuest" class="img-fluid">
                        </a>
                    </div>

                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://www.proquest.com" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/P-ProQuest.png') }}" alt="ProQuest" class="img-fluid">
                        </a>
                    </div>
                    <!-- Gale -->
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://www.gale.com" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/gale.png') }}" alt="Gale" class="img-fluid">
                        </a>
                    </div>
                    <!-- ce-Logic -->
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://www.ce-logic.com" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/ce-logic.png') }}" alt="ce-Logic" class="img-fluid">
                        </a>
                    </div>
                    <!-- World Technologies -->
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://www.worldtechnologies.com" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/world.png') }}" alt="World Technologies"
                                class="img-fluid">
                        </a>
                    </div>
                    <!-- IG Library -->
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://www.iglibrary.com" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/ig.png') }}" alt="IG Library" class="img-fluid">
                        </a>
                    </div>
                    <!-- Digital Media Learning -->
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://www.digitalmedialearning.com" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/digital.png') }}" alt="Digital Media Learning"
                                class="img-fluid">
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://scholar.google.com/" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/google.png') }}" alt="Digital Media Learning"
                                class="img-fluid">
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://ejournals.ph/" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/pej.png') }}" alt="Digital Media Learning"
                                class="img-fluid">
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://phlconnect.ched.gov.ph/home" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/ched.png') }}" alt="Digital Media Learning"
                                class="img-fluid">
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://jgatenext.com/" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/jgate.png') }}" alt="Digital Media Learning"
                                class="img-fluid">
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="https://www.sciencedirect.com/" target="_blank">
                            <img src="{{ asset('assets/img/ebooks/science.png') }}" alt="Digital Media Learning"
                                class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right container for additional content like announcements -->
        <div class="right-container">
            <!-- Include right sidebar content -->
            <div class="right-item bg-white">
                @include('main_layouts.main_rightside') <!-- Include rightside section -->
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 768px) {
            .mainWrapper {
                grid-template-columns: 1fr;
                /* Stack all items in one column */
                grid-template-rows: auto auto auto;
                /* Allow rows to adjust based on content */
            }

            .left-container {
                order: 3;
                /* Left container comes first */
            }

            .main-container {
                order: 1;
                /* Main content comes second */
            }

            .right-container {
                order: 2;
                /* Right container comes last */
                grid-template-columns: 1fr;
                /* Stack everything into a single column */
            }

            .left-item,
            .mid-item {
                width: 100%;
                /* Make sure both items take the full width */
            }
        }
    </style>
@endsection
@section('footer')
    @include('footer')
@endsection


<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    })

    document.addEventListener('keydown', function(e) {
        if (e.key === 'PrintScreen') {
            navigator.clipboard.writeText('Screenshots are disabled.');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "F12") {
            e.preventDefault();
        }
        if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) || (e.ctrlKey && e.key === 'U')) {
            e.preventDefault();
        }
    });
</script>
