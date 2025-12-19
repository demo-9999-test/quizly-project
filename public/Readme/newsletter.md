The News Letter Functionality Already Available in Dashboard 
Just Copy And Paste Below Code And Your NewsLetter Will be Working
Below Code is a Demo Css, Update Css According to your Design

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
