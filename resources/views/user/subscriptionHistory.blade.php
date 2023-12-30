@extends('master')

@section('content')
<main id="main" class="main">
    <style>

    </style>
    <div class="container-fluid ">
        @if(!$subscription)
        <div class="container">
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>302</h1>
                <h2>User Has no Subscription History</h2>
                <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">
            </section>
        </div>
        @else

        <!-- subscription History Title-->

        <div class="pagetitle">
            <h1>My Subscriptions History</h1>
            <nav class="pt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/api/user/dashboard" class="active">Dashboard</a></li>
                    <li class="breadcrumb-item " >Subscriptions History</li>
                </ol>
            </nav>
        </div>

        <!-- subscription History Table-->
        <div class="card">
            <div class="card-header" style="border: none">
                <div class="card-title">
                    <h5 class="card-label text-dark fw-medium"> Subscription History List
                        <span class="d-block text-muted pt-2 font-size-sm"> You can View Subscription History Here</span></h5>
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
                                <th scope="col">Subscription Status</th>
                                <th scope="col">Active Time</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Status</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($subscription as $sub)
                            <tr>
                                <td class="align-middle"><strong>#{{ $sub->subs_id }}</strong></td>
                                <td class="align-middle">{{ $sub->email }}</td>
                                <td class="align-middle">{{ $sub->software }}</td>
                                <td class="align-middle ">@if ($sub->subscriptionStatus === 'active')
                                    <span class="text-light bg-success " style="padding:4px 12px;
                        border-radius:8px;">Active</span>
                                    @else
                                    <span class="text-white bg-danger text-center" style="
                        padding:4px 8px;border-radius:8px;">{{$sub->subscriptionStatus}}</span>
                                    @endif</td>
                                <td class="align-middle"><strong>{{ $sub->startDate }}</strong> To <strong>{{ $sub->expiryDate }}</strong></td>
                                <td class="align-middle"><strong>₹{{ $sub->amount }}</strong></td>

                                <td class="align-middle text-center" class="">
                                    @if ($sub->paymentStatus === 'paid')
                                    <span class="text-light bg-success text-center " style="
                        padding:4px 12px;border-radius:8px;">Paid</span>
                                    @else
                                    <span class="text-light bg-danger text-center" style="
                        padding:4px 8px;border-radius:8px;">Unpaid</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        @endif

    </div>
</main>
@endsection
