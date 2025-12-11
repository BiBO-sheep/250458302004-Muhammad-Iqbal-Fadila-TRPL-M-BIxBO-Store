<!-- footer -->
<footer id="footer" class="bg-light pt-5 pb-4 mt-5 border-top border-2">
    <div class="container">
        <div class="row">
            <!-- Brand Column -->
            <div class="col-lg-4 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <a class="logo d-flex align-items-center text-decoration-none" href="{{ url('/') }}">
                        <span class="h3 mb-0 fw-bold text-dark">BIxBO Store</span>
                    </a>
                </div>
                <p class="text-secondary mb-2">
                    Where brands meets happiness.
                </p>
                <p class="text-secondary">
                    Customer smile is our first priority.
                </p>
            </div>

            <!-- About Us Column -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="fw-bold mb-3 text-uppercase small text-dark">About Us</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">About QuickCart</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Career</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Sponsors</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Campaigns</a></li>
                </ul>
            </div>

            <!-- Stores Column -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="fw-bold mb-3 text-uppercase small text-dark">Stores</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Nick's Tshirt</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Vlads Sports</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">IQ 360</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Decor Plus+</a></li>
                </ul>
            </div>

            <!-- Important Links Column -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="fw-bold mb-3 text-uppercase small text-dark">Important</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Privacy</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Cookie Policy</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Terms & Conditions</a></li>
                    <li class="mb-2"><a href="#!" class="text-decoration-none text-secondary small">Refund Policy</a></li>
                </ul>
            </div>

            <!-- Empty column for spacing -->
            <div class="col-lg-2"></div>
        </div>

        <!-- Footer Bottom -->
        <div class="row mt-4 pt-3 border-top">
            <div class="col-12 text-center">
                <p class="mb-0 text-secondary small">
                    &copy; {{ date('Y') }} QuickCart. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    #footer {
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
    }

    #footer a {
        transition: all 0.3s ease;
    }

    #footer a:hover {
        color: #000 !important;
        transform: translateX(3px);
    }

    .logo {
        font-family: 'Arial', sans-serif;
        letter-spacing: -0.5px;
    }
</style>
