@extends('master')
<style></style>
@section('content')

<main id="main" class="main mb-5">
    <div class="pagetitle">
        <h1>My Subscriptions</h1>
        <nav class="pt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/api/user/dashboard" class="active">Dashboard</a></li>
                <li class="breadcrumb-item " >Subscriptions</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">


                            <div class="card-body">
                                <h5 class="card-title">Total <span>| Subscriptions</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center bg-primary justify-content-center">
                                        <i class="bi bi-receipt text-light"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ count($subscription) }}</h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title">Paid <span>| Subscriptions</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center bg-success justify-content-center">
                                        <i class="bi bi-cart text-light"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $subscription->where('paymentStatus', 'paid')->count() }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title"> Unpaid<span>| Subscriptions </span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center bg-danger justify-content-center">
                                        <i class="bi bi-journal text-light"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $subscription->where('paymentStatus', 'pending')->count() }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title">Activate <span>| Subscriptions</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center bg-success justify-content-center" style="">
                                        <i class="bi bi-journal-bookmark-fill text-light"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $subscription->where('activationStatus', true)->count() }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid pt-2 ">
        @if(!$subscription)
        <div class="container">

            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>302</h1>
                <h2>User Has no Subscription</h2>
                {{-- <a class="btn" href="index.html">Back to home</a> --}}
                <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">

            </section>

        </div>
        @else

        <div class="card">
            <div class="card-header" style="border: none">
                <div class="card-title">
                    <h5 class="card-label text-dark fw-medium"> Subscription List
                        <span class="d-block text-muted pt-2 font-size-sm"> You can Update and Activate and Cancel Subscription Here</span></h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive ">
                    <table id="example" class="table nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Subs ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Software</th>
                                <th scope="col"> Status</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscription as $sub)
                            <tr class="align-middle">
                                <td class="align-middle"><strong>#{{ $sub->subs_id }}</strong></td>
                                <td class="align-middle">{{ $sub->email }}</td>
                                <td class="align-middle">{{ $sub->phone }}</td>
                                <td class="align-middle">{{ $sub->software }}</td>
                                <td class="align-middle">
                                    @if ($sub->subscriptionStatus === 'active')
                                    <span class="text-light bg-success text-center" style="padding:4px 12px;
                        border-radius:8px;">Active</span>
                                    @else
                                    <span class="text-white bg-danger text-center" style="
                        padding:4px 8px;border-radius:8px;">{{$sub->subscriptionStatus}}</span>
                                    @endif
                                </td>

                                <td class="align-middle"><strong>{{ $sub->expiryDate }}</strong></td>

                                <td class="align-middle"><strong>₹{{ $sub->amount }}</strong></td>

                                <td class="text-center align-middle">
                                    @if ($sub->paymentStatus === 'paid')
                                    <span class="text-light bg-success text-center" style="
                        padding:4px 12px;border-radius:8px;">Paid</span>
                                    @else
                                    <span class="text-light text-center bg-danger" style="
                        padding:4px 8px;border-radius:8px;">Unpaid</span>
                                    @endif
                                </td>
                                <td style="align-items: center;" class="justify-content-center align-middle">
                                    @if ($sub->paymentStatus === 'paid')
                                    <div class="d-flex " style="width: 130px;justify-content:space-evenly;">
                                        <span> @if ($sub->activationStatus)
                                            <a href="/api/user/user-edit-key/{{$sub->subs_id}}" id="" class="m-1 ">
                                                <i class="fas fa-toggle-on" style="color: green;font-size:25px;"></i>
                                            </a>
                                            @else
                                            <a href="/api/user/user-edit-key/{{$sub->subs_id}}" id="" class="m-1 ">
                                                <i class="fas fa-toggle-off" style="color:gray;font-size:25px;"></i>
                                            </a>
                                            @endif
                                        </span>
                                        <span><a class="dropdown-item " href="/api/user/update_view_subs/{{$sub->subs_id}}"><i class="fa-regular fa-pen-to-square text-primary fs-4"></i></a></span>
                                        <span style="cursor: pointer;"><i class="fa-solid fa-trash-can text-danger fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $sub->subs_id }}"></i></span>
                                    </div>
                                    @else
                                    <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $sub->subs_id }}" style="width: 130px;">
                                        Pay Now
                                    </button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach ($subscription as $sub)
        <div class="modal fade" id="exampleModal{{ $sub->subs_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content" style="border-radius: 4px;">

                    <form action="/api/user/cancel_subs/{{ $sub->subs_id }}" method="POST" class="php-email-form">
                        @csrf
                        <div class="modal-header pb-0" style="border: none ;">
                            <h4 class="modal-title" id="exampleModalLabel">Cancel subscription</h4>

                        </div>
                        <div class="modal-body pb-0" >
                            <strong class="">Are you sure you want to cancel your subscription.This service will be cancel immediately.</strong>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Still want to cancel your subscription? Please tell us why to help us improve!</label>
                                <textarea type="text" class="form-control" placeholder="Enter Your Reason" required name="cancelationReason" id="message-text"></textarea>
                            </div>
                        </div>
                        <footer class="modal-footer justify-content-start" style="border: none ">
                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">
                                    <span class="dynamic-message"></span>
                                </div>

                            </div>
                            <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal">KEEP PLAN</button>
                            <button type="submit" class="btn btn-danger">CANCEL SUBSCRIPTION</button>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal1{{ $sub->subs_id }}" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <header class="header">
                    
                    </header> --}}
                    <div class="content">
                        <div class="container p-0">
                            <div class="card px-4">
                                <p class="h2 py-3">Payment Details</p>
                                <form action="/api/user/payment/{{ $sub->subs_id }}" method="POST" class="php-email-form">
                                    <div class="payment-method">
                                        <label for="card" class="method card">
                                            <div class="card-logos">
                                                <img src="https://designmodo.com/demo/checkout-panel/img/visa_logo.png" />
                                                <img src="https://designmodo.com/demo/checkout-panel/img/mastercard_logo.png" />
                                            </div>

                                            <div class="radio-input">
                                                <input id="card" type="radio" value="Credit Card" name="payment_method">
                                                Pay with credit card
                                            </div>
                                        </label>

                                        <label for="paypal" class="method paypal">
                                            <img src="https://designmodo.com/demo/checkout-panel/img/paypal_logo.png" />
                                            <div class="radio-input">
                                                <input id="paypal" type="radio" value="paypal" name="payment_method">
                                                Pay with PayPal
                                            </div>
                                        </label>
                                    </div>
                                    <div class="row gx-3">
                                        <div class="col-12">
                                            <div class="d-flex flex-column">
                                                <p class="text mb-1">Person Name</p>
                                                <input class="form-control mb-3" name="holderName" type="text" placeholder="Name" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-column">
                                                <p class="text mb-1">Card Number</p>
                                                <input class="form-control mb-3" name="card_number" type="number" maxlength="16" placeholder="1234 5678 435678" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex flex-column">
                                                <p class="text mb-1">Expiry</p>
                                                <input class="form-control mb-3" name="cardExpiryDate" type="date" placeholder="MM/YYYY" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex flex-column">
                                                <p class="text mb-1">CVV/CVC</p>
                                                <input class="form-control mb-3 pt-2 " name="cvvcvc" type="password" placeholder="***" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            {{-- <div class="btn btn-primary mb-3"> --}}
                                            <div class="col-md-12 text-center">
                                                <div class="loading">Loading</div>
                                                <div class="error-message"></div>
                                                <div class="sent-message">
                                                    <span class="dynamic-message">Your message has been sent. Thank you!</span>
                                                </div>

                                            </div>
                                            <button class="btn bg-primary" id="paymentStatus" class="ps-3">Pay ${{ $sub->amount }} <span class="fas fa-arrow-right"></span></button>

                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</main>
@endsection
