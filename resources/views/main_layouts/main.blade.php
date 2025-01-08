<div class="mainWrapper" id="mainWrapper">
    <div class="left-container">
        <div class="left-item bg-white mb-3">
            @include('main_layouts.fileList')
        </div>
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


<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    })

    document.addEventListener('keydown', function(e) {
        if (e.key === 'PrintScreen') {
            navigator.clipboard.writeText('Screenshots are disabled.');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "F12") {
            e.preventDefault();
        }
        if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) || (e.ctrlKey && e.key === 'U')) {
            e.preventDefault();
        }
    });
</script>
