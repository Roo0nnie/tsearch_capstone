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
            <input type="text" name="query" class="form-control" value="{{ old('query', $query) }}"
                placeholder="Enter your search term">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    @if (!empty($query) && $query != $querySuggestions)
        <p>Suggested word/s:</p>
        @if (Auth::guard('guest_account')->check())
            <a href="{{ route('guest.account.home', ['query' => $querySuggestions]) }}">
                <span class="badge text-bg-primary"> {{ $querySuggestions }}</span>
            </a>
        @endif

        @if (Auth::guard('faculty')->check())
            <a href="{{ route('faculty.home', ['query' => $querySuggestions]) }}">
                <span class="badge text-bg-primary">{{ $querySuggestions }}</span>
            </a>
        @endif

        @if (Auth::guard('user')->check())
            <a href="{{ route('home', ['query' => $querySuggestions]) }}">
                <span class="badge text-bg-primary">{{ $querySuggestions }}</span>
            </a>
        @endif

        @if (!Auth::guard('user')->check() && !Auth::guard('faculty')->check() && !Auth::guard('guest_account')->check())
            <a href="{{ route('guest.page', ['query' => $querySuggestions]) }}">
                <span class="badge text-bg-primary">{{ $querySuggestions }}</span>
            </a>
        @endif
    @endif
</div>
