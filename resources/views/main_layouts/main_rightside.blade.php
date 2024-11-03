<div class="announcement-box p-3 text-white">
    <div class="m-2 d-flex justify-content-center align-items-center flex-column">
        <div class="smallContainer">
            <h5 class="text-white text-center fw-bold mb-4" style="font-size: 17px;">Ask-a-Librarian</h5>
            <!-- Buttons Section -->
            <div class="button-group d-flex flex-column align-items-center">
                <!-- Button 1: Messenger -->
                <a href="https://m.me/librarian-profile" target="_blank" class="btn btn-ask mb-4 mt-2 w-75">Contact via Messenger</a>
                <!-- Button 2: Email Modal -->
                <button type="button" class="btn btn-ask mb-4  w-75" data-bs-toggle="modal" data-bs-target="#emailModal">
                    Send Email
                </button>
               
                <!-- Button 4: FAQs -->
                <a href="/faq" class="btn btn-ask mb-4 w-75">FAQs</a>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="emailModalLabel">Send an email to the Librarian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="user-email " class="form-label text-dark">Your Email</label>
                        <input type="email" class="form-control" id="user-email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="form-label text-dark">Message</label>
                        <textarea class="form-control" id="message-text" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary text-dark">Send Email</button>
                </form>
            </div>
        </div>
    </div>
</div>
