<!-- Modal -->
<div class="modal fade" id="institutionalLogin" tabindex="-1" aria-labelledby="institutionalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg-transparent row d-flex justify-content-center align-items-center"
            style="border: transparent">
            <div class="col-12 text-center">
                <div class="welcome-box">
                    <div class="circle mb-4">
                        <img src="/resources/image/logo.png" class="img-fluid" alt="">
                    </div>
                    <h1>Thesis Management System</h1>
                    <p>Sorsogon State University</p>
                    <div class="button-group mt-3">
                        <form method="POST" action="{{ route('guest.account.register.submit') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control form-control-sm @error('name') is-invalid @enderror"
                                    id="name" placeholder="Name" name="name" value="{{ old('name') }}"
                                    required autocomplete="current-password">
                                <label for="name">{{ _('Name') }}</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email"
                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus placeholder="Email Address">
                                <label for="email">{{ __('Email Address') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password"
                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                    id="password" name="password" autocomplete="new-password" required
                                    autocomplete="password" autofocus placeholder="Password">
                                <label for="password">{{ __('Password') }}</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating">
                                <input type="password"
                                    class="form-control form-control-sm @error('password-confirm') is-invalid @enderror"
                                    id="password-confirm" name="password_confirmation" autocomplete="new-password"
                                    required autocomplete="password-confirm" autofocus placeholder="Confirm Password">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <input id="type" type="hidden"
                                class="form-control @error('type') is-invalid @enderror" name="type" value="guest"
                                required autocomplete="type" autofocus>

                            <input id="status" type="hidden"
                                class="form-control @error('status') is-invalid @enderror" name="status"
                                value="Activate" required autocomplete="status" autofocus>

                            <div>
                                <button type="submit" class="custom-button">
                                    {{ __('Sign In') }}
                                </button>

                                <a class="text-primary" href="" data-bs-dismiss="modal">
                                    {{ __('Back') }}
                                </a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
