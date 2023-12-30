@extends('master')

@section('content')
<main id="main" class="main mb-5 pb-5">

    <div class="container-fluid">

        @if($cancelSubs==null)
        <h1>User has no cancel Subscription</h1>
        @else
        <div class="pagetitle">
            <h1>Canceled Subscriptions</h1>
            <nav class="pt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/api/user/dashboard" class="active">Dashboard</a></li>
                    <li class="breadcrumb-item " >Canceled Subscriptions</li>
                </ol>
            </nav>
        </div>

        <!-- Cancel Subscription  Cards -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card sales-card">


                                <div class="card-body">
                                    <h5 class="card-title">Total <span>|Canceled Subscriptions</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center bg-primary justify-content-center">
                                            <i class="bi bi-receipt text-light"></i>
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
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning">
                                            <i class="bi bi-journal text-light"></i>
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
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger">
                                            <i class="bi bi-currency-rupee text-light"></i>
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
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success">
                                            <i class="bi bi-currency-rupee text-light"></i>

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

        <!--Canceled subscription Table -->
        <div class="card">
            <div class="card-header" style="border: none">
                <div class="card-title">
                    <h5 class="card-label text-dark fw-medium"> Cancel Subscription List
                        <span class="d-block text-muted pt-2 font-size-sm"> You can View Cancel Subscription History Here</span></h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Subscription ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Software</th>
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

                                <td><strong>#{{ $sub->subs_id }}</strong></td>
                                <td>{{ $sub->email }}</td>

                                <td>{{ $sub->software }}</td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

            </div>
        </div>
    </div>
</main>
@endsection
