@extends('master')

@section('content')
<main id="main" class="main mb-5 pb-5">

    <div class="container-fluid">
        {{-- @if (request('message'))
        <div id="snackbar" class="snackbar bg-success">
            {{ request('message') }}
    </div>
    @endif --}}

    @if($cancelSubs==null)
    <h1>User has no cancel Subscription</h1>
    @else
    <h1>Canceled Subscription Details</h1>
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">


                            <div class="card-body">
                                <h5 class="card-title">Total <span>|Canceled Subscriptions</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ count($cancelSubs) }}</h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title"> Refund<span>| Process Subscriptions </span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal text-warning" ></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $cancelSubs->where('refundStatus', 'Processing')->count() }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title">Refund <span>| Pending Amount</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-rupee text-danger"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>₹{{ $cancelSubs->where('refundStatus', 'Processing')->sum('refundAmount') }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title">Total <span>| Refunded Amount</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-rupee text-success"></i>

                                    </div>
                                    <div class="ps-3">
                                        <h6>₹{{ $cancelSubs->where('refundStatus', 'completed')->sum('refundAmount') }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    {{-- <th scope="col">User ID</th> --}}
                    <th scope="col">Subscription ID</th>
                    <th scope="col">Email</th>
                    {{-- <th scope="col">Phone</th> --}}

                    <th scope="col">Software</th>
                    {{-- <th scope="col">Subscription Type</th> --}}
                    {{-- <th scope="col">planInfo</th> --}}
                    <th scope="col">Amount</th>
                    <th scope="col">Refund Amount</th>
                    <th scope="col">Cancelation Reason</th>
                    <th scope="col">Cancelation Date</th>
                    <th scope="col">Refund Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cancelSubs as $sub)
                <tr>
                    {{-- <td>{{ $sub->user_id }}</td> --}}
                    <td><strong>#{{ $sub->subs_id }}</strong></td>
                    <td>{{ $sub->email }}</td>
                    {{-- <td>{{ $sub->phone }}</td> --}}

                    <td>{{ $sub->software }}</td>
                    {{-- <td>{{ $sub->subscriptionType }}</td>
                    <td>{{ $sub->planInfo }}</td> --}}
                    <td><strong>₹{{ $sub->amount }}</strong></td>
                    <td><strong>₹{{ $sub->refundAmount }}</strong></td>
                    <td>{{ $sub->cancelationReason }}</td>
                    <td>{{ $sub->cancelationDate }}</td>
                    <td>
                        @if ($sub->refundStatus === 'completed')
                        <p class="text-light bg-success text-center w-100" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Completed</p>
                        @elseif ($sub->refundStatus === 'Processing')
                        <p class="text-light bg-warning text-center" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Processing</p>

                        @endif
                    </td>
                    {{-- <td>{{ $sub->refundStatus }}</td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    </div>
</main>
@endsection
