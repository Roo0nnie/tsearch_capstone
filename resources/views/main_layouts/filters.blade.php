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
        <div class="filter-container p-2">

            <input type="hidden" value="true" name="filter">
            
            <!-- Sort By Dropdown -->
            <div class="form-group mb-3 mt-1">
                <label for="sortBy" class="text-maroon fw-bold mb-2 d-block text-xs font-bold uppercase tracking-wider">
                    <i class="fas fa-sort-amount-down me-2"></i>Sort By
                </label>
                <select class="form-control" id="sortBy" name="sort_by">
                    <option value="rate" @if (request('sort_by') == 'rate') selected @endif>Rate</option>
                    <option value="year" @if (request('sort_by') == 'year') selected @endif>Year</option>
                </select>
            </div>

            <hr>

            <!-- Collapsible Author Section -->
            <div class="form-group mb-3 mt-1">
                <button class="w-100 d-flex justify-content-between align-items-center py-2 px-1 border-0 bg-transparent text-maroon fw-semibold text-sm outline-none text-start" type="button" data-ui-toggle="collapse" href="#authorCollapse"
                    role="button" aria-expanded="false" aria-controls="authorCollapse">
                    <span><i class="fas fa-user-edit me-2"></i>Author</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div class="collapse" id="authorCollapse">
                    <div class="mt-2 ps-2">
                        @foreach ($authorList as $author)
                            <div class="form-check">
                                <input type="checkbox" id="author{{ $loop->index }}" name="author[]" class="form-check-input"
                                    value="{{ $author }}" @if (in_array($author, request('author', []))) checked @endif>
                                <label for="author{{ $loop->index }}" class="form-check-label text-secondary text-xs">{{ $author }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible Adviser Section -->
            <div class="form-group mb-3 mt-1">
                <button class="w-100 d-flex justify-content-between align-items-center py-2 px-1 border-0 bg-transparent text-maroon fw-semibold text-sm outline-none text-start" type="button" data-ui-toggle="collapse"
                    href="#adviserCollapse" role="button" aria-expanded="false" aria-controls="adviserCollapse">
                    <span><i class="fas fa-user-graduate me-2"></i>Adviser</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div class="collapse" id="adviserCollapse">
                    <div class="mt-2 ps-2">
                        @foreach ($adviserList as $adviser)
                            <div class="form-check">
                                <input type="checkbox" id="adviser{{ $loop->index }}" name="adviser[]" class="form-check-input"
                                    value="{{ $adviser }}" @if (in_array($adviser, request('adviser', []))) checked @endif>
                                <label for="adviser{{ $loop->index }}" class="form-check-label text-secondary text-xs">{{ $adviser }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible Year of Submission Section -->
            <div class="form-group mb-3 mt-1">
                <button class="w-100 d-flex justify-content-between align-items-center py-2 px-1 border-0 bg-transparent text-maroon fw-semibold text-sm outline-none text-start" type="button" data-ui-toggle="collapse" href="#yearCollapse"
                    role="button" aria-expanded="false" aria-controls="yearCollapse">
                    <span><i class="fas fa-calendar-alt me-2"></i>Year</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div class="collapse" id="yearCollapse">
                    <div class="mt-2 ps-2">
                        @foreach ($yearList as $year)
                            <div class="form-check">
                                <input type="checkbox" id="year{{ $loop->index }}" name="year[]" class="form-check-input"
                                    value="{{ $year }}" @if (in_array($year, request('year', []))) checked @endif>
                                <label for="year{{ $loop->index }}" class="form-check-label text-secondary text-xs">{{ $year }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible Category Section -->
            <div class="form-group mb-3 mt-1">
                <button class="w-100 d-flex justify-content-between align-items-center py-2 px-1 border-0 bg-transparent text-maroon fw-semibold text-sm outline-none text-start" data-ui-toggle="collapse" href="#categoryCollapse"
                    role="button" type="button" aria-expanded="false" aria-controls="categoryCollapse">
                    <span><i class="fas fa-tags me-2"></i>Category</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div class="collapse" id="categoryCollapse">
                    <div class="mt-2 ps-2">
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input type="checkbox" id="category{{ $loop->index }}" name="category[]" class="form-check-input"
                                    value="{{ $category }}" @if (in_array($category, request('category', []))) checked @endif>
                                <label for="category{{ $loop->index }}"
                                    class="form-check-label text-secondary text-xs">{{ $category }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible Department Section -->
            <div class="form-group mb-3 mt-1">
                <button class="w-100 d-flex justify-content-between align-items-center py-2 px-1 border-0 bg-transparent text-maroon fw-semibold text-sm outline-none text-start" data-ui-toggle="collapse" href="#departmentCollapse"
                    role="button" type="button" aria-expanded="false" aria-controls="departmentCollapse">
                    <span><i class="fas fa-university me-2"></i>Department</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div class="collapse" id="departmentCollapse">
                    <div class="mt-2 ps-2">
                        @foreach ($departmentList as $department)
                            <div class="form-check">
                                <input type="checkbox" id="department{{ $loop->index }}" name="department[]" class="form-check-input"
                                    value="{{ $department }}" @if (in_array($department, request('department', []))) checked @endif>
                                <label for="department{{ $loop->index }}"
                                    class="form-check-label text-secondary text-xs">{{ $department }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <!-- Collapsible SDG Topic Section -->
            <div class="form-group mb-3 mt-1">
                <button class="w-100 d-flex justify-content-between align-items-center py-2 px-1 border-0 bg-transparent text-maroon fw-semibold text-sm outline-none text-start" data-ui-toggle="collapse" href="#sdgCollapse"
                    role="button" type="button" aria-expanded="false" aria-controls="sdgCollapse">
                    <span><i class="fas fa-globe me-2"></i>Sustainable Development Goals</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div class="collapse" id="sdgCollapse">
                    <div class="mt-2 ps-2">
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
                            <div class="form-check">
                                <input type="checkbox" id="SDG{{ $sdgNumber }}" name="SDG[]" class="form-check-input"
                                    value="{{ $sdgNumber }}" @if (in_array($sdgNumber, request('SDG', []))) checked @endif>
                                <label for="SDG{{ $sdgNumber }}" class="form-check-label text-secondary text-xs">{{ $sdgNumber }}.
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
            <button type="button" class="btn btn-clear w-50 ms-2" onclick="clearAllFilters()">Clear All</button>
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
