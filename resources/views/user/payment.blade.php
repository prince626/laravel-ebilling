@extends('master')

@section('content')
<main id="main" class="main">

    <div class="container">
        <div class="info">
            <h1>Payment Card</h1>

        </div>
        <form action="/api/user/payment/{{ $subscription->subs_id }}" method="POST">
            @csrf
            <header class="header">
                <h4>Subscription Amount{{ $amount }}</h4>
                <h4>Refund Amount{{ $refundAmount }}</h4>
                <h4>Total Amount {{ $amount-$refundAmount }}</h4>
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
                            <input type="text" name="payment_method" /></div>
                    </div>
                    <div class='form-row'>
                        <div class='input-group'>
                            <label for=''>Card Number</label>
                            <input maxlength='16' name="card_number" placeholder='' type='number'>
                        </div>
                    </div>

                </div>
            </div>
            <footer class="footer">
                <button class="btn btn-primary">Complete Payment</button>
                <button class="btn btn-primary" onclick="goBack()">Later Payment</button>
            </footer>
        </form>
    </div>
    </div>
</main>
<script>
    function goBack() {
        window.history.back();
    }

</script>
@endsection
