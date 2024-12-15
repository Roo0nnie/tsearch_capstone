@extends('layouts.admin')



@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3"> Add File</h3>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('File Details') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.imrad.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror"
                                name="id" value="{{ old('id', $article->id ?? '') }}" required readonly>

                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title', $article->title ?? '') }}" required readonly>
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
                                        value="{{ old('author', $article->author ?? '') }}" required readonly>
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
                                        value="{{ old('adviser', $article->adviser ?? '') }}" readonly>
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
                                        value="{{ old('department', $article->department ?? '') }}" required readonly>
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
                                    <textarea id="abstract" class="form-control @error('abstract') is-invalid @enderror" name="abstract" required readonly>{{ old('abstract', $article->abstract ?? '') }}</textarea>
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
                                        value="{{ old('department', $article->publisher ?? '') }}" required readonly>
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
                                        value="{{ old('publication_date', $article->publication_date ?? '') }}" required
                                        readonly>
                                    @error('publication_date')
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
                                        value="">
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="category"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Category') }}</label>
                                <div class="col-md-6">
                                    <select id="category" name="category"
                                        class="form-control @error('category') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select a category</option>
                                        <option value="Technology"
                                            {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology
                                        </option>
                                        <option value="Midwifery" {{ old('category') == 'Midwifery' ? 'selected' : '' }}>
                                            Midwifery
                                        </option>
                                        <option value="Engineering"
                                            {{ old('category') == 'Engineering' ? 'selected' : '' }}>Engineering
                                        </option>
                                        <option value="Architecture"
                                            {{ old('category') == 'Architecture' ? 'selected' : '' }}>Architecture
                                        </option>
                                        <option value="Accountancy"
                                            {{ old('category') == 'Accountancy' ? 'selected' : '' }}>Accountancy
                                        </option>
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('category')
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
                                        readonly value="{{ old('keywords', $article->keywords ?? '') }}">
                                    @error('keywords')
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
                                        class="form-control @error('SDG') is-invalid @enderror" name="SDG" readonly
                                        value="{{ old('SDG', $article->SDG ?? '') }}">
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
                                        readonly value="{{ old('volume', $article->volume ?? '') }}">
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
                                        class="form-control @error('issue') is-invalid @enderror" name="issue" readonly
                                        value="{{ old('issue', $article->issue ?? '') }}">
                                    @error('issue')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 d-flex justify-content-start align-items-center">
                                    <button type="submit" class="btn btn-primary me-2">
                                        {{ __('Add File') }}
                                    </button>
                                    <a href="{{ route('admin.file.draft') }}" class="btn btn-secondary">
                                        {{ __('Back') }}
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
