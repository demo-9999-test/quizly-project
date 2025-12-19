<!DOCTYPE html>
<html>
    <head>
        <title>Laravel Newsletter</title>
        <style>
        /* ================================= */
        /*===== subscribe newsletter =====*/
        /* ================================= */
        .newsletter-main-block {
            padding: 60px 0;
            background-color: #887b7b;
        }
        .newsletter-main-block .section-heading {
            font-size: 48px;
            color: #fff;
        }
        .newsletter-main-block .section p {
            color: #fff;
        }
        .newsletter-form {
            box-shadow: 0 8px 50px 0 rgba(5, 25, 44, 0.1);
        }
        .newsletter-main-block .section .section-heading {
            margin-bottom: 30px;
        }

        .newsletter-main-block form {
            display: flex;
        }
        .newsletter-form .form-control {
            width: 100%;
            height: 60px;
            border-radius: 0;
            border-color: transparent;
            line-height: 24px;
            padding: 23px 20px;
            line-height: 24px;
        }
        .newsletter-form .btn-primary {
            width: 200px;
            padding: 16px 0;
            border-radius: 0;
            height: 60px;
            line-height: 24px;
            background-color: #333;
            border: 1px solid #a7a7a7;
        }
        @media (max-width: 992px) {
            .newsletter-form .form-control {
                width: 470px;
            }
            .newsletter-form .btn-danger {
                width: 220px;
                padding: 5px;
            }
        }
        @media (max-width: 767px) {
            .newsletter-main-block .form-control {
                width: 252px;
            }
            .newsletter-main-block .btn-danger {
                width: 130px;
                padding: 5px;
            }
        }
        </style>

    <!-- StyleSheets For Home page -->
    </head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (optional for some Bootstrap 5 usage) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <body>
    <!-- StyleSheets For Home page end -->

    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success">
        <div class="row">
            <div class="col-lg-4">
                <i class="flaticon-check-1"></i>
            </div>
            <div class="col-lg-8">
                {{ session()->get('success') }}
            </div>
        </div>
    </div>
    @endif

    <!-- newsletter -->
    <section id="newsletter" class="newsletter-main-block">
        <div class="container">
            <div class="row">
                <div class="offset-lg-1 col-lg-5">
                    <div class="section">
                        <h3 class="section-heading">
                            {{ __('Update Our Latest Newsletter') }}</h3>
                        <p>{{ __('Subscribe now Automated sending updated news your') }}<br>{{ __('email box') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="newsletter-form vertical-center">
                        <form action="{{ route('subscribe') }}" method="post">
                            @csrf
                            <input type="email" class="form-control" name="email" id="subscribeemail" aria-describedby="subscribe"
                                placeholder="Enter Your Mail">
                            <button type="submit" class="btn pointer-zoom btn-primary" id="">{{ __('Subscribe Now') }}</button>
                        </form>
                        <small id="msg" class="text-white p-2"></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end newsletter -->

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Disable scrolling when tab links are clicked
        const tabLinks = document.querySelectorAll('a[data-bs-toggle="pill"], a[data-bs-toggle="tab"]');
        tabLinks.forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault(); // prevent scroll jump
                const targetSelector = this.getAttribute("href");
                if (targetSelector) {
                    const tabEl = document.querySelector(targetSelector);
                    if (tabEl) {
                        const tab = new bootstrap.Tab(this);
                        tab.show();
                        history.replaceState(null, null, ' '); // remove hash from URL
                    }
                }
            });
        });

        // Restore previous active tab (if saved)
        const activeTab = localStorage.getItem("activeTab");
        if (activeTab) {
            const triggerEl = document.querySelector('a[href="' + activeTab + '"]');
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }

        // Save active tab
        tabLinks.forEach(link => {
            link.addEventListener("shown.bs.tab", function (e) {
                localStorage.setItem("activeTab", e.target.getAttribute("href"));
            });
        });
    });
</script>

    </body>
    </html>
