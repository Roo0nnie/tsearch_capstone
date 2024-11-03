@extends('layouts.admin')


@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3"> Add Announcement</h3>

            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Annoucement') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.announcement.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input id="adminId" type="hidden"
                                        class="form-control @error('adminId') is-invalid @enderror" name="adminId"
                                        value="{{ old('adminId', Auth::guard('admin')->user()->id) }}" required readonly>
                                    @error('adminId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="content"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Content') }}</label>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <textarea id="content" class="form-control @error('content') is-invalid @enderror" placeholder="Leave a comment here"
                                            style="height: 100px" name="content" required>{{ old('content') }}</textarea>
                                        <label for="content">Content</label>
                                        @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="start"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Start Date and Time') }}</label>
                                <div class="col-md-6">
                                    <input id="start" type="datetime-local"
                                        class="form-control @error('start') is-invalid @enderror" name="start"
                                        value="{{ old('start') }}" required>
                                    @error('start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end"
                                    class="col-md-4 col-form-label text-md-end">{{ __('End Date and Time') }}</label>
                                <div class="col-md-6">
                                    <input id="end" type="datetime-local"
                                        class="form-control @error('end') is-invalid @enderror" name="end"
                                        value="{{ old('end') }}" required>
                                    @error('end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="distributed_to"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Distribute To') }}</label>
                                <div class="col-md-6">
                                    <div class="@error('distributed_to') is-invalid @enderror">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="distributed_to_all"
                                                        name="distributed_to[]" value="All" onclick="toggleAll()">
                                                    <label class="form-check-label" for="distributed_to_all">All</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="distributed_to_student" name="distributed_to[]" value="Student">
                                                    <label class="form-check-label"
                                                        for="distributed_to_student">Student</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="distributed_to_faculty" name="distributed_to[]" value="Faculty">
                                                    <label class="form-check-label"
                                                        for="distributed_to_faculty">Faculty</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="distributed_to_guest" name="distributed_to[]" value="Guest">
                                                    <label class="form-check-label"
                                                        for="distributed_to_guest">Guest</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('distributed_to')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="attachment"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Attachment') }}</label>
                                <div class="col-md-6">
                                    <input id="attachment" type="file" accept=".jpg, .png"
                                        class="form-control @error('attachment') is-invalid @enderror" name="attachment">
                                    @error('attachment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="row mb-3">
                                <label for="activation"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Activate') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select @error('activation') is-invalid @enderror" id="activation"
                                        name="activation" required autofocus>
                                        <option value="" disabled selected>Select Activation</option>
                                        <option value="Activate">Activate</option>
                                        <option value="Deactivate">Deactivate</option>
                                    </select>
                                    @error('activation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Announcement') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleAll() {
            var allCheckbox = document.getElementById('distributed_to_all');
            var checkboxes = document.querySelectorAll('input[name="distributed_to[]"]');

            checkboxes.forEach(function(checkbox) {
                if (checkbox !== allCheckbox) {
                    checkbox.checked = allCheckbox.checked;
                }
            });
        }
    </script>
@endsection
