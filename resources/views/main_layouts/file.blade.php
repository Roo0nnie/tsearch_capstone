@extends('layouts.app')

@section('header')
    @include('header')
@endsection
@section('nav')
    @include('nav')
@endsection

@section('content')
    <div class="mainWrapper" id="mainWrapper">
        <div class="left-container item bg-maroon">
            @include('main_layouts.main_announcement', ['noAnnouncements' => $noAnnouncements])
        </div>

        <div class="main-container item bg-white main-content">
            <h1>IMRAD File</h1>

            <!-- Article Content -->
            <div class="article-list">
                <div class="article mb-3 p-3 border">
                    <button class="btn btn-secondary">{{ $imrad->department }}</button>
                    <h3 class="title roboto-bold">{{ $imrad->title }}</h3>
                    <p class="abstract" id="abstract">{{ $imrad->abstract }}</p>
                    <p><strong>Author:</strong> {{ $imrad->author }}</p>
                    <p><strong>Keyword:</strong> {{ $imrad->keywords }}</p>
                    <p><strong>School:</strong> {{ $imrad->publisher }}</p>
                    <div class="d-flex justify-content-between">
                        <div>

                            <a href="{{ Storage::url($imrad->pdf_file) }}" class="btn btn-danger" target="_blank"
                                id="downloadPdfButton-{{ $imrad->id }}"
                                data-pdf-url="{{ Storage::url($imrad->pdf_file) }}" data-imrad-id="{{ $imrad->id }}">
                                Download PDF
                            </a>

                            <button class="btn
                                btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modalCitation{{ $imrad->id }}">Cite</button>

                            @if (Auth::guard('guest_account')->check())
                                <form action="{{ route('guest.account.home.save.imrad', ['imrad' => $imrad->id]) }}"
                                    method="post" class="save-imrad-form" style="display: inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Save</button>
                                </form>
                            @endif
                        </div>

                        <div>
                            @if (Auth::user())
                                <form id="rating-form-{{ $imrad->id }}"
                                    action="
                                    @if (Auth::guard('user')->check()) {{ route('rating.store') }}
                                    @elseif (Auth::guard('faculty')->check()) {{ route('faculty.rating.store') }}
                                    @elseif (Auth::guard('guest_account')->check()) {{ route('guest.account.rating.store') }} @endif
                                "
                                    method="POST">
                                    @csrf
                                    <div class="rating">
                                        <input type="radio" id="star5-{{ $imrad->id }}" name="rating" value="5"
                                            @if ($rating == 5) checked @endif />
                                        <label for="star5-{{ $imrad->id }}" title="5 stars"></label>
                                        <input type="radio" id="star4-{{ $imrad->id }}" name="rating" value="4"
                                            @if ($rating == 4) checked @endif />
                                        <label for="star4-{{ $imrad->id }}" title="4 stars"></label>
                                        <input type="radio" id="star3-{{ $imrad->id }}" name="rating" value="3"
                                            @if ($rating == 3) checked @endif />
                                        <label for="star3-{{ $imrad->id }}" title="3 stars"></label>
                                        <input type="radio" id="star2-{{ $imrad->id }}" name="rating" value="2"
                                            @if ($rating == 2) checked @endif />
                                        <label for="star2-{{ $imrad->id }}" title="2 stars"></label>
                                        <input type="radio" id="star1-{{ $imrad->id }}" name="rating" value="1"
                                            @if ($rating == 1) checked @endif />
                                        <label for="star1-{{ $imrad->id }}" title="1 star"></label>
                                    </div>
                                    <input type="hidden" name="imrad_id" value="{{ $imrad->id }}" />
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Citation -->
        <div class="modal fade" id="modalCitation{{ $imrad->id }}" tabindex="-1"
            aria-labelledby="modalCitation{{ $imrad->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <p><strong>{{ $imrad->title }}</strong></p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>APA:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            {{ $imrad->author }}. ({{ date('Y', strtotime($imrad->publication_date)) }}).
                            {{ $imrad->title }}. {{ $imrad->publisher }}.
                            @if ($imrad->location)
                                {{ $imrad->location }}.
                            @endif
                        </div>

                        <p><strong>MLA:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            {{ $imrad->author }}. "{{ $imrad->title }}."
                            @if ($imrad->publisher)
                                {{ $imrad->publisher }},
                            @endif
                            {{ date('Y', strtotime($imrad->publication_date)) }}
                            @if ($imrad->location)
                                , {{ $imrad->location }}.
                            @endif
                        </div>

                        <p><strong>Chicago:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            {{ $imrad->author }}. <em>{{ $imrad->title }}</em>.
                            @if ($imrad->publisher)
                                {{ $imrad->publisher }},
                            @endif
                            {{ date('Y', strtotime($imrad->publication_date)) }}.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-container item bg-maroon">
            @include('main_layouts.main_rightside')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            saveImradForms();
            submitRatingForms();
            downloadImrad();
        });

        function downloadImrad() {
            var downloadButtons = document.querySelectorAll('[id^="downloadPdfButton-"]');

            downloadButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    var pdfUrl = this.getAttribute('data-pdf-url');
                    var imradId = this.getAttribute('data-imrad-id');

                    // Update download count in the database
                    fetch(`/update-downloads/${imradId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'Download recorded successfully') {
                                window.open(pdfUrl,
                                    '_blank'); // Open PDF in a new tab if the download is recorded
                            } else {
                                console.error('Failed to record download:', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        }

        function saveImradForms() {
            document.querySelectorAll('.save-imrad-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.querySelector('input[name="_token"]')
                                    .value,
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Imrad successfully saved',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'info',
                                    title: 'You have already saved this Imrad',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        })
                        .catch(error => {

                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: 'You have already saved this Imrad',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                });
            });
        }

        function submitRatingForms() {
            document.querySelectorAll('form[id^="rating-form-"]').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Rating submitted successfully!',
                                    text: `Average rating: ${data.average_rating}`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message,
                                    showConfirmButton: true
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred',
                                text: 'Please try again later.',
                                showConfirmButton: true
                            });
                        });
                });
            });
        }
    </script>
@endsection
@section('footer')
    @include('footer')
@endsection

<script src="{{ asset('js/rating.js') }}"></script>
