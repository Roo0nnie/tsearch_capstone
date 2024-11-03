@extends('layouts.admin')


@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Edit Announcement Details</h3>

            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Announcement') }}</div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('admin.announcement.update', ['announcement' => $announcement]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Admin ID -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input id="adminId" type="hidden"
                                        class="form-control @error('adminId') is-invalid @enderror" name="adminId"
                                        value="{{ old('adminId', $announcement->adminId) }}" required readonly>
                                    @error('adminId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title', $announcement->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="row mb-3">
                                <label for="content"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Content') }}</label>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <textarea id="content" class="form-control @error('content') is-invalid @enderror" placeholder="Leave a comment here"
                                            style="height: 100px" name="content" required>{{ old('content', $announcement->content) }}</textarea>
                                        <label for="content">Content</label>
                                        @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="row mb-3">
                                <label for="start"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Start Date and Time') }}</label>
                                <div class="col-md-6">
                                    <input id="start" type="datetime-local"
                                        class="form-control @error('start') is-invalid @enderror" name="start"
                                        value="{{ old('start', $announcement->start) }}" required>
                                    @error('start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="row mb-3">
                                <label for="end"
                                    class="col-md-4 col-form-label text-md-end">{{ __('End Date and Time') }}</label>
                                <div class="col-md-6">
                                    <input id="end" type="datetime-local"
                                        class="form-control @error('end') is-invalid @enderror" name="end"
                                        value="{{ old('end', $announcement->end) }}" required>
                                    @error('end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Distributed To -->
                            <div class="row mb-3">
                                <label for="distributed_to"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Distribute To') }}</label>
                                <div class="col-md-6">
                                    <div class="@error('distributed_to') is-invalid @enderror">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="distributed_to_all"
                                                name="distributed_to[]" value="All"
                                                {{ in_array('All', old('distributed_to', explode(',', $announcement->distributed_to))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="distributed_to_all">All</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="distributed_to_student"
                                                name="distributed_to[]" value="Student"
                                                {{ in_array('Student', old('distributed_to', explode(',', $announcement->distributed_to))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="distributed_to_student">Student</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="distributed_to_faculty"
                                                name="distributed_to[]" value="Faculty"
                                                {{ in_array('Faculty', old('distributed_to', explode(',', $announcement->distributed_to))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="distributed_to_faculty">Faculty</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="distributed_to_guest"
                                                name="distributed_to[]" value="Guest"
                                                {{ in_array('Guest', old('distributed_to', explode(',', $announcement->distributed_to))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="distributed_to_guest">Guest</label>
                                        </div>
                                    </div>
                                    @error('distributed_to')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Attachment -->
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

                                    @if ($announcement->attachment)
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($announcement->attachment) }}"
                                                target="_blank">{{ basename($announcement->attachment) }}</a>
                                        </div>
                                        {{--
                                @if (in_array(pathinfo($announcement->attachment, PATHINFO_EXTENSION), ['jpg', 'png']))
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($announcement->attachment) }}" alt="Attachment"
                                            class="img-fluid">
                                    </div>
                                @endif --}}
                                    @endif
                                </div>

                            </div>


                            <!-- Activation -->
                            {{-- <div class="row mb-3">
                                <label for="activation"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Activate') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select @error('activation') is-invalid @enderror" id="activation"
                                        name="activation" required>
                                        <option value="" disabled>Select Activation</option>
                                        <option value="Activate"
                                            {{ old('activation', $announcement->activation) == 'Activate' ? 'selected' : '' }}>
                                            Activate</option>
                                        <option value="Deactivate"
                                            {{ old('activation', $announcement->activation) == 'Deactivate' ? 'selected' : '' }}>
                                            Deactivate</option>
                                    </select>
                                    @error('activation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <!-- Submit Button -->
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Announcement') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
