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
            @include('main_layouts.main_announcement')
        </div>

        <div class="main-container item bg-white main-content">
            <h1>Announcement</h1>

            <!-- Article Content -->
            <div class="article-list">
                <div class="article mb-3 p-3 border text-center">
                    <button class="btn btn-secondary mb-2">{{ $announcement->title }}</button>
                    <p class="mb-2">{{ $announcement->content }}</p>
                    @if ($announcement->attachment != null)
                        <img src="{{ Storage::url($announcement->attachment) }}" alt="Announcement Attachment">
                    @endif
                </div>
            </div>
        </div>
        <div class="right-container item bg-maroon">
            @include('main_layouts.main_rightside')
        </div>
    </div>
@endsection
@section('footer')
    @include('footer')
@endsection
