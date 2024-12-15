<div class="toggle-button d-block d-md-none mb-3 mt-3 text-center"> <!-- Toggle Button for small screens -->
    <button type="button" class="btn btn-toggle w-75" onclick="toggleFilters()">Show Filters</button>
</div>

<div class=" p-3" id="filterContainer">
    <div class="text-center text-maroon mb-4 roboto-bold" style="font-size: 17px;">Search Filters</div>
    <!-- Increased size for the main title -->

    @php
        $url = route('guest.filter');

        if (Auth::guard('guest_account')->check()) {
            $url = route('guest.account.home.filter');
        }
    @endphp

    <form action="{{ $url }}" method="GET">
        @csrf
        <div class="filter-container">

            <input type="hidden" value="true" name="filter">
            <!-- Sort By Dropdown -->
            <div class="form-group mb-4 mt-2">
                <label for="sortBy" class="text-maroon fw-bold">Sort By</label>
                <select class="form-control" id="sortBy" name="sort_by">
                    <option value="rate" @if (request('sort_by') == 'rate') selected @endif>Rate</option>
                    <option value="year" @if (request('sort_by') == 'year') selected @endif>Year</option>
                </select>
            </div>

            <hr>

            <!-- Collapsible Author Section -->
            <div class="form-group mb-4 mt-2">
                <button class="btn btn-link text-maroon" type="button" data-bs-toggle="collapse" href="#authorCollapse"
                    role="button" aria-expanded="false" aria-controls="authorCollapse">
                    Author
                </button>
                <div class="collapse" id="authorCollapse">
                    <div class="mt-2">
                        @foreach ($authorList as $author)
                            <div>
                                <input type="checkbox" id="author{{ $loop->index }}" name="author[]"
                                    value="{{ $author }}" @if (in_array($author, request('author', []))) checked @endif>
                                <label for="author{{ $loop->index }}" class="text-maroon">{{ $author }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible Adviser Section -->
            <div class="form-group mb-4 mt-2">
                <button class="btn btn-link text-maroon" type="button" data-bs-toggle="collapse"
                    href="#adviserCollapse" role="button" aria-expanded="false" aria-controls="adviserCollapse">
                    Adviser
                </button>
                <div class="collapse" id="adviserCollapse">
                    <div class="mt-2">
                        @foreach ($adviserList as $adviser)
                            <div>
                                <input type="checkbox" id="adviser{{ $loop->index }}" name="adviser[]"
                                    value="{{ $adviser }}" @if (in_array($adviser, request('adviser', []))) checked @endif>
                                <label for="adviser{{ $loop->index }}" class="text-maroon">{{ $adviser }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible Year of Submission Section -->
            <div class="form-group mb-4 mt-2">
                <button class="btn btn-link text-maroon" type="button" data-bs-toggle="collapse" href="#yearCollapse"
                    role="button" aria-expanded="false" aria-controls="yearCollapse">
                    Year
                </button>
                <div class="collapse" id="yearCollapse">
                    <div class="mt-2">
                        @foreach ($yearList as $year)
                            <div>
                                <input type="checkbox" id="year{{ $loop->index }}" name="year[]"
                                    value="{{ $year }}" @if (in_array($year, request('year', []))) checked @endif>
                                <label for="year{{ $loop->index }}" class="text-maroon">{{ $year }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group mb-4 mt-2">
                <button class="btn btn-link text-maroon" data-bs-toggle="collapse" href="#categoryCollapse"
                    role="button" type="button" aria-expanded="false" aria-controls="departmentCollapse">
                    Category
                </button>
                <div class="collapse" id="categoryCollapse">
                    <div class="mt-2">
                        @foreach ($categories as $category)
                            <div>
                                <input type="checkbox" id="category{{ $loop->index }}" name="category[]"
                                    value="{{ $category }}" @if (in_array($category, request('category', []))) checked @endif>
                                <label for="category{{ $loop->index }}"
                                    class="text-maroon">{{ $category }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible Department Section -->
            <div class="form-group mb-4 mt-2">
                <button class="btn btn-link text-maroon" data-bs-toggle="collapse" href="#departmentCollapse"
                    role="button" type="button" aria-expanded="false" aria-controls="departmentCollapse">
                    Department
                </button>
                <div class="collapse" id="departmentCollapse">
                    <div class="mt-2">
                        @foreach ($departmentList as $department)
                            <div>
                                <input type="checkbox" id="department{{ $loop->index }}" name="department[]"
                                    value="{{ $department }}" @if (in_array($department, request('department', []))) checked @endif>
                                <label for="department{{ $loop->index }}"
                                    class="text-maroon">{{ $department }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible SDG Topic Section -->
            <div class="form-group mb-4 mt-2">
                <button class="btn btn-link text-maroon" data-bs-toggle="collapse" href="#sdgCollapse"
                    role="button" type="button" aria-expanded="false" aria-controls="sdgCollapse">
                    Sustainable Development Goals
                </button>
                <div class="collapse" id="sdgCollapse">
                    <div class="mt-2">
                        @php
                            $SDGMapping = [
                                1 => 'No Poverty',
                                2 => 'Zero Hunger',
                                3 => 'Good Health and Well-being',
                                4 => 'Quality Education',
                                5 => 'Gender Equality',
                                6 => 'Clean Water and Sanitation',
                                7 => 'Affordable and Clean Energy',
                                8 => 'Decent Work and Economic Growth',
                                9 => 'Industry, Innovation, and Infrastructure',
                                10 => 'Reduced Inequalities',
                                11 => 'Sustainable Cities and Communities',
                                12 => 'Responsible Consumption and Production',
                                13 => 'Climate Action',
                                14 => 'Life Below Water',
                                15 => 'Life on Land',
                                16 => 'Peace, Justice, and Strong Institutions',
                                17 => 'Partnerships for the Goals',
                            ];
                        @endphp

                        @foreach ($SDGMapping as $sdgNumber => $name)
                            <div>
                                <input type="checkbox" id="SDG{{ $sdgNumber }}" name="SDG[]"
                                    value="{{ $sdgNumber }}" @if (in_array($sdgNumber, request('SDG', []))) checked @endif>
                                <label for="SDG{{ $sdgNumber }}" class="text-maroon">{{ $sdgNumber }}.
                                    {{ $name }}</label>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <hr>


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

        // Optionally, submit the form if you want to trigger filter reset immediately
        // document.getElementById('filterForm').submit();
    }

    function toggleFilters() {
        const filterContainer = document.getElementById('filterContainer');
        filterContainer.classList.toggle('show'); // Toggle the show class
    }
</script>
