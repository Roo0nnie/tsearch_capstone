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

        <div class="main-container item bg-white main-content">

            <!-- Article Content -->
            <div class="article-list">
                <div class="article mb-3 p-3">
                    <div class="non-select">
                        <div class="thesis-title roboto-bold bg-maroon px-4 py-1 d-inline-block text-white rounded-1">
                            {{ $imrad->category }}</div>

                        <div class="title thesis-title roboto-bold mt-2">{{ $imrad->title }}</div>
                        <div class="">
                            <!-- Display rating stars -->
                            <div class="rating-display">
                                @foreach (range(5, 1) as $display)
                                    <input type="radio" id="rating-display{{ $display }}-{{ $imrad->id }}"
                                        name="rating-display-{{ $imrad->id }}" value="{{ $display }}"
                                        @if ($imrad->imradMetric && $imrad->imradMetric->rates == $display) checked @endif @disabled(true) />
                                    <label for="rating-display{{ $display }}-{{ $imrad->id }}"
                                        title="{{ $display }} stars"></label>
                                @endforeach
                            </div>

                            <div class="">
                                <!-- Display the number of user rate -->
                                @php
                                    $userCount = $imrad->ratings()->distinct('user_code')->count('user_code');
                                @endphp

                                <p class="mb-2"><strong>User Rate: {{ $userCount }}</strong></p>
                            </div>
                        </div>
                    </div>

                    <div class="non-select">
                        <p class="abstract" id="abstract" style="text-align: justify">{{ $imrad->abstract }}</p>
                        <p class="my-2"><strong>School:</strong> {{ ucwords(strtolower($imrad->publisher)) }}</p>
                        <p class="my-2"><strong>Department:</strong> {{ $imrad->department }}</p>
                        <p class="my-2"><strong>Author/s:</strong> {{ $imrad->author }}</p>
                        <p class="my-2"><strong>Adviser/s:</strong> {{ $imrad->adviser }}</p>
                        <p class="my-2"><strong>Call No.:</strong> {{ $imrad->location }}</p>
                        <p class="my-2"><strong>Keyword:</strong> {{ $imrad->keywords }}</p>
                        <p class="my-2"><strong>Social Development Goal:</strong>

                            @php
                                $SDGMapping = [
                                    1 => 'No Poverty',
                                    2 => 'Zero Hunger',
                                    3 => 'Good Health and Well-being',
                                    4 => 'Quality Education',
                                    5 => 'Gender Equality',
                                    6 => 'Clean Water and Sanitation',
                                    7 => 'Affordable and Clean Energy',
                                    8 => 'Decent Work and Economic Growth',
                                    9 => 'Industry, Innovation, and Infrastructure',
                                    10 => 'Reduced Inequalities',
                                    11 => 'Sustainable Cities and Communities',
                                    12 => 'Responsible Consumption and Production',
                                    13 => 'Climate Action',
                                    14 => 'Life Below Water',
                                    15 => 'Life on Land',
                                    16 => 'Peace, Justice, and Strong Institutions',
                                    17 => 'Partnerships for the Goals',
                                ];

                                $SDGNO = [];
                                $SDGList = [];

                                $sdgArray = explode(',', $imrad->SDG);

                                foreach ($sdgArray as $sdgItem) {
                                    $trimmedName = trim($sdgItem);
                                    $sdgNumber = (int) $trimmedName;

                                    if (!in_array($sdgNumber, $SDGNO)) {
                                        $SDGNO[] = $sdgNumber;
                                        if (isset($SDGMapping[$sdgNumber])) {
                                            $SDGList[$sdgNumber] = $SDGMapping[$sdgNumber];
                                        }
                                    }
                                    echo $SDGList[$sdgNumber] . ', ';
                                }

                            @endphp
                        </p>
                        <p class="my-2"><strong>Year:</strong> {{ $imrad->publication_date }}</p>
                    </div>
                    <div
                        class="d-flex flex-lg-row flex-column justify-content-lg-between align-items-lg-start align-items-center mt-2">
                        <div>
                            @if (Auth::guard('guest_account')->check())
                                <a href="{{ asset('assets/pdf/' . $imrad->pdf_file) }}" class="btn btn-download"
                                    target="_blank" id="downloadPdfButton-{{ $imrad->id }}"
                                    data-pdf-url="{{ asset('assets/pdf/' . $imrad->pdf_file) }}"
                                    data-imrad-id="{{ $imrad->id }}">
                                    Download PDF
                                </a>
                            @endif

                            <button class="btn btn-cite" data-bs-toggle="modal"
                                data-bs-target="#modalCitation{{ $imrad->id }}">Cite</button>

                            @if (Auth::guard('guest_account')->check())
                                <form action="{{ route('guest.account.home.save.imrad', ['imrad' => $imrad->id]) }}"
                                    method="post" class="save-imrad-form" style="display: inline">
                                    @csrf
                                    <button type="submit" class="btn btn-save">Save</button>
                                </form>
                            @endif
                        </div>

                        <div>
                            @if (Auth::user())
                                <div class="d-flex justify-center align-items-center">
                                    <div class="me-2">My Rate:</div>
                                    <form id="rating-form-{{ $imrad->id }}"
                                        action="{{ route('guest.account.rating.store') }}" method="POST">
                                        @csrf
                                        <div class="rating">
                                            <input type="radio" id="star5-{{ $imrad->id }}" name="rating"
                                                value="5" @if ($rating == 5) checked @endif />
                                            <label for="star5-{{ $imrad->id }}" title="5 stars"></label>
                                            <input type="radio" id="star4-{{ $imrad->id }}" name="rating"
                                                value="4" @if ($rating == 4) checked @endif />
                                            <label for="star4-{{ $imrad->id }}" title="4 stars"></label>
                                            <input type="radio" id="star3-{{ $imrad->id }}" name="rating"
                                                value="3" @if ($rating == 3) checked @endif />
                                            <label for="star3-{{ $imrad->id }}" title="3 stars"></label>
                                            <input type="radio" id="star2-{{ $imrad->id }}" name="rating"
                                                value="2" @if ($rating == 2) checked @endif />
                                            <label for="star2-{{ $imrad->id }}" title="2 stars"></label>
                                            <input type="radio" id="star1-{{ $imrad->id }}" name="rating"
                                                value="1" @if ($rating == 1) checked @endif />
                                            <label for="star1-{{ $imrad->id }}" title="1 star"></label>
                                        </div>
                                        <input type="hidden" name="imrad_id" value="{{ $imrad->id }}" />
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Citation for generating citations in different formats -->
        <div class="modal fade" id="modalCitation{{ $imrad->id }}" tabindex="-1"
            aria-labelledby="modalCitation{{ $imrad->id }}" aria-hidden="true" style="z-index: 1300;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <p><strong>{{ $imrad->title }}</strong></p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <p><strong>MLA:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            @php
                                $authors = explode(',', $imrad->author);
                                $formattedAuthors = [];

                                foreach ($authors as $author) {
                                    $author = trim($author);

                                    if (empty($author)) {
                                        continue;
                                    }

                                    preg_match('/(.*?)(, R\.M\., BSM|, R\.M\., BSM|, R\.M\.)?$/', $author, $matches);

                                    $fullName = trim($matches[1]);
                                    $credentials = trim($matches[2] ?? '');

                                    $nameParts = explode(' ', $fullName);

                                    $firstName = '';
                                    $middleName = '';
                                    $lastName = '';

                                    if (count($nameParts) >= 2) {
                                        $middleInitialPosition = null;
                                        $middleName = '';

                                        for ($i = count($nameParts) - 1; $i >= 0; $i--) {
                                            if (preg_match('/[A-Z]\.?$/', $nameParts[$i])) {
                                                $middleInitialPosition = $i;
                                                $middleName = $nameParts[$i];
                                                break;
                                            }
                                        }

                                        if ($middleInitialPosition !== null) {
                                            $firstName = implode(
                                                ' ',
                                                array_slice($nameParts, 0, $middleInitialPosition),
                                            );
                                            $lastName = implode(
                                                ' ',
                                                array_slice($nameParts, $middleInitialPosition + 1),
                                            );
                                        } else {
                                            $lastName = array_pop($nameParts);
                                            $firstName = implode(' ', $nameParts);
                                        }
                                    } else {
                                        $firstName = $nameParts[0];
                                        $lastName = '';
                                        $middleName = '';
                                    }

                                    $formattedName = "{$lastName}, {$firstName}";
                                    if (!empty($middleName)) {
                                        $formattedName .= " {$middleName[0]}.";
                                    }

                                    if (
                                        !in_array($lastName, ['R.M.', 'BSM', 'R.M']) &&
                                        !in_array($formattedName, $formattedAuthors)
                                    ) {
                                        $formattedAuthors[] = $formattedName;
                                    }
                                }

                                if (count($formattedAuthors) >= 3) {
                                    $formattedAuthors = [
                                        implode(' & ', array_slice($formattedAuthors, 0, 1)) . ' et al.',
                                    ];
                                }

                                $mlaAuthors = implode(' & ', $formattedAuthors);
                            @endphp

                            {{ $mlaAuthors }}. "{{ ucfirst(strtolower($imrad->title)) }}."
                            <em>{{ ucwords(strtolower($imrad->publisher)) }}</em>
                            {{ $imrad->volume }}.{{ $imrad->issue }}
                            ({{ date($imrad->publication_date) }}).
                        </div>

                        <p><strong>APA:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            @php
                                $authors = explode(',', $imrad->author);
                                $apaAuthors = [];

                                foreach ($authors as $authorEntry) {
                                    $authorEntry = trim($authorEntry);

                                    if (empty($authorEntry)) {
                                        continue;
                                    }

                                    preg_match('/(.*?)(, R\.M\., BSM|, R\.M\.)?$/', $authorEntry, $matches);
                                    $fullName = trim($matches[1] ?? '');
                                    $credentials = trim($matches[2] ?? '');

                                    $nameParts = explode(' ', $fullName);
                                    $lastName = array_pop($nameParts);
                                    $firstName = array_shift($nameParts);
                                    $middleName = implode(' ', $nameParts);

                                    $formattedName = "{$lastName}, " . ($firstName[0] ?? '') . '.';
                                    if (!empty($middleName)) {
                                        $formattedName .= ' ' . substr($middleName, 0, 1) . '.';
                                    }

                                    if ($lastName != 'R.M.' && $lastName != 'BSM' && $lastName != 'R.M') {
                                        if (!in_array($formattedName, $apaAuthors)) {
                                            $apaAuthors[] = $formattedName;
                                        }
                                    }
                                }

                                $formattedAuthorString = implode(', ', $apaAuthors);
                            @endphp

                            {{ $formattedAuthorString }}. ({{ date($imrad->publication_date) }}).
                            {{ ucfirst(strtolower($imrad->title)) }}.
                            <em>{{ ucwords(strtolower($imrad->publisher)) }}</em>
                            @if ($imrad->volume || $imrad->issue)
                                , {{ $imrad->volume }}@if ($imrad->issue)
                                    ({{ $imrad->issue }}).
                                @endif
                            @endif
                        </div>

                        <p><strong>Chicago:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            @php
                                $authors = explode(',', $imrad->author);
                                $formattedAuthorList = [];
                                $isFirstAuthor = true;

                                foreach ($authors as $authorEntry) {
                                    $authorEntry = trim($authorEntry);

                                    if (empty($authorEntry)) {
                                        continue;
                                    }

                                    preg_match('/(.*?)(, R\.M\., BSM|, R\.M\.)?$/', $authorEntry, $matches);
                                    $fullName = trim($matches[1] ?? '');
                                    $credentials = trim($matches[2] ?? '');

                                    $nameParts = explode(' ', $fullName);
                                    $lastName = array_pop($nameParts);
                                    $firstName = array_shift($nameParts);
                                    $middleName = implode(' ', $nameParts);

                                    if ($isFirstAuthor) {
                                        $formattedName = "{$lastName}, {$firstName}";
                                        if (!empty($middleName)) {
                                            $formattedName .= ' ' . substr($middleName, 0, 1) . '.';
                                        }
                                        $isFirstAuthor = false;
                                    } else {
                                        $formattedName = "{$firstName} {$lastName}";
                                    }

                                    if (
                                        !in_array($lastName, ['R.M.', 'BSM', 'R.M']) &&
                                        !in_array($formattedName, $formattedAuthorList)
                                    ) {
                                        $formattedAuthorList[] = $formattedName;
                                    }
                                }

                                if (count($formattedAuthorList) != 1) {
                                    $chicagoAuthorString = implode(', ', array_slice($formattedAuthorList, 0, -1));
                                    if (count($formattedAuthorList) > 1) {
                                        $chicagoAuthorString .= ', and ' . end($formattedAuthorList);
                                    }
                                }

                                $chicagoAuthorString = implode(', ', $formattedAuthorList);

                            @endphp

                            {{ $chicagoAuthorString }}. "{{ ucfirst(strtolower($imrad->title)) }}."
                            <em>{{ ucwords(strtolower($imrad->publisher)) }}</em>
                            @if ($imrad->volume)
                                {{ $imrad->volume }},
                            @endif
                            @if ($imrad->issue)
                                no. {{ $imrad->issue }}
                            @endif
                            ({{ date($imrad->publication_date) }}).
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-save" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // nonCopy();

            saveImradForms();
            submitRatingForms();
        });

        // function nonCopy() {
        //     $ifGuest = document.getElementById('select').value;
        //     let elements = document.querySelectorAll('.non-select');

        //     if ($ifGuest === 'true') {
        //         elements.forEach(element => {
        //             element.className = 'select';
        //         });
        //     } else {
        //         elements.forEach(element => {
        //             element.className = 'non-select';
        //         });
        //     }

        // }

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
                                    title: 'File saved',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'info',
                                    title: 'You have already saved this file',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        })
                        .catch(error => {

                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: 'You have already saved this file',
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
