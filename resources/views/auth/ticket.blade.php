@extends('master')
@section('content')
{{-- <main id="main" class="main">

    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-sm-4  ">
                <h1 class="pb-4">Create Ticket</h1>
                <form action="/api/user/send_message/{{$user->user_id}}" method="POST">
@csrf
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" value={{ $user->email }} id="email" aria-describedby="emailHelp">
</div>

<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">phone</label>
    <input type="text" name="phone" class="form-control" value={{ $user->phone }} id="exampleInputPassword1">
</div>

<div class="mb-3">
    <label for="exampleInputEma1" class="form-label">Product Name</label>
    <input type="text" name="softwareName" class="form-control" aria-describedby="emailHelp">
</div>

<div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Describe the Problem</label>
    <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>


<button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>
</div>
</div>
</div>
</main> --}}
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create Ticket</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/api/user/dashboard" class="active">Dashboard</a></li>
                <li class="breadcrumb-item ">Support & Ticket</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section contact">

        <div class="row gy-4">

            <div class="col-xl-6">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="info-box card">
                            <i class="bi bi-geo-alt"></i>
                            <h3>Address</h3>
                            <p>A108 Adam Street,<br>New York, NY 535022</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="info-box card">
                            <i class="bi bi-telephone"></i>
                            <h3>Call Us</h3>
                            <p>+1 5589 55488 55<br>+1 6678 254445 41</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="info-box card">
                            <i class="bi bi-envelope"></i>
                            <h3>Email Us</h3>
                            <p>info@example.com<br>contact@example.com</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="info-box card">
                            <i class="bi bi-clock"></i>
                            <h3>Open Hours</h3>
                            <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-6">
                <div class="card p-4">
                    <form action="/api/user/send_message/{{$user->user_id}}" method="POST" class="php-email-form">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" value={{ $user->email }} class="form-control" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-6 ">
                                <input type="phone" class="form-control" value={{ $user->phone }} placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="softwareName" placeholder="Subject" required>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">
                                    <span class="dynamic-message">Your message has been sent. Thank you!</span>
                                </div>

                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

    </section>

</main>
@endsection
