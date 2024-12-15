@if (!$noResults)
    <!-- Article List -->
    @foreach ($imrads as $imrad)
        <div class="article-list" id="imrad_result">
            <div class="article mb-3 p-3 border">
                <div class="non-select">
                    <div class="thesis-title roboto-bold bg-maroon px-4 py-1 d-inline-block text-white rounded-1">
                        {{ $imrad->category }}</div>
                    <h3 class="title thesis-title roboto-bold my-2" id="viewsButton-{{ $imrad->id }}"
                        data-imrad-id="{{ $imrad->id }}">
                        <a href="#" class="view-imrad-link" data-imrad-id="{{ $imrad->id }}"
                            data-pdf-url="
                           @if (Auth::guard('guest_account')->check()) {{ route('guest_account.home.view.file', ['imrad' => $imrad->id]) }}
                           @else
                           {{ route('guest.view.file', ['imrad' => $imrad->id]) }} @endif
                           ">
                            {{ $imrad->title }}
                        </a>
                    </h3>

                    <!-- Display the abstract of the article with a max length -->
                    <div>
                        <p class="abstract-text mb-2" id="abstract-{{ $imrad->id }}">{{ $imrad->abstract }}</p>

                        <!-- Display other article details like school, author, call number, keywords, SDG, and department -->
                        <p><strong>School:</strong> {{ ucwords(strtolower($imrad->publisher)) }}</p>
                        <p><strong>Author:</strong> {{ $imrad->author }}</p>
                        <p><strong>Department:</strong> {{ $imrad->department }}</p>
                        <p><strong>Call No.:</strong> {{ $imrad->location }}</p>
                        <p><strong>Keyword:</strong> {{ $imrad->keywords }}</p>
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
                        <p><strong>Year:</strong> {{ $imrad->publication_date }}</p>

                    </div>
                </div>
                <div
                    class="d-flex flex-lg-row flex-column justify-content-lg-between align-items-lg-start align-items-center mt-2">
                    <div class="">
                        <!-- Button to download the PDF if available -->
                        @if (Auth::guard('guest_account')->check())
                            @if ($imrad->pdf_file)
                                <a href="{{ asset('assets/pdf/' . $imrad->pdf_file) }}" class="btn btn-download"
                                    target="_blank" id="downloadPdfButton-{{ $imrad->id }}"
                                    data-pdf-url="{{ asset('assets/pdf/' . $imrad->pdf_file) }}"
                                    data-imrad-id="{{ $imrad->id }}">
                                    Download PDF
                                </a>
                            @endif
                        @endif

                        <!-- Button to open the citation modal -->
                        <button class="btn btn-cite" data-bs-toggle="modal"
                            data-bs-target="#modalCitation{{ $imrad->id }}">Cite</button>

                        <!-- Form to save the article for guest users -->
                        @if (Auth::guard('guest_account')->check())
                            <form id="save-imrad-form-{{ $imrad->id }}" class="save-imrad-form"
                                action="{{ route('guest.account.home.save.imrad', ['imrad' => $imrad->id]) }}"
                                method="post" style="display: inline">
                                @csrf
                                <button type="submit" class="btn btn-save">Save</button>
                            </form>
                        @endif
                    </div>

                    <div class="">
                        <!-- Display rating stars -->
                        <div class="rating-display">
                            @foreach (range(5, 1) as $rating)
                                <input type="radio" id="star{{ $rating }}-{{ $imrad->id }}"
                                    name="rating-{{ $imrad->id }}" value="{{ $rating }}"
                                    @if ($imrad->imradMetric && $imrad->imradMetric->rates == $rating) checked @endif @disabled(true) />
                                <label for="star{{ $rating }}-{{ $imrad->id }}"
                                    title="{{ $rating }} stars"></label>
                            @endforeach
                        </div>

                        @php
                            $userCount = $imrad->ratings()->distinct('user_code')->count('user_code');
                        @endphp

                        <div class="btn-maroon">User Rate : {{ $userCount }}</div>
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
                            ({{ date($imrad->publication_date) }})
                            .
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
    @endforeach

    <!-- Pagination for article list -->
    @if ($imrads->hasPages())
        <div class="d-flex justify-content-start align-items-start w-100">
            @if ($imrads->onFirstPage())
            @else
                <a href="{{ $imrads->previousPageUrl() }}" class="btn me-2 text-white"
                    style="background-color: #800000">Previous</a>
            @endif
            @if (!$imrads->hasMorePages())
            @else
                <a href="{{ $imrads->nextPageUrl() }}" class="btn text-white"
                    style="background-color: #800000">Next</a>
            @endif
        </div>
    @endif
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {


        saveImradForms();
        viewsImradForms();
        downloadImrad();
        abstract();
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

    function downloadImrad() {

        var downloadButtons = document.querySelectorAll('[id^="downloadPdfButton-"]');

        downloadButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var pdfUrl = this.getAttribute('data-pdf-url');
                var imradId = this.getAttribute('data-imrad-id');

                fetch(`/update-downloads/${imradId}`, {
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

                            window.open(pdfUrl, '_blank');
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
                                title: 'file successfully saved',
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
</script>
