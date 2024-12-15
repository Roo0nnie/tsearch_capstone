@extends('layouts.admin')


@section('content')

    <div>
        <div>
            @if (session('success'))
                <div class="alert alert-success bg-primary text-white" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger bg-danger text-white" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger bg-danger text-white">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">File Content</h3>
                    </div>
                </div>

                <div class="container mt-3">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-12 order-lg-1">

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Title:</strong></p>
                                    <p>{{ $imrad->title }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Abstract:</strong></p>
                                    <p>{{ $imrad->abstract }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Publisher:</strong></p>
                                    <p>{{ $imrad->publisher }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Department:</strong></p>
                                    <p>{{ $imrad->department }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Sustainable Development Goals:</strong></p>
                                    @foreach ($SDGList as $SDG)
                                        <li>
                                            {{ $SDG }}
                                        </li>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Keywords:</strong></p>
                                    <p>{{ $imrad->keywords }}</p>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-6 col-12 order-lg-2">

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Category:</strong></p>
                                    <p>{{ $imrad->category }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Published:</strong></p>
                                    <p>{{ $imrad->publication_date }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Author/s:</strong></p>
                                    @foreach ($authorsArray as $author)
                                        <li>
                                            {{ $author }}
                                        </li>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Adviser/s</strong></p>
                                    <p>{{ $imrad->adviser }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Call #:</strong></p>
                                    <p>{{ $imrad->location }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Issue:</strong></p>
                                    <p>{{ $imrad->issue }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Volume:</strong></p>
                                    <p>{{ $imrad->volume }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p><strong>PDF File:</strong></p>
                                    <a href="{{ asset('assets/pdf/' . $imrad->pdf_file) }}" target="_blank"
                                        id="downloadPdfButton-{{ $imrad->id }}"
                                        data-pdf-url="{{ asset('assets/pdf/' . $imrad->pdf_file) }}"
                                        data-imrad-id="{{ $imrad->id }}">
                                        Download PDF
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-0">
                        <div>
                            <a href="{{ route('admin.file.published') }}" class="btn btn-secondary">
                                {{ __('Back') }}
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for the active tab
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabView = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTabView) {
                activeTabView = localStorage.getItem('activeTabView') || 'all'; // Default to 'all' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTabView}"]`);
            if (tabToActivate) {
                var tab = new bootstrap.Tab(tabToActivate);
                tab.show();

                // Activate the content
                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('show', 'active'); // Hide other tab panes
                });
                let contentId = tabToActivate.getAttribute('href');
                document.querySelector(contentId).classList.add('show', 'active');
            }

            // Store active tab in local storage when clicked
            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tab) {
                tab.addEventListener('shown.bs.tab', function(event) {
                    let selectedTab = event.target.getAttribute('data-tab');
                    localStorage.setItem('activeTabView', selectedTab);
                });
            });
        });
    </script>

@endsection
