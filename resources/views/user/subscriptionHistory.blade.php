@extends('master')

@section('content')
<main id="main" class="main">

    <div class="container-fluid ">
        @if(!$subscription)
        <div class="container">

            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>302</h1>
                <h2>User Has no Subscription History</h2>
                {{-- <a class="btn" href="index.html">Back to home</a> --}}
                <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">

            </section>

        </div>
        @else
        <div class="pagetitle">
            <h1>My Subscriptions History</h1>
            <nav>
                <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="/api/user/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="cursor: pointer;">Subscriptions History</li>
                </ol>
            </nav>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        {{-- <th scope="col">User ID</th> --}}
                        <th scope="col">Subscription ID</th>
                        <th scope="col">Email</th>
                        {{-- <th scope="col">Phone</th> --}}
                        <th scope="col">Software</th>
                        {{-- <th scope="col">Subscription Type</th> --}}
                        <th scope="col">Subscription Status</th>
                        {{-- <th scope="col">Business Category</th> --}}
                        {{-- <th scope="col">Plan Info</th> --}}
                        {{-- <th scope="col">Duration</th> --}}
                        <th scope="col">Active Time</th>
                        {{-- <th scope="col">Expiry Date</th> --}}
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscription as $sub)
                    <tr>
                        {{-- <td class="align-middle">{{ $sub->user_id }}</td> --}}
                        <td class="align-middle"><strong>#{{ $sub->subs_id }}</strong></td>
                        <td class="align-middle">{{ $sub->email }}</td>
                        {{-- <td class="align-middle">{{ $sub->phone }}</td> --}}
                        <td class="align-middle">{{ $sub->software }}</td>
                        {{-- <td class="align-middle">{{ $sub->subscriptionType }}</td> --}}
                        <td class="align-middle text-center">@if ($sub->subscriptionStatus === 'active')
                            <span class="text-light bg-success text-center" style="padding:4px 12px;
                        border-radius:8px;">Active</span>
                            @else
                            <span class="text-white bg-danger text-center" style="
                        padding:4px 8px;border-radius:8px;">{{$sub->subscriptionStatus}}</span>
                            @endif</td>
                        {{-- <td class="align-middle">{{ $sub->business_Category }}</td> --}}
                        {{-- <td class="align-middle">{{ $sub->planInfo }}</td> --}}
                        {{-- <td class="align-middle">{{ $sub->duration }} {{ $sub->durationType }}</td> --}}
                        <td class="align-middle"><strong>{{ $sub->startDate }}</strong> To <strong>{{ $sub->expiryDate }}</strong></td>
                        {{-- <td class="align-middle">{{ $sub->expiryDate }}</td> --}}
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

                        {{-- <td class="align-middle">{{ $sub->amount }}</td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif

    </div>
</main>
@endsection
