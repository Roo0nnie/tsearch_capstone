<div class=" p-3" id="">
    <div class="text-center text-maroon mb-4 roboto-bold" style="font-size: 17px;">All Files</div>

    @php
        $url = route('guest.filter');

        if (Auth::guard('guest_account')->check()) {
            $url = route('guest.account.home.filter');
        }
    @endphp

    <form action="{{ $url }}" method="GET">
        @csrf
        <div class="">

            <input type="hidden" value="true" name="filter">

            <div class="form-group mb-4 mt-2">
                <div class="mt-2">
                    <div>
                        <div>
                            <input type="checkbox" id="category1" name="category[]" value="Accountancy"
                                @if (in_array('Accountancy', request('category', []))) checked @endif>
                            <label for="category1" class="text-maroon">Accountancy
                                ({{ $imradList->where('category', 'Accountancy')->count() ?? 0 }})</label>
                        </div>
                        <div>
                            <input type="checkbox" id="category2" name="category[]" value="Technology"
                                @if (in_array('Technology', request('category', []))) checked @endif>
                            <label for="category2" class="text-maroon">Technology
                                ({{ $imradList->where('category', 'Technology')->count() ?? 0 }})</label>
                        </div>
                        <div>
                            <input type="checkbox" id="category3" name="category[]" value="Midwifery"
                                @if (in_array('Midwifery', request('category', []))) checked @endif>
                            <label for="category3" class="text-maroon">Midwifery
                                ({{ $imradList->where('category', 'Midwifery')->count() ?? 0 }})</label>
                        </div>
                        <div>
                            <input type="checkbox" id="category4" name="category[]" value="Engineering"
                                @if (in_array('Engineering', request('category', []))) checked @endif>
                            <label for="category4" class="text-maroon">Engineering
                                ({{ $imradList->where('category', 'Engineering')->count() ?? 0 }})</label>
                        </div>
                        <div>
                            <input type="checkbox" id="category5" name="category[]" value="Architecture"
                                @if (in_array('Architecture', request('category', []))) checked @endif>
                            <label for="category5" class="text-maroon">Architecture
                                ({{ $imradList->where('category', 'Architecture')->count() ?? 0 }})</label>
                        </div>
                        <div>
                            <input type="checkbox" id="category6" name="category[]" value="Other"
                                @if (in_array('Other', request('category', []))) checked @endif>
                            <label for="category6" class="text-maroon">Other
                                ({{ $imradList->where('category', 'Other')->count() ?? 0 }})</label>
                        </div>
                    </div>

                </div>
            </div>


        </div>

        <!-- Search Button -->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-filter w-50">Apply Filters</button>
            <button type="button" class="btn btn-clear w-50 ms-2" onclick="clearAllFilters()">Clear
                All</button>
        </div>
    </form>
</div>

<script>
    function clearAllFilters() {
        // Uncheck all checkboxes
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        // Reset all select (dropdown) elements
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.selectedIndex = 0; // Reset to the first option
        });

        // Clear all text inputs (e.g., for search, author, year, etc.)
        const textInputs = document.querySelectorAll('input[type="text"], input[type="number"]');
        textInputs.forEach(input => {
            input.value = ''; // Clear the text
        });
    }
</script>
