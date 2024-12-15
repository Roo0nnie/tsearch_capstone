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
                <div class="title thesis-title roboto-bold my-2">Frequently Asked Questions</div>
            </div>

            <div class="faq-section mt-4">
                <div class="accordion faq-accordion" id="faqAccordion">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                                What is TSearch?
                            </button>
                        </h2>
                        <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                TSearch is a Thesis Management System designed to streamline the process of submitting,
                                reviewing, and managing theses for students, faculty, and administrators.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                Who can use TSearch?
                            </button>
                        </h2>
                        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                TSearch is accessible to students for thesis submission, faculty for thesis review and
                                evaluation, and administrators for managing the system.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                How can I login to TSearch?
                            </button>
                        </h2>
                        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can login using your university email.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="faqHeading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                                Is there a file size limit for thesis submissions?
                            </button>
                        </h2>
                        <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No, but the size affect the uploading process. If your file exceeds the limit, consider
                                compressing it and make sure it is in the correct format.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="faqHeading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqCollapse6" aria-expanded="false" aria-controls="faqCollapse6">
                                How can we provide feedback on a system?
                            </button>
                        </h2>
                        <div id="faqCollapse6" class="accordion-collapse collapse" aria-labelledby="faqHeading6"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can provide feedback on the system through the "Send Email" section because it will be
                                sent directly to the system administrator.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 7 -->
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="faqHeading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqCollapse7" aria-expanded="false" aria-controls="faqCollapse7">
                                Can I access TSearch on mobile devices?
                            </button>
                        </h2>
                        <div id="faqCollapse7" class="accordion-collapse collapse" aria-labelledby="faqHeading7"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, TSearch is mobile-responsive and can be accessed on smartphones, tablets, and desktops
                                for convenience.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 8 -->
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="faqHeading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqCollapse8" aria-expanded="false" aria-controls="faqCollapse8">
                                What should I do if I encounter technical issues?
                            </button>
                        </h2>
                        <div id="faqCollapse8" class="accordion-collapse collapse" aria-labelledby="faqHeading8"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                If you encounter technical issues, you can contact the TSearch support team through the
                                "Help" section for assistance.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right container for additional content like announcements -->
        <div class="right-container">
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
