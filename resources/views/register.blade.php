@extends('template.main')

@section('main_content')

<!-- Contact Section -->
<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Contact Us</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">

                    <div class="col-md-6">

                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                        </div>

                    </div>

                    <div class="col-md-12">
                        <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                    </div>

                    <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>

                        <button type="submit">Send Message</button>
                    </div>

                </div>
            </form>
        </div>

    </div>

</section><!-- /Contact Section -->
@endsection