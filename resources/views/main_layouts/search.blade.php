<div class="input-group mb-3">
    @php
        $url = route('guest.page');

        if (Auth::guard('user')->check()) {
            $url = route('home');
        } elseif (Auth::guard('faculty')->check()) {
            $url = route('faculty.home');
        } elseif (Auth::guard('guest_account')->check()) {
            $url = route('guest.account.home');
        }
    @endphp

    <form method="GET" action="{{ $url }}" class="w-100">
        <div class="input-group">
            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
            <input type="text" name="query" class="form-control" value="{{ old('query', $query) }}"
                placeholder="Search...">
            <button type="submit" class="btn btn-search">Search</button>
        </div>
    </form>

    @if (!empty($query) && $query != $querySuggestions)
        @if (Auth::guard('guest_account')->check())
            <div class="d-flex justify-content-center align-items-center flex-col w-100">
                <p class="mt-2">You can click the suggested word:</p>
                <a href="{{ route('guest.account.home', ['query' => $querySuggestions]) }}">
                    <span class="badge mt-2 mb-2 fs-5 btn-anno"> {{ $querySuggestions }}</span>
                </a>
            </div>
        @endif

        @if (!Auth::guard('user')->check() && !Auth::guard('faculty')->check() && !Auth::guard('guest_account')->check())
            <div class="d-flex justify-content-center align-items-center flex-col w-100">
                <p class="mt-2">You can click the suggested word:</p>
                <a href="{{ route('guest.page', ['query' => $querySuggestions]) }}">
                    <span class="badge mt-2 mb-2 fs-5 btn-anno"> {{ $querySuggestions }}</span>
                </a>
            </div>
        @endif
    @endif
</div>
