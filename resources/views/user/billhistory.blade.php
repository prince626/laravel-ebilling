@extends('master')

@section('content')
<main id="main" class="main">
    <div class="container-fluid ">
        @if(!$bills)
        <h1>User has no Bill History</h1>
        @else
        <h1>Bill History</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Date of Payment</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Subscription ID</th>
                        <th scope="col">Bill No</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Payment Id</th>
                        <th scope="col">Email</th>
                        <th scope="col">Software</th>
                        <th scope="col">Plan</th>
                        <th scope="col">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bills as $bill)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($bill->created_at)->format('l Y-m-d H:i:s') }}</td>


                        <td>{{ $bill->user_id }}</td>
                        <td>{{ $bill->subs_id }}</td>
                        <td>{{ $bill->bill_no }}</td>
                        <td>{{ $bill->payment_method }}</td>
                        <td>{{ $bill->payment_id }}</td>
                        <td>{{ $bill->email }}</td>
                        <td>{{ $bill->software }}</td>
                        <td>{{ $bill->plan }}</td>
                        <td>{{ $bill->total }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif

    </div>
</main>
@endsection
