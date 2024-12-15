<div class="lib-box p-3 text-white d-flex justify-content-center align-items-center">
    <div class="m-2 d-flex justify-content-center align-items-center flex-column">
        <div class="smallContainer w-80">
            <h5 class="text-maroon text-center fw-bold mb-4" style="font-size: 17px;">Ask-a-Librarian </h5>

            <!-- Buttons Section with Icons and Dividers -->
            <div class="button-group d-flex flex-column align-items-center ">

                <!-- Button 1: Messenger with Icon -->
                <a href="https://www.facebook.com/messages/t/114298653592013" target="_blank"
                    class="btn btn-ask mb-3 mt-2 w-80 d-flex align-items-center justify-content-center">
                    <i class="fas fa-comment-dots me-2"></i> Ask via Messenger
                </a>

                <hr class="w-75 text-light">

                <!-- Button 2: Email Modal with Icon -->
                <button type="button"
                    class="btn btn-ask mb-3 mt-3 w-80 d-flex align-items-center justify-content-center"
                    data-bs-toggle="modal" data-bs-target="#emailModal">
                    <i class="fas fa-envelope me-2"></i> Send Email
                </button>

                <hr class="w-75 text-light">

                <!-- Button 3: FAQs with Icon -->

                @php
                    $url = route('faq.display');

                    if (Auth::guard('guest_account')->check()) {
                        $url = route('guest.faq.display');
                    }
                @endphp
                <a href="{{ $url }}"
                    class="btn btn-ask mt-3 mb-3 w-80 d-flex align-items-center justify-content-center">
                    <i class="fas fa-question-circle me-2"></i>FAQs
                </a>

                <hr class="w-75 text-light">

                <a href="https://www.facebook.com/messages/t/100059931776599" target="_blank"
                    class="btn btn-ask mb-3 mt-3 w-80 d-flex align-items-center justify-content-center">
                    <i class="fas fa-phone me-2"></i> Help
                </a>

            </div>
        </div>
    </div>
</div>


<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-4 w-100 text-center" id="emailModalLabel"><strong>Send an email to the
                        Librarian</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $url = route('guest.send.email');

                    if (Auth::guard('guest_account')->check()) {
                        $url = route('guest.account.send.email');
                    }
                @endphp

                <form action="{{ $url }}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="user-email" name="email"
                            placeholder="name@sorsu.edu.ph" required>
                        <label for="user-email">Your Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="message-text" name="message" placeholder="Enter your message here..."
                            style="height: 120px;" required></textarea>
                        <label for="message-text">Message</label>
                    </div>


                    <div class="mb-3">
                        <div class="form-group">
                            <label for="admin-email" class="form-label text-dark">Select Admin</label>
                            <select name="admin_email" id="admin-email" class="form-control" required>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->email }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-anno">Send Email</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
