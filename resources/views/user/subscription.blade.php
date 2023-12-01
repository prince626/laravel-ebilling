@extends('master')
<style></style>
@section('content')

<main id="main" class="main mb-5">
    <h1>Subscription Details</h1>

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
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-receipt"></i>
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
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart" style="color: green;"></i>
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
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal" style="color: red;"></i>
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
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal-bookmark-fill" style="color:green;"></i>
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
    <div class="container-fluid pt-5 ">
        <style>
            /* Snackbar Styles */

        </style>

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


        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        {{-- <th scope="col">User ID</th> --}}
                        <th scope="col">Subs ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Software</th>
                        {{-- <th scope="col">Subscription Type</th> --}}
                        <th scope="col"> Status</th>
                        {{-- <th scope="col">Business Category</th> --}}
                        {{-- <th scope="col">Plan Info</th> --}}
                        {{-- <th scope="col">Duration</th>
                    <th scope="col">Duration Type</th> --}}
                        {{-- <th scope="col">Start Date</th> --}}
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Activate</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Action</th>
                        {{-- <th scope="col">Cancel</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscription as $sub)
                    <tr>
                        {{-- <td>{{ $sub->user_id }}</td> --}}
                        <td><strong>#{{ $sub->subs_id }}</strong></td>
                        <td>{{ $sub->email }}</td>
                        <td>{{ $sub->phone }}</td>
                        <td>{{ $sub->software }}</td>
                        {{-- <td>{{ $sub->subscriptionType }}</td> --}}
                        <td>
                            @if ($sub->subscriptionStatus === 'active')
                            <p class="text-light bg-success text-center" style="padding:4px;
                        border-radius:8px;font-weight:bold;">Active</p>
                            @else
                            <p class="text-white bg-danger text-center" style="
                        padding:4px;border-radius:8px;font-weight:bold;">{{$sub->subscriptionStatus}}</p>
                            @endif
                            {{-- {{ $sub->subscriptionStatus }} --}}
                        </td>
                        {{-- <td>{{ $sub->business_Category }}</td> --}}
                        {{-- <td>{{ $sub->planInfo }}</td> --}}
                        {{-- <td>{{ $sub->Duration }}</td>
                        <td>{{ $sub->durationType }}</td> --}}
                        {{-- <td>{{ $sub->startDate }}</td> --}}
                        <td><strong>{{ $sub->expiryDate }}</strong></td>
                        <td>@if ($sub->activationStatus)
                            <a href="/api/user/user-edit-key/{{$sub->subs_id}}" id="" class="m-1 activateAction">
                                <i class="fas fa-toggle-on" style="color: green;font-size:25px;"></i>
                            </a>
                            @else
                            <a href="/api/user/user-edit-key/{{$sub->subs_id}}" id="" class="m-1 activateAction">
                                <i class="fas fa-toggle-off" style="color:gray;font-size:25px;"></i>
                            </a>
                            @endif
                        </td>
                        <td><strong>₹{{ $sub->amount }}</strong></td>

                        <td class="text-center">
                            @if ($sub->paymentStatus === 'paid')
                            <p class="text-light bg-success text-center" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Paid</p>
                            @else
                            <p class="text-light text-center bg-danger" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Unpaid</p>
                            @endif
                        </td>


                        {{-- <td>{{ $sub->paymentStatus }}</td> --}}
                        {{-- <td class="text-center">
                        <a href="/api/user/user-edit-key/{{$sub->subs_id}}">
                        @if ($sub->activationStatus)
                        <i class="fas fa-toggle-on" style="color: green;font-size:35px;"></i>
                        @else
                        <i class="fas fa-toggle-off" style="color:gray;font-size:35px;"></i>

                        @endif
                        </a>
                        </td> --}}


                        {{-- <td><a href="/user_update_plan/{{$sub->subs_id}}"><button class="btn btn-primary">Update Plan</button></a></td> --}}
                        <td style="align-items: center;">
                            @if ($sub->paymentStatus === 'paid')
                            {{-- <button class="btn btn-{{ $sub->activationStatus ? 'danger' : 'success' }}"> --}}
                            <div class="filter mt-1">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="invoice-dropdown dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class=""><i class="fa-regular fa-pen-to-square text-primary"></i><a class="dropdown-item" href="/api/user/update_view_subs/{{$sub->subs_id}}">Update</a></li>
                                    <li data-bs-toggle="modal" data-bs-target="#exampleModal{{ $sub->subs_id }}"><i class="fa-solid fa-trash-can text-danger"></i><a class="dropdown-item" href="#delete">Cancel</a></li>
                                </ul>
                            </div>
                            {{-- </button> --}}
                            {{-- /api/user/user_update_plan/{{$sub->subs_id}} --}}
                            {{-- <a href="/api/user/update_view_subs/{{$sub->subs_id}}" class="m-1 "> <i class="fa-regular fa-pen-to-square" style="font-size:25px;"></i></a>
                            <i class="fa-solid fa-trash-can text-danger m-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $sub->subs_id }}" style="cursor: pointer;font-size:25px;"></i> --}}
                            @else
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $sub->subs_id }}">
                                Pay Now
                            </button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @foreach ($subscription as $sub)
        <div class="modal fade" id="exampleModal{{ $sub->subs_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">

                    <form action="/api/user/cancel_subs/{{ $sub->subs_id }}" method="POST" class="php-email-form">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cancel my paid subscription</h5>
                            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> --}}
                        </div>
                        <div class="modal-body">
                            <strong class="">Are you sure to delete your subscription.This service will be cancel immediately.</strong>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Cancellation Reason:</label>
                                <textarea type="text" class="form-control" placeholder="Enter Your  Reason" required name="cancelationReason" id="message-text"></textarea>
                            </div>
                        </div>
                        <footer class="modal-footer justify-content-start">
                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">
                                    <span class="dynamic-message"></span>
                                </div>

                            </div>
                                <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal">Keep Plan</button>
                                <button type="submit" class="btn btn-danger">Cancel Subscription</button>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
        {{-- <div class="modal fade" id="exampleModal1{{ $sub->subs_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/api/user/payment/{{ $sub->subs_id }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">After payment you will be activate your subscription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <button type="button" class="btn btn-secondary m-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary m-2">Pay Now</button>
                </form>
            </div>
        </div>
    </div> --}}
    {{-- <div class="modal fade" id="exampleModal1{{ $sub->subs_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/api/user/payment/{{ $sub->subs_id }}" method="POST">
                <header class="header">
                    <h1>Comfirm Payment</h1>
                    <h5>Total Amount : {{ $sub->amount }}</h5>
                    <div class="card-type d-flex">
                        <a href="" class="card active"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/Amex.png' alt="" /></a>
                        <a href="" class="card"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/Discover.png' alt="" /></a>
                        <a href="" class="card"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/Visa.png' alt="" /></a>
                        <a href="" class="card"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/MC.png' alt="" /></a>
                    </div>
                </header>
                <div class="content">
                    <div class="form">
                        <div class="form-row">
                            <div class="input-group"><label for="">Name on card</label>
                                <input type="text" required name="payment_method" /></div>
                        </div>
                        <div class='form-row'>
                            <div class='input-group'>
                                <label for=''>Card Number</label>
                                <input maxlength='16' required name="card_number" placeholder='' type='number'>
                            </div>
                        </div>

                    </div>
                </div>
                <footer class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="paymentStatus">Payment</button>
                </footer>
            </form>
        </div>
    </div>
    </div> --}}

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
    </div>
    </div>
    </div>
    @endforeach
    @endif

    </div>

</main>
@endsection
