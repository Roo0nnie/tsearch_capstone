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
            <div>
                <div class="">
                    <div class="title thesis-title roboto-bold my-2">My Library</div>
                </div>

                <form method="GET" action="{{ route('guest.account.home.view.mylibrary') }}" class="w-100 mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" name="query" class="form-control" value="{{ old('query', $query) }}"
                            placeholder="Search...">
                        <button type="submit" class="btn btn-search">Search</button>
                    </div>
                </form>

                @if (!empty($query) && $query != $querySuggestions)
                    @if (Auth::guard('guest_account')->check())
                        <div class="d-flex justify-content-center align-items-center flex-col">
                            <p>You can click the suggested word:</p>
                            <a href="{{ route('guest.account.home.view.mylibrary', ['query' => $querySuggestions]) }}">
                                <span class="badge mt-2 mb-2 fs-5 btn-anno"> {{ $querySuggestions }}</span>
                            </a>
                        </div>
                    @endif
                @endif
            </div>

            @forelse ($savefiles as $savefile)
                <ul class="list-group mb-3">
                    <li class="list-group-item py-3">
                        <div class="non-select">
                            <div>
                                <div
                                    class="thesis-title roboto-bold bg-maroon px-4 py-1 d-inline-block text-white rounded-1">
                                    {{ $savefile->imrad->category }}</div>
                                <h3 class="title thesis-title roboto-bold my-2" id="viewsButton-{{ $savefile->imrad->id }}"
                                    data-imrad-id="{{ $savefile->imrad->id }}">
                                    <a href="#" class="view-imrad-link" data-imrad-id="{{ $savefile->imrad->id }}"
                                        data-pdf-url="
                           @if (Auth::guard('guest_account')->check()) {{ route('guest_account.home.view.file', ['imrad' => $savefile->imrad->id]) }}
                           @else
                           {{ route('guest.view.file', ['imrad' => $savefile->imrad->id]) }} @endif
                           ">
                                        {{ $savefile->imrad->title }}
                                    </a>
                                </h3>
                            </div>

                            <div>
                                <p class="abstract-text mb-2" id="abstract-{{ $savefile->imrad->id }}">
                                    {{ $savefile->imrad->abstract }}</p>

                                <!-- Display other article details like school, author, call number, keywords, SDG, and department -->
                                <p><strong>School:</strong> {{ $savefile->imrad->publisher }}</p>
                                <p><strong>Author:</strong> {{ $savefile->imrad->author }}</p>
                                <p><strong>Department:</strong> {{ $savefile->imrad->department }}</p>
                                <p><strong>Call No.:</strong> {{ $savefile->imrad->location }}</p>
                                <p><strong>Keyword:</strong> {{ $savefile->imrad->keywords }}</p>
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

                                        $sdgArray = explode(',', $savefile->imrad->SDG);

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
                                <p><strong>Year:</strong> {{ $savefile->imrad->publication_date }}</p>
                            </div>
                        </div>

                        <!-- Button Group: Download PDF, Cite, and Unsave -->
                        <div
                            class="d-flex flex-lg-row flex-column justify-content-lg-between align-items-lg-start align-items-center mt-2">
                            <div class="d-flex">
                                <a href="{{ asset('assets/pdf/' . $savefile->imrad->pdf_file) }}" class="btn btn-download"
                                    target="_blank" id="downloadPdfButton-{{ $savefile->imrad->id }}"
                                    data-pdf-url="{{ asset('assets/pdf/' . $savefile->imrad->pdf_file) }}"
                                    data-imrad-id="{{ $savefile->imrad->id }}">
                                    Download PDF
                                </a>
                                <button class="btn btn-cite mx-1" data-bs-toggle="modal"
                                    data-bs-target="#modalCitation{{ $savefile->imrad->id }}">Cite</button>

                                <!-- Modal Citation for generating citations in different formats -->
                                <div class="modal fade" id="modalCitation{{ $savefile->imrad->id }}" tabindex="-1"
                                    aria-labelledby="modalCitation{{ $savefile->imrad->id }}" aria-hidden="true"
                                    style="z-index: 1300;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <p><strong>{{ $savefile->imrad->title }}</strong></p>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <p><strong>MLA:</strong></p>
                                                <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                                                    @php
                                                        $authors = explode(',', $savefile->imrad->author);
                                                        $formattedAuthors = [];

                                                        foreach ($authors as $author) {
                                                            $author = trim($author);

                                                            if (empty($author)) {
                                                                continue;
                                                            }

                                                            preg_match(
                                                                '/(.*?)(, R\.M\., BSM|, R\.M\., BSM|, R\.M\.)?$/',
                                                                $author,
                                                                $matches,
                                                            );

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
                                                                        array_slice(
                                                                            $nameParts,
                                                                            0,
                                                                            $middleInitialPosition,
                                                                        ),
                                                                    );
                                                                    $lastName = implode(
                                                                        ' ',
                                                                        array_slice(
                                                                            $nameParts,
                                                                            $middleInitialPosition + 1,
                                                                        ),
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
                                                                implode(' & ', array_slice($formattedAuthors, 0, 1)) .
                                                                ' et al.',
                                                            ];
                                                        }

                                                        $mlaAuthors = implode(' & ', $formattedAuthors);
                                                    @endphp

                                                    {{ $mlaAuthors }}.
                                                    "{{ ucfirst(strtolower($savefile->imrad->title)) }}."
                                                    <em>{{ ucwords(strtolower($savefile->imrad->publisher)) }}</em>
                                                    {{ $savefile->imrad->volume }}.{{ $savefile->imrad->issue }}
                                                    ({{ date($savefile->imrad->publication_date) }})
                                                </div>

                                                <p><strong>APA:</strong></p>
                                                <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                                                    @php
                                                        $authors = explode(',', $savefile->imrad->author);
                                                        $apaAuthors = [];

                                                        foreach ($authors as $authorEntry) {
                                                            $authorEntry = trim($authorEntry);

                                                            if (empty($authorEntry)) {
                                                                continue;
                                                            }

                                                            preg_match(
                                                                '/(.*?)(, R\.M\., BSM|, R\.M\.)?$/',
                                                                $authorEntry,
                                                                $matches,
                                                            );
                                                            $fullName = trim($matches[1] ?? '');
                                                            $credentials = trim($matches[2] ?? '');

                                                            $nameParts = explode(' ', $fullName);
                                                            $lastName = array_pop($nameParts);
                                                            $firstName = array_shift($nameParts);
                                                            $middleName = implode(' ', $nameParts);

                                                            $formattedName =
                                                                "{$lastName}, " . ($firstName[0] ?? '') . '.';
                                                            if (!empty($middleName)) {
                                                                $formattedName .= ' ' . substr($middleName, 0, 1) . '.';
                                                            }

                                                            if (
                                                                $lastName != 'R.M.' &&
                                                                $lastName != 'BSM' &&
                                                                $lastName != 'R.M'
                                                            ) {
                                                                if (!in_array($formattedName, $apaAuthors)) {
                                                                    $apaAuthors[] = $formattedName;
                                                                }
                                                            }
                                                        }

                                                        $formattedAuthorString = implode(', ', $apaAuthors);
                                                    @endphp

                                                    {{ $formattedAuthorString }}.
                                                    ({{ date($savefile->imrad->publication_date) }}).
                                                    {{ ucfirst(strtolower($savefile->imrad->title)) }}.
                                                    <em>{{ ucwords(strtolower($savefile->imrad->publisher)) }}</em>
                                                    @if ($savefile->imrad->volume || $savefile->imrad->issue)
                                                        , {{ $savefile->imrad->volume }}@if ($savefile->imrad->issue)
                                                            ({{ $savefile->imrad->issue }}).
                                                        @endif
                                                    @endif
                                                </div>

                                                <p><strong>Chicago:</strong></p>
                                                <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                                                    @php
                                                        $authors = explode(',', $savefile->imrad->author);
                                                        $formattedAuthorList = [];
                                                        $isFirstAuthor = true;

                                                        foreach ($authors as $authorEntry) {
                                                            $authorEntry = trim($authorEntry);

                                                            if (empty($authorEntry)) {
                                                                continue;
                                                            }

                                                            preg_match(
                                                                '/(.*?)(, R\.M\., BSM|, R\.M\.)?$/',
                                                                $authorEntry,
                                                                $matches,
                                                            );
                                                            $fullName = trim($matches[1] ?? '');
                                                            $credentials = trim($matches[2] ?? '');

                                                            $nameParts = explode(' ', $fullName);
                                                            $lastName = array_pop($nameParts);
                                                            $firstName = array_shift($nameParts);
                                                            $middleName = implode(' ', $nameParts);

                                                            if ($isFirstAuthor) {
                                                                $formattedName = "{$lastName}, {$firstName}";
                                                                if (!empty($middleName)) {
                                                                    $formattedName .=
                                                                        ' ' . substr($middleName, 0, 1) . '.';
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

                                                        $chicagoAuthorString = implode(
                                                            ', ',
                                                            array_slice($formattedAuthorList, 0, -1),
                                                        );
                                                        if (count($formattedAuthorList) > 1) {
                                                            $chicagoAuthorString .=
                                                                ', and ' . end($formattedAuthorList);
                                                        }
                                                    @endphp

                                                    {{ $chicagoAuthorString }}.
                                                    "{{ ucfirst(strtolower($savefile->imrad->title)) }}."
                                                    <em>{{ ucwords(strtolower($savefile->imrad->publisher)) }}</em>
                                                    @if ($savefile->imrad->volume)
                                                        {{ $savefile->imrad->volume }},
                                                    @endif
                                                    @if ($savefile->imrad->issue)
                                                        no. {{ $savefile->imrad->issue }}
                                                    @endif
                                                    ({{ date($savefile->imrad->publication_date) }}).
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-save"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unsave form with DELETE method -->
                                <form
                                    action="{{ route('guest.account.home.unsave.imrad', ['imrad' => $savefile->imrad->id]) }}"
                                    method="POST" class="save-imrad-form" id="unsave-file-{{ $savefile->imrad->id }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-save"
                                    onclick="unsaveImradForms({{ $savefile->imrad->id }})">Unsave</button>

                            </div>
                            <div class="">
                                <!-- Display rating stars -->
                                <div class="rating-display">
                                    @foreach (range(5, 1) as $rating)
                                        <input type="radio" id="star{{ $rating }}-{{ $savefile->imrad->id }}"
                                            name="rating-{{ $savefile->imrad->id }}" value="{{ $rating }}"
                                            @if ($savefile->imrad->imradMetric && $savefile->imrad->imradMetric->rates == $rating) checked @endif @disabled(true) />
                                        <label for="star{{ $rating }}-{{ $savefile->imrad->id }}"
                                            title="{{ $rating }} stars"></label>
                                    @endforeach
                                </div>

                                @php
                                    $userCount = $savefile->imrad->ratings()->distinct('user_code')->count('user_code');
                                @endphp

                                <div>User Rate : {{ $userCount }}</div>
                            </div>
                        </div>
                    </li>
                </ul>
                @empty
                    <div class="d-flex justify-content-center align-items-center">
                        @if (!empty($query) && $query != $querySuggestions)
                            <div class="title thesis-title roboto-bold my-2">No result based on search term.</div>
                        @endif

                        @if (empty($query) && empty($querySuggestions))
                            <div class="title thesis-title roboto-bold my-2">No saved file/s</div>
                        @endif
                    </div>
                @endforelse

                @if ($savefiles->hasPages())
                    <div class="d-flex justify-content-start align-items-start">
                        @if ($savefiles->onFirstPage())
                        @else
                            <a href="{{ $savefiles->previousPageUrl() }}" class="btn me-2 text-white"
                                style="background-color: #800000">Previous</a>
                        @endif
                        @if (!$savefiles->hasMorePages())
                        @else
                            <a href="{{ $savefiles->nextPageUrl() }}" class="btn text-white"
                                style="background-color: #800000">Next</a>
                        @endif
                    </div>
                @endif



            </div>

            <div class="right-container">
                <div class="right-item bg-white">
                    @include('main_layouts.main_rightside')
                </div>
            </div>
        </div>
    @endsection

    @section('footer')
        @include('footer')
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            abstract();
            viewsImradForms();
        });

        function abstract() {
            document.querySelectorAll('.abstract-text').forEach(function(element) {
                abstract(element, 500);
            })

            function abstract(element, maxLength) {
                const text = element.textContent;
                if (text.length > maxLength) {
                    element.textContent = text.substr(0, maxLength) + '...';
                }
            }
        }

        function viewsImradForms() {

            var viewLinks = document.querySelectorAll('.view-imrad-link');

            viewLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    var imradId = this.getAttribute('data-imrad-id');
                    var pdfUrl = this.getAttribute('data-pdf-url');

                    fetch(`/update-views/${imradId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({

                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'Download recorded successfully') {
                                setTimeout(() => {
                                    window.location.href =
                                        pdfUrl;
                                }, 500);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

        }

        function unsaveImradForms(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to unsave this item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-cite',
                    cancelButton: 'btn btn-save'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Unsaved Confirmed!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        document.getElementById(`unsave-file-${id}`).submit();
                    }, 1000);
                } else if (result.isDismissed) {
                    Swal.fire({
                        title: 'Unsave canceled!',
                        icon: 'info',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
    </script>
