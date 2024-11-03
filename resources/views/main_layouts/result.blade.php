@if (!$noResults)
    <!-- Article List -->
    @foreach ($imrads as $imrad)
        <div class="article-list" id="imrad_result">
            <div class="article mb-3 p-3 border">
                <div class="">
                    <div><button class="btn btn-secondary">{{ $imrad->department }}</button></div>
                    <div class="">
                        <div class="rating">
                            @foreach (range(5, 1) as $rating)
                                <input type="radio" id="star{{ $rating }}-{{ $imrad->id }}"
                                    name="rating-{{ $imrad->id }}" value="{{ $rating }}"
                                    @if ($imrad->imradMetric && $imrad->imradMetric->rates == $rating) checked @endif @disabled(true) />
                                <label for="star{{ $rating }}-{{ $imrad->id }}"
                                    title="{{ $rating }} stars"></label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <h3 class="title roboto-bold" id="viewsButton-{{ $imrad->id }}" data-imrad-id="{{ $imrad->id }}">
                    <a href="#" class="view-imrad-link" data-imrad-id="{{ $imrad->id }}"
                        data-pdf-url="
                       @if (Auth::guard('faculty')->check()) {{ route('faculty.home.view.file', ['imrad' => $imrad->id]) }}
                       @elseif (Auth::guard('guest_account')->check())
                       {{ route('guest_account.home.view.file', ['imrad' => $imrad->id]) }}
                       @elseif (Auth::guard('user')->check())
                       {{ route('home.view.file', ['imrad' => $imrad->id]) }}
                       @else
                       {{ route('guest.view.file', ['imrad' => $imrad->id]) }} @endif
                       ">
                        {{ $imrad->title }}
                    </a>
                </h3>
                <p class="abstract" id="abstract">{{ $imrad->abstract }}</p>
                <p><strong>Author:</strong> {{ $imrad->author }}</p>
                <p><strong>Keyword:</strong> {{ $imrad->keywords }}</p>
                <p><strong>School:</strong> {{ $imrad->publisher }}</p>
                <p><strong>Social Development Goal:</strong> {{ $imrad->SDG }}</p>

                <div class="d-flex justify-content-between">
                    <div>
                        @if ($imrad->pdf_file)
                            <a href="#" class="btn btn-danger" id="downloadPdfButton-{{ $imrad->id }}"
                                data-pdf-url="{{ Storage::url($imrad->pdf_file) }}"
                                data-imrad-id="{{ $imrad->id }}">Download PDF</a>
                        @endif
                        <button class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modalCitation{{ $imrad->id }}">Cite</button>

                        @if (Auth::guard('user')->check())
                            <form id="save-imrad-form-{{ $imrad->id }}" class="save-imrad-form"
                                action="{{ route('home.save.imrad', ['imrad' => $imrad->id]) }}" method="post"
                                style="display: inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Save</button>
                            </form>
                        @endif

                        @if (Auth::guard('faculty')->check())
                            <form id="save-imrad-form-{{ $imrad->id }}" class="save-imrad-form"
                                action="{{ route('faculty.home.save.imrad', ['imrad' => $imrad->id]) }}" method="post"
                                style="display: inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Save</button>
                            </form>
                        @endif

                        @if (Auth::guard('guest_account')->check())
                            <form id="save-imrad-form-{{ $imrad->id }}" class="save-imrad-form"
                                action="{{ route('guest.account.home.save.imrad', ['imrad' => $imrad->id]) }}"
                                method="post" style="display: inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Save</button>
                            </form>
                        @endif
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
                            {{ $imrad->title }}
                            @if ($imrad->volume || $imrad->issue)
                                (Vol. {{ $imrad->volume }}, Iss. {{ $imrad->issue }})
                                .
                            @endif
                            {{ $imrad->publisher }}.
                            @if ($imrad->adviser)
                                Adviser: {{ $imrad->adviser }}.
                            @endif
                            @if ($imrad->department)
                                {{ $imrad->department }}.
                            @endif
                            @if ($imrad->SDG)
                                SDG: {{ $imrad->SDG }}.
                            @endif
                        </div>

                        <p><strong>MLA:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            {{ $imrad->author }}. "{{ $imrad->title }}"
                            @if ($imrad->volume || $imrad->issue)
                                ({{ $imrad->volume }}, {{ $imrad->issue }}),
                            @endif
                            @if ($imrad->publisher)
                                {{ $imrad->publisher }},
                            @endif
                            {{ date('Y', strtotime($imrad->publication_date)) }}.
                            @if ($imrad->adviser)
                                Adviser: {{ $imrad->adviser }}.
                            @endif
                            @if ($imrad->department)
                                {{ $imrad->department }}.
                            @endif
                            @if ($imrad->SDG)
                                SDG: {{ $imrad->SDG }}.
                            @endif
                        </div>

                        <p><strong>Chicago:</strong></p>
                        <div style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">
                            {{ $imrad->author }}. <em>{{ $imrad->title }}</em>.
                            @if ($imrad->volume || $imrad->issue)
                                {{ $imrad->volume }}, {{ $imrad->issue }},
                            @endif
                            @if ($imrad->publisher)
                                {{ $imrad->publisher }},
                            @endif
                            {{ date('Y', strtotime($imrad->publication_date)) }}.
                            @if ($imrad->adviser)
                                Adviser: {{ $imrad->adviser }}.
                            @endif
                            @if ($imrad->department)
                                {{ $imrad->department }}.
                            @endif
                            @if ($imrad->SDG)
                                SDG: {{ $imrad->SDG }}.
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{ $imrads->links() }}
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {

        saveImradForms();
        viewsImradForms();
        downloadImrad();
    });

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
                        // console.error('Error:', error);
                        // Swal.fire({
                        //     position: 'center',
                        //     icon: 'error',
                        //     title: 'An error occurred while saving',
                        //     text: 'Please try again later.',
                        //     showConfirmButton: true
                        // });
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
</script>
