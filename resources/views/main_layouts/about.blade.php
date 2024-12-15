@extends('layouts.app')

@section('header')
    @include('header')
@endsection
@section('nav')
    @include('nav')
@endsection

@section('content')
    <div class="mainWrapper" id="mainWrapper">
        <div class="left-container">
            <div class="left-item bg-white">
                @include('main_layouts.main_announcement')
            </div>
        </div>

        <div class="main-container item bg-white main-content p-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="title thesis-title roboto-bold my-2">About T-SEARCH</div>
            </div>
            <div class="content-section">
                <p class="mt-2">
                    Our Thesis Management System is designed to help students access and explore academic research with
                    ease. The system allows users to search for thesis documents based on their interests, view detailed
                    information, and download them for further study. With a simple and user-friendly interface, students
                    can navigate through a vast collection of academic work, making research more accessible and organized.
                </p>
                <br>
                <p>
                    To enhance the experience, students can rate theses based on how helpful or relevant they find them,
                    save their favorite documents, and add them to their personal library for quick access later. The system
                    also provides automatic citations in various formats, making it easier for students to reference
                    documents in their own work. By combining these features, our system ensures students have the tools
                    they need to explore, evaluate, and use academic research effectively.
                </p>
            </div>
            <div class="features-section mt-4">
                <h3 class="roboto-bold">Key Features</h3>
                <ul class="features-list mt-2">
                    <li><i class="bi bi-search"></i> Easy-to-use search and filtering options</li>
                    <li><i class="bi bi-bookmark"></i> Save and manage your personal library</li>
                    <li><i class="bi bi-star"></i> Rate and review theses</li>
                    <li><i class="bi bi-clipboard-check"></i> Automatic citations in various formats</li>
                </ul>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="https://sorsu.edu.ph/about-sorsogon-state-university/" target="_blank"
                    class="btn text-maroon">Learn more about SSU <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Right container for additional content like announcements -->
        <div class="right-container">
            <!-- Include right sidebar content -->
            <div class="right-item bg-white">
                @include('main_layouts.main_rightside') <!-- Include rightside section -->
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 768px) {
            .mainWrapper {
                grid-template-columns: 1fr;
                /* Stack all items in one column */
                grid-template-rows: auto auto auto;
                /* Allow rows to adjust based on content */
            }

            .left-container {
                order: 3;
                /* Left container comes first */
            }

            .main-container {
                order: 1;
                /* Main content comes second */
            }

            .right-container {
                order: 2;
                /* Right container comes last */
                grid-template-columns: 1fr;
                /* Stack everything into a single column */
            }

            .left-item,
            .mid-item {
                width: 100%;
                /* Make sure both items take the full width */
            }
        }
    </style>
@endsection
@section('footer')
    @include('footer')
@endsection
