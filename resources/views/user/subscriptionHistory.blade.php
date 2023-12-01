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
        <h1>Subscription History</h1>

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
                        <th scope="col">Plan Info</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscription as $sub)
                    <tr>
                        {{-- <td>{{ $sub->user_id }}</td> --}}
                        <td>{{ $sub->subs_id }}</td>
                        <td>{{ $sub->email }}</td>
                        {{-- <td>{{ $sub->phone }}</td> --}}
                        <td>{{ $sub->software }}</td>
                        {{-- <td>{{ $sub->subscriptionType }}</td> --}}
                        <td>{{ $sub->subscriptionStatus }}</td>
                        {{-- <td>{{ $sub->business_Category }}</td> --}}
                        <td>{{ $sub->planInfo }}</td>
                        <td>{{ $sub->duration }} {{ $sub->durationType }}</td>
                        <td>{{ $sub->startDate }}</td>
                        <td>{{ $sub->expiryDate }}</td>
                        <td>{{ $sub->amount }}</td>

                        <td class="text-center">
                            @if ($sub->paymentStatus === 'paid')
                            <p class="text-light bg-success text-center w-100" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Paid</p>
                            @else
                            <p class="text-light bg-danger text-center" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Unpaid</p>
                            @endif
                        </td>

                        {{-- <td>{{ $sub->amount }}</td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif

    </div>
</main>
@endsection
