<div class="mainWrapper" id="mainWrapper">
    <div class="left-container">
        <div class="left-item bg-white">
            @include('main_layouts.filters')
        </div>
    </div>

    <div class="main-container">
        <div class="mid-item bg-white main-content">
            @include('main_layouts.search', ['imrads' => $imrads])

            @if ($noResults)
                <div class="d-flex justify-content-center align-items-center flex-col">
                    <div class="title thesis-title roboto-bold my-2">No result based on search term.</div>
                </div>
            @else
                @include('main_layouts.result', ['imrads' => $imrads])
            @endif
        </div>
    </div>

    <div class="right-container">
        <div class="right-item bg-white">
            @include('main_layouts.main_rightside')
        </div>

        <div class="right-item bg-white">
            @include('main_layouts.main_announcement')
        </div>
    </div>
</div>
