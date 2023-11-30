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
    <h1>Cancel Subscription Details</h1>

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
                    <td>#{{ $sub->subs_id }}</td>
                    <td>{{ $sub->email }}</td>
                    {{-- <td>{{ $sub->phone }}</td> --}}

                    <td>{{ $sub->software }}</td>
                    {{-- <td>{{ $sub->subscriptionType }}</td>
                    <td>{{ $sub->planInfo }}</td> --}}
                    <td>{{ $sub->amount }}</td>
                    <td>{{ $sub->cancelationReason }}</td>
                    <td>{{ $sub->cancelationDate }}</td>
                    <td>{{ $sub->refundAmount }}</td>
                    <td>
                        @if ($sub->refundStatus === 'completed')
                        <p class="text-success text-center w-100" style="background: #8bd98e;
                        padding:4px;border-radius:8px;font-weight:bold;">Completed</p>
                        @elseif ($sub->refundStatus === 'Processing')
                        <p class="text-danger text-center" style="background: #caa5a5;
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
