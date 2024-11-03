@extends('layouts.app')

@section('header')
    @include('header')
@endsection
@section('nav')
    @include('nav')
@endsection

@section('content')
    <div class="mainWrapper" id="mainWrapper">
        <div class="left-container item bg-maroon">
            @include(
                'main_layouts.main_announcement',
                ['announcements' => $announcements],
                ['noAnnouncements' => $noAnnouncements]
            )
        </div>

        <div class="main-container item bg-white main-content">
            <h1>My Library</h1>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">Search</button>
                </div>
            </div>
            <div>
                @forelse ($savefiles as $savefile)
                    <ul>
                        <li>
                            {{ $savefile->imrad->title }}
                            {{ $savefile->imrad->author }}
                            {{ $savefile->imrad->department }}

                            <form action="{{ route('guest.account.home.unsave.imrad', ['imrad' => $savefile->imrad->id]) }}"
                                method="post" class="save-imrad-form" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Unsave</button>
                            </form>
                        </li>
                    </ul>
                @empty
                    <p>No saved files!</p>
                @endforelse
            </div>


        </div>

        <div class="right-container item bg-maroon">
            @include('main_layouts.main_rightside')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            saveImradForms();
        });


        function saveImradForms() {
            document.querySelectorAll('.save-imrad-form').forEach(form => {
                form.addEventListener('submit', function(event) {

                    var formData = new FormData(this);

                    fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.querySelector('input[name="_token"]')
                                    .value,
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'File Unsaved',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'info',
                                    title: 'Cannot delete this file',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        })
                        .catch(error => {

                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: 'Cannot delete this file',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                });
            });
        }
    </script>
@endsection
@section('footer')
    @include('footer')
@endsection
