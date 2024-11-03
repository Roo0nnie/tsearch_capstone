<!-- Sidebar Left -->
<!-- <div class="announcement-box p-3 text-white">
    <div class="m-2 d-flex justify-content-center align-items-center flex-col">
        <h5 class="roboto-bold mb-3">ANNOUNCEMENT</h5>
        <div class="smallContainer bg-white">

            @if ($noAnnouncements)
                <div class="article-list">
                    <div class="article mb-3 p-3 border">
                        <p>No Announcement yet</p>
                    </div>
                </div>
            @else
                @foreach ($announcements as $announcement)
                    @if (Auth::guard('faculty')->check())
                        @if (in_array('Faculty', explode(',', $announcement->distributed_to)) || $announcement->distributed_to === 'All')
                            @if (request()->path() === "faculty/announcement/{$announcement->id}")
                            @else
                                <div class="article-list">
                                    <div class="article mb-3 p-3 border">
                                        <a
                                            href="{{ route('faculty.view.announcement', ['announcement' => $announcement->id]) }}">
                                            <p class="abstract">{{ $announcement->title }}</p>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @elseif (Auth::guard('user')->check())
                        @if (in_array('Student', explode(',', $announcement->distributed_to)) || $announcement->distributed_to === 'All')
                            @if (request()->path() === "home/announcement/{$announcement->id}")
                            @else
                                <div class="article-list">
                                    <div class="article mb-3 p-3 border">
                                        <a
                                            href="{{ route('home.view.announcement', ['announcement' => $announcement->id]) }}">
                                            <p class="abstract">{{ $announcement->title }}</p>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @else
                        @if (in_array('Guest', explode(',', $announcement->distributed_to)) || $announcement->distributed_to === 'All')
                            @if (request()->path() === "guest/announcement/{$announcement->id}" ||
                                    request()->path() === "guest/account/announcement/{$announcement->id}")
                            @else
                                <div class="article-list">
                                    <div class="article mb-3 p-3 border">
                                        <a
                                            href="{{ Auth::guard('guest_account')->check() ? route('guest.account.view.announcement', ['announcement' => $announcement->id]) : route('guest.view.announcement', ['announcement' => $announcement->id]) }}">
                                            <p class="abstract">{{ $announcement->title }}</p>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif

        </div>
    </div>
</div> -->
<div class="announcement-box p-3 text-white">
    <div class="m-2 d-flex justify-content-center align-items-center flex-col">
        <h5 class="roboto-bold mb-3">ANNOUNCEMENT</h5>
        
            <!-- Announcement Icon/Image -->
            <i class="fa-solid fa-bullhorn fa-7x mb-3"></i> <!-- Added fa-2x class -->
            <p class="text-center mb-3">Stay updated with the latest announcements!</p>
            <!-- See Announcements Button -->
            <a href="{{ route('announcements') }}"  class="btn btn-primary">See Announcements</a>
            
        
    </div>
</div>

