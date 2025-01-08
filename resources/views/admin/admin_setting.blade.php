@extends('layouts.admin')


@section('content')
    <div>
        <div>

            @if (session('success'))
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Setting</h3>
                    </div>
                </div>

                <div class="container mt-3">
                    <div class="row">

                        <!-- div2 (Top on small screens, left on larger screens) -->
                        <div class="col-lg-8 col-md-6 col-12 order-2 order-md-1 order-lg-1">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="all-account-tab" data-bs-toggle="tab"
                                                href="#all-account" role="tab" aria-controls="all-account"
                                                aria-selected="false" data-tab="all">Archive Configuration</a>

                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="online-account-tab" data-bs-toggle="tab"
                                                href="#online-account" role="tab" aria-controls="online-account"
                                                aria-selected="false" data-tab="online">Delete Configuration</a>
                                        </li>

                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content mt-3">
                                        <!-- Basic Information Tab -->
                                        <div class="tab-pane show active fade" id="all-account" role="tabpanel"
                                            aria-labelledby="all-account-tab">
                                            <div class="container">
                                                <form method="POST" enctype="multipart/form-data" id="profileForm"
                                                    action="{{ route('admin.set.date.archive') }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <div class="row mb-3">
                                                            <p>Configure your preferred <strong>Archive Schedule</strong>
                                                                settings to automatically
                                                                track and schedule when your archives will be created. This
                                                                allows you to set up the file into archive effortlessly.</p>
                                                            <label for="date"
                                                                class="col-md-2 col-form-label">{{ __('Set Date') }}</label>
                                                            <div class="col-md-8">
                                                                <select id="date" name="date"
                                                                    class="form-control @error('date') is-invalid @enderror"
                                                                    autocomplete="date" autofocus>
                                                                    <option value="">Select Frequency</option>
                                                                    <option value="1"
                                                                        {{ old('date', isset($set_date->archive_date) && $set_date->archive_date == 1 ? 'selected' : '') }}>
                                                                        Every Year</option>
                                                                    <option value="2"
                                                                        {{ old('date', isset($set_date->archive_date) && $set_date->archive_date == 2 ? 'selected' : '') }}>
                                                                        Every 2 Years</option>
                                                                    <option value="3"
                                                                        {{ old('date', isset($set_date->archive_date) && $set_date->archive_date == 3 ? 'selected' : '') }}>
                                                                        Every 3 Years</option>
                                                                    <option value="4"
                                                                        {{ old('date', isset($set_date->archive_date) && $set_date->archive_date == 4 ? 'selected' : '') }}>
                                                                        Every 4 Years</option>
                                                                    <option value="5"
                                                                        {{ old('date', isset($set_date->archive_date) && $set_date->archive_date == 5 ? 'selected' : '') }}>
                                                                        Every 5 Years</option>
                                                                </select>
                                                                @error('date')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row mb-0">
                                                        <div class="col-md-10 offset-md-2">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Set Date') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <!-- Password Tab -->
                                        <div class="tab-pane fade" id="online-account" role="tabpanel"
                                            aria-labelledby="online-account-tab">
                                            <div class="container">
                                                <form method="POST" enctype="multipart/form-data" id="profileForm"
                                                    action="{{ route('admin.set.date.delete') }}">
                                                    @csrf

                                                    @method('PUT')
                                                    <div id="">
                                                        <div class="row mb-3">
                                                            <p>
                                                            <p>Set your preferred <strong>Permanent Delete</strong> settings
                                                                to automatically
                                                                track and schedule when will the <strong>DATA</strong> will
                                                                be removed.</p>
                                                            </p>
                                                            <label for="delete"
                                                                class="col-md-2 col-form-label">{{ __('Set Date') }}</label>
                                                            <div class="col-md-8">
                                                                <div class="col-md-8">
                                                                    <select id="delete" name="delete"
                                                                        class="form-control @error('delete') is-invalid @enderror"
                                                                        autocomplete="delete" autofocus>
                                                                        <option value="">Select Frequency</option>
                                                                        @for ($i = 1; $i <= 25; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ old('delete', isset($delete_setDate->delete_date) && $delete_setDate->delete_date == $i ? 'selected' : '') }}>
                                                                                Every {{ $i }}
                                                                                {{ $i == 1 ? 'Day' : 'Days' }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                    @error('delete')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>

                                                                @error('delete')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-0">
                                                        <div class="col-md-10 offset-md-2">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Set Date') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
    <script>
        function calculateAge() {
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');

            if (birthdayInput.value) {
                const birthDate = new Date(birthdayInput.value);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();

                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                ageInput.value = age;
            } else {
                ageInput.value = '';
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabViewSetting = urlParams.get('tab');

            if (!activeTabViewSetting) {
                activeTabViewSetting = localStorage.getItem('activeTabViewSetting') ||
                    'all';
            }

            let tabToActivate = document.querySelector(`a[data-tab="${activeTabViewSetting}"]`);
            if (tabToActivate) {
                var tab = new bootstrap.Tab(tabToActivate);
                tab.show();

                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('show', 'active');
                });
                let contentId = tabToActivate.getAttribute('href');
                document.querySelector(contentId).classList.add('show', 'active');
            }

            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tab) {
                tab.addEventListener('shown.bs.tab', function(event) {
                    let selectedTab = event.target.getAttribute('data-tab');
                    localStorage.setItem('activeTabViewSetting', selectedTab);
                });
            });
        });
    </script>
@endsection
