@extends('layouts.admin')



@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Edit IMRAD</h3>

            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit IMRAD Details') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.imrad.update', ['imrad' => $imrad->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title', $imrad->title ?? '') }}" required readonly>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="author"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Authors') }}</label>
                                <div class="col-md-6">
                                    <input id="author" type="text"
                                        class="form-control @error('author') is-invalid @enderror" name="author"
                                        value="{{ old('author', $imrad->author ?? '') }}" required readonly>
                                    @error('author')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="adviser"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Adviser') }}</label>
                                <div class="col-md-6">
                                    <input id="adviser" type="text"
                                        class="form-control @error('adviser') is-invalid @enderror" name="adviser"
                                        value="{{ old('adviser', $imrad->adviser ?? '') }}" readonly>
                                    @error('adviser')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="department"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>
                                <div class="col-md-6">
                                    <input id="department" type="text"
                                        class="form-control @error('department') is-invalid @enderror" name="department"
                                        value="{{ old('department', $imrad->department ?? '') }}" required readonly>
                                    @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="abstract"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Abstract') }}</label>
                                <div class="col-md-6">
                                    <textarea id="abstract" class="form-control @error('abstract') is-invalid @enderror" name="abstract" required readonly>{{ old('abstract', $imrad->abstract ?? '') }}</textarea>
                                    @error('abstract')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="publisher"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Publisher') }}</label>
                                <div class="col-md-6">
                                    <input id="publisher" type="text"
                                        class="form-control @error('publisher') is-invalid @enderror" name="publisher"
                                        value="{{ old('publisher', $imrad->publisher ?? '') }}" required readonly>
                                    @error('publisher')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="publication_date"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date') }}</label>
                                <div class="col-md-6">
                                    <input id="publication_date" type="text"
                                        class="form-control @error('publication_date') is-invalid @enderror"
                                        name="publication_date"
                                        value="{{ old('publication_date', $imrad->publication_date ?? '') }}" required
                                        readonly>
                                    @error('publication_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="keywords"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Keyword/s') }}</label>
                                <div class="col-md-6">
                                    <input id="keywords" type="text"
                                        class="form-control @error('keywords') is-invalid @enderror" name="keywords"
                                        value="{{ old('keywords', $imrad->keywords ?? '') }}" required readonly>
                                    @error('keywords')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="location"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Call #') }}</label>
                                <div class="col-md-6">
                                    <input id="location" type="text"
                                        class="form-control @error('location') is-invalid @enderror" name="location"
                                        value="{{ old('keywords', $imrad->location ?? '') }}">
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="row mb-3">
                                <label for="SDG"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Social Development Goal') }}</label>
                                <div class="col-md-6">
                                    <input id="SDG" type="text"
                                        class="form-control @error('SDG') is-invalid @enderror" name="SDG"
                                        value="{{ old('keywords', $imrad->SDG ?? '') }}" readonly>
                                    @error('SDG')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="volume"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Volume') }}</label>
                                <div class="col-md-6">
                                    <input id="volume" type="text"
                                        class="form-control @error('volume') is-invalid @enderror" name="volume"
                                        value="{{ old('keywords', $imrad->volume ?? '') }}" readonly>
                                    @error('volume')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="issue"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Issue') }}</label>
                                <div class="col-md-6">
                                    <input id="issue" type="text"
                                        class="form-control @error('issue') is-invalid @enderror" name="issue"
                                        value="{{ old('keywords', $imrad->issue ?? '') }}" readonly>
                                    @error('issue')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pdf_file"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Click to view File') }}</label>
                                <div class="col-md-6">
                                    @if ($imrad->pdf_file)
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($imrad->pdf_file) }}"
                                                target="_blank">{{ basename($imrad->pdf_file) }}</a>
                                        </div>
                                    @endif

                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update File') }}
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
