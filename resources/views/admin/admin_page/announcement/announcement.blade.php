@extends('layouts.admin')

@section('content')
    <div>
        <div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Announcement</h3>
                    </div>
                </div>

                {{--
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Active Announcements</p>
                                            <h4 class="card-title">
                                                {{ $announcements->filter(fn($announcement) => $announcement->activation == 'Active')->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
                                            <i class="fas fa-luggage-cart"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Inactive Announcement</p>
                                            <h4 class="card-title">
                                                {{ $announcements->filter(fn($announcement) => $announcement->activation == 'Inactive')->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category ">Sample</p>
                                            <h4 class="card-title">

                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Sample</p>
                                            <h4 class="card-title">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                            <i class="far fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Total Announcements</p>
                                            <h4 class="card-title">
                                                <h4 class="card-title">
                                                    {{ count($announcements) }}
                                                </h4>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category ">Sample</p>
                                            <h4 class="card-title">

                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Sample</p>
                                            <h4 class="card-title">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> --}}

                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center pt-2 pb-1 my-2">
                    <div class="ms-md-auto py-2 py-md-0 d-flex flex-column flex-sm-row align-items-center">
                        <div class="mb-2 mb-sm-0">
                            <a href="{{ route('admin.announcement.create') }}" class="btn btn-maroon">Add
                                Announcement</a>
                        </div>
                    </div>
                </div>

                <div class="card table-responsive mt-3">
                    <div class="card-body">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Start</th>
                                    <th scope="col">End</th>
                                    <th scope="col">Distributed</th>
                                    <th scope="col">Time Remaining</th>
                                    <th scope="col">Activation</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($announcements as $announcement)
                                    <tr data-id="{{ $announcement->id }}">
                                        <td>{{ $announcement->id }}</td>
                                        <td>{{ $announcement->title }}</td>
                                        <td>{{ $announcement->content }}</td>
                                        <td id="start">{{ $announcement->start }}</td>
                                        <td id="end">{{ $announcement->end }}</td>
                                        <td>{{ $announcement->distributed_to }}</td>
                                        <td class="stopwatch">00:00:00</td>
                                        <td>{{ $announcement->activation }}</td>
                                        <td>

                                            <div class="btn-group text-sm-center" role="group"
                                                aria-label="Basic mixed styles example">

                                                <a href="{{ route('admin.announcement.edit', ['announcement' => $announcement]) }}"
                                                    class="btn btn-primary">Edit</a>

                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                    id="actionDropdown{{ $announcement->id }}" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">

                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="actionDropdown{{ $announcement->id }}">
                                                    <li><a class="dropdown-item" {{-- {{ route('admin.user.view', ['user' => $user]) }} --}}
                                                            href="">View</a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.announcement.delete', ['announcement' => $announcement]) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">Delete</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        @if ($announcement->activation == 'Active' && !$announcement->manual_stop)
                                                            <form
                                                                action="{{ route('announcement.stop', ['announcement' => $announcement]) }}"
                                                                method="POST" class="stop-form">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">Stop</button>
                                                            </form>
                                                        @elseif ($announcement->manual_stop)
                                                            <form
                                                                action="{{ route('announcement.continue', ['announcement' => $announcement]) }}"
                                                                method="POST" class="continue-form">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="dropdown-item">Continue</button>
                                                            </form>
                                                        @endif

                                                        <div class="status" style="display: none;">
                                                            {{ $announcement->activation }}
                                                        </div>
                                                        <div class="manual_stop" style="display: none;">
                                                            {{ $announcement->manual_stop }}
                                                        </div>
                                                    </li>
                                                </ul>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateStopwatches() {
            const now = new Date();
            document.querySelectorAll('tr[data-id]').forEach((row) => {
                const statusElement = row.querySelector('.status');
                const manualStopElement = row.querySelector('.manual_stop');
                const element = row.querySelector('.stopwatch');

                let status = statusElement.textContent.trim();
                let manualStop = manualStopElement.textContent.trim() === 'false';

                const startTimeString = row.querySelector('#start').textContent.trim();
                const endTimeString = row.querySelector('#end').textContent.trim();
                const startTime = new Date(startTimeString);
                const endTime = new Date(endTimeString);

                if (isNaN(startTime.getTime()) || isNaN(endTime.getTime())) {
                    element.textContent = "Invalid date";
                    return;
                }

                if (status === 'Active' && !manualStop) {
                    // Calculate time remaining
                    let timeRemaining = endTime - now;

                    if (timeRemaining < 0) { // Time's up
                        element.textContent = "Done";
                        // Update the status to inactive in the database
                        fetch(`/admin/announcement/${row.dataset.id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                status: 'Inactive'
                            })
                        }).then(() => {

                            statusElement.textContent = 'Inactive';
                            manualStopElement.textContent = 'false';
                        });
                    } else {
                        const hours = Math.floor(timeRemaining / (1000 * 60 * 60));
                        const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                        const formattedTime =
                            `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
                        element.textContent = formattedTime;
                    }
                } else if (manualStop) {
                    element.textContent = "Stopped";
                } else { // Not started
                    element.textContent = "Not yet started";
                }
            });
        }

        document.querySelectorAll('.stop-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const row = this.closest('tr');
                const announcementId = row.dataset.id;

                fetch(`/admin/announcement/stop/${announcementId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                }).then(() => {

                    location.reload();
                });
            });
        });

        document.querySelectorAll('.continue-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const row = this.closest('tr');
                const announcementId = row.dataset.id;

                fetch(`/admin/announcement/continue/${announcementId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                }).then(() => {

                    location.reload();
                });
            });
        });

        // Start the timer
        const timerInterval = setInterval(updateStopwatches, 1000);
        updateStopwatches();
    </script>
@endsection
