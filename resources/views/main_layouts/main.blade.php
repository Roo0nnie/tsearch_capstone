<div class="mainWrapper" id="mainWrapper">
    <div class="left-container item bg-maroon">
        @include('main_layouts.filters') <!-- Include the filters here -->
    </div>

    <div class="main-container item bg-white main-content">
        <h1>Discover Knowledge!</h1>
        @include('main_layouts.modal')
        @include('main_layouts.search', ['imrads' => $imrads])

        @if ($noResults)
            <p class="text-center">
                No file results found for
                <span class="badge text-bg-danger">{{ $query }}</span>
                @if ($query != $querySuggestions)
                    , you can use the suggested word(s) below:
                @endif
            </p>
        @else
            @include('main_layouts.result', [
                'imrads' => $imrads,
            ])
        @endif

    </div>
    <div class="right-container ">



        <div class="right-item bg-maroon">
            @include('main_layouts.main_rightside')
        </div>

        <div class="right-item bg-maroon">
            @include('main_layouts.main_announcement', [
                'announcements' => $announcements,
                'noAnnouncements' => $noAnnouncements,
            ])
        </div>
    </div>
    <script>
        function abstract(elementId, maxLength) {
            const element = document.querySelector(`#${elementId}`);

            if (element) {
                const text = element.textContent;
                if (text.length > maxLength) {
                    element.textContent = text.substring(0, maxLength) + "...";
                }
            }
        }

        abstract("abstract", 500);
    </script>

</div>
