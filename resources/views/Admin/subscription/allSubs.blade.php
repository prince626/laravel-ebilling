@extends('master')
<style></style>
@section('content')
<div class="container-fluid pt-5 ">
    <style>
        /* Snackbar Styles */

    </style>
    @if (request('message'))
    <div id="snackbar" class="snackbar bg-success">
        {{ request('message') }}
    </div>
    @endif
    @if(!$subscription)
    <h1>User has no Subscription</h1>
    @else
    <h1>Subscription Details</h1>


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th scope="col">User ID</th> --}}
                    <th scope="col">Subscription ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Software</th>
                    <th scope="col">Subscription Type</th>
                    {{-- <th scope="col">Subscription Status</th> --}}
                    <th scope="col">Business Category</th>
                    <th scope="col">Plan Info</th>
                    {{-- <th scope="col">Duration</th>
                    <th scope="col">Duration Type</th> --}}
                    <th scope="col">Start Date</th>
                    <th scope="col">Expiry Date</th>
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
                    <td>{{ $sub->subs_id }}</td>
                    <td>{{ $sub->email }}</td>
                    <td>{{ $sub->phone }}</td>
                    <td>{{ $sub->software }}</td>
                    <td>{{ $sub->subscriptionType }}</td>
                    {{-- <td>{{ $sub->subscriptionStatus }}</td> --}}
                    <td>{{ $sub->business_Category }}</td>
                    <td>{{ $sub->planInfo }}</td>
                    {{-- <td>{{ $sub->Duration }}</td>
                    <td>{{ $sub->durationType }}</td> --}}
                    <td>{{ $sub->startDate }}</td>
                    <td>{{ $sub->expiryDate }}</td>
                    <td>{{ $sub->amount }}</td>

                    <td class="text-center">
                        @if ($sub->paymentStatus === 'paid')
                        <p class="text-success text-center w-100" style="background: #8bd98e;
                        padding:4px;border-radius:8px;font-weight:bold;">Paid</p>
                        @else
                        <p class="text-danger text-center" style="background: #caa5a5;
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
                    <td style="align-items: center;width:150px;">
                        @if ($sub->paymentStatus === 'paid')
                        <a href="/api/admin/user_subs_action/{{$sub->subs_id}}" class="m-1">
                            {{-- <button class="btn btn-{{ $sub->activationStatus ? 'danger' : 'success' }}"> --}}
                            @if ($sub->activationStatus)
                            <i class="fas fa-toggle-on" style="color: green;font-size:25px;"></i>
                            @else
                            <i class="fas fa-toggle-off" style="color:gray;font-size:25px;"></i>

                            @endif
                            {{-- </button> --}}
                        </a>
                        {{-- <a href="/user_update_plan/{{$sub->subs_id}}" class="m-1"> <i class="fa-regular fa-pen-to-square" style="font-size:25px;"></i></a> --}}
                        <i class="fa-solid fa-trash-can text-danger m-1" data-toggle="modal" data-target="#exampleModal{{ $sub->subs_id }}" style="cursor: pointer;font-size:25px;"></i>
                        @else
                        <button type="button" class="btn btn-warning w-100" data-toggle="modal" data-target="#exampleModal1{{ $sub->subs_id }}">
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/api/admin/cancel_subs/{{ $sub->subs_id }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cancel Subscription Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message-text" class="col-form-labael">Reason:</label>
                            <textarea class="form-control" required name="cancelationReason" id="message-text"></textarea>
                        </div>
                    </div>
                    <footer class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm Cancel</button>
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
<div class="modal fade" id="exampleModal1{{ $sub->subs_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="text" /></div>
                        </div>
                        <div class='form-row'>
                            <div class='input-group'>
                                <label for=''>Card Number</label>
                                <input maxlength='16' placeholder='' type='number'>
                            </div>
                        </div>
                        <div class='form-row' style="display: none">
                            <div class='input-group'>
                                <label for=''>Expiry Date</label>
                                <input maxlenght='16' placeholder='' type='month'>
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
</div>
</div>
</div>
</div>
@endforeach
@endif
<script>
    // Show the Snackbar
    var snackbar = document.getElementById("snackbar");
    snackbar.style.display = "block";
    snackbar.classList.add("show");

    // Hide the Snackbar after 2 seconds (2000 milliseconds)
    setTimeout(function() {
        snackbar.classList.remove("show");
        setTimeout(function() {
            snackbar.style.display = "none";
        }, 500); // Delay hiding after the fadeout animation
    }, 2000);

</script>
</div>
@endsection
