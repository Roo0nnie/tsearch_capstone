<div class="filter-section p-3">
    <h5 class="text-white text-center fw-bold mb-4" style="font-size: 17px;">Search Filters</h5> <!-- Increased size for the main title -->

    <div class="filter-container">

        <!-- Sort By Dropdown -->
        <div class="form-group mb-4"> <!-- Increased margin bottom -->
            <label for="sortBy" class="text-white fw-bold">Sort By</label> <!-- Bold title -->
            <select class="form-control" id="sortBy">
                <option value="relevance">Relevance</option>
                <option value="date">Date</option>
            </select>
        </div>

        <hr> <!-- Divider -->

        <!-- Author -->
        <div class="form-group mb-4"> <!-- Increased margin bottom -->
            <label class="text-white fw-bold">Author</label> <!-- Bold title -->
            <div>
                <input type="checkbox" id="author1" value="Author 1">
                <label for="author1" class="text-white">Author 1</label>
            </div>
            <div>
                <input type="checkbox" id="author2" value="Author 2">
                <label for="author2" class="text-white">Author 2</label>
            </div>
        </div>

        <hr> <!-- Divider -->

        <!-- Year of Submission -->
        <div class="form-group mb-4"> <!-- Increased margin bottom -->
            <label class="text-white fw-bold">Year of Submission</label> <!-- Bold title -->
            <div>
                <input type="checkbox" id="year2024" value="2024">
                <label for="year2024" class="text-white">2024</label>
            </div>
            <div>
                <input type="checkbox" id="year2023" value="2023">
                <label for="year2023" class="text-white">2023</label>
            </div>
        </div>

        <hr> <!-- Divider -->

        <!-- Department -->
        <div class="form-group mb-4"> <!-- Increased margin bottom -->
            <label class="text-white fw-bold">Department</label> <!-- Bold title -->
            <div>
                <input type="checkbox" id="cs" value="Computer Science">
                <label for="cs" class="text-white">Computer Science</label>
            </div>
            <div>
                <input type="checkbox" id="eng" value="Engineering">
                <label for="eng" class="text-white">Engineering</label>
            </div>
        </div>

        <hr> <!-- Divider -->

        <!-- SDG Topic -->
        <div class="form-group mb-4"> <!-- Increased margin bottom -->
            <label class="text-white fw-bold">Sustainable Development Goals (SDG)</label> <!-- Bold title -->
            <div>
                <input type="checkbox" id="sdg1" value="No Poverty">
                <label for="sdg1" class="text-white">No Poverty</label>
            </div>
            <div>
                <input type="checkbox" id="sdg2" value="Zero Hunger">
                <label for="sdg2" class="text-white">Zero Hunger</label>
            </div>
        </div>

        <hr> <!-- Divider -->

        <!-- Thesis Category -->
        <div class="form-group mb-4"> <!-- Increased margin bottom -->
            <label class="text-white fw-bold">Thesis Category</label> <!-- Bold title -->
            <div>
                <input type="checkbox" id="category1" value="Engineering">
                <label for="category1" class="text-white">Engineering</label>
            </div>
            <div>
                <input type="checkbox" id="category2" value="Business">
                <label for="category2" class="text-white">Business</label>
            </div>
        </div>

        <hr> <!-- Divider -->

        <!-- Adviser -->
        <div class="form-group mb-4"> <!-- Increased margin bottom -->
            <label class="text-white fw-bold">Adviser</label> <!-- Bold title -->
            <div>
                <input type="checkbox" id="adviser1" value="Adviser 1">
                <label for="adviser1" class="text-white">Adviser 1</label>
            </div>
            <div>
                <input type="checkbox" id="adviser2" value="Adviser 2">
                <label for="adviser2" class="text-white">Adviser 2</label>
            </div>
        </div>
    </div>
    <!-- Search Button -->
    <div class="d-flex justify-content-between">
        <!-- Apply Filters Button -->
        <button type="submit" class="btn btn-filter w-50">Apply Filters</button>

        <!-- Clear All Button -->
        <button type="button" class="btn btn-clear w-50 ms-2" onclick="clearAllFilters()">Clear All</button>
    </div>
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
</script>
