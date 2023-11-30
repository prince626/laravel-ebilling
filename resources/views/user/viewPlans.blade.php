@extends('master')
@section('content')
<main id="main" class="main">

    <style>
        #inputState.custom-bg {
            /* background-color: rgb(192, 192, 192); */
            /* Change this to the desired background color */
            /* color: black; */
            /* line-height: 2; */
            /* Change this to the desired text color */
        }


        option:hover {
            background-color: blue !important;
        }

    </style>
    @if($software && $categories && $pricings && $validities && $user &&$addons )

    <div class="pricingTable">
        <h2 class="pricingTable-title">Find a plan that's right for you.</h2>
        <ul class="pricingTable-firstTable mt-4 ">
            <li class="pricingTable-firstTable_table ">
                <h1 class="pricingTable-firstTable_table__header ">Single Store</h1>
                <p>Best for Startups</p>
                <strike>INR 799</strike>
                <p class="pricingTable-firstTable_table__pricing"><span>INR</span><span>699</span><span>Month</span></p>
                <ul class="pricingTable-firstTable_table__options">
                    <div class="col-md-12">
                        <select id="inputState" class="form-select" data-size="3">
                            @php
                            $singleplans= $pricings->where('id','1');
                            @endphp
                            @foreach ($singleplans as $plan)
                            <option value="{{ $plan->name }}"> {{ $plan->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <li>1 Biller / Location</li>
                    <li>3 Users / Devices</li>
                    <li>Powerful Admin Panel</li>
                    <li>10 GB Disk Space</li>
                    <li>Monthly Bandwidth</li>
                </ul>
                <a href="/api/user/plans/selectplans"><button class="pricingTable-firstTable_table__getstart">Get Started Now</button></a>
            </li>
            <li class="pricingTable-firstTable_table">
                <h1 class="pricingTable-firstTable_table__header">Multi Store</h1>
                <p>Most Popular Choice</p>
                <strike>INR 1199</strike>
                <p class="pricingTable-firstTable_table__pricing"><span>INR</span><span>1099</span><span>Month</span></p>

                <ul class="pricingTable-firstTable_table__options">
                    <div class="col-md-12">
                        <select id="inputState" class="form-select  custom-bg">
                            @php
                            $singleplans= $pricings->where('id','2');
                            @endphp
                            @foreach ($singleplans as $plan)
                            <option class="custom-bg" value="{{ $plan->name }}"> {{ $plan->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <li>3 Biller / Location</li>
                    <li>10 Users / Devices</li>
                    <li>Powerful Admin Panel</li>
                    <li>10 GB Disk Space</li>
                    <li>Monthly Bandwidth</li>
                </ul>
                <a href="/api/user/plans/selectplans"><button class="pricingTable-firstTable_table__getstart">Get Started Now</button></a>
            </li>
            <li class="pricingTable-firstTable_table">
                <h1 class="pricingTable-firstTable_table__header bold">Chain Store</h1>
                <p>For the whole team</p>
                <strike>INR 2099</strike>
                <p class="pricingTable-firstTable_table__pricing"><span>INR</span><span>1999</span><span>Month</span></p>

                <ul class="pricingTable-firstTable_table__options">
                    <div class="col-md-12">
                        <select id="inputState" class="form-select">
                            @php
                            $singleplans= $pricings->where('id','3');
                            @endphp
                            @foreach ($singleplans as $plan)
                            <option value="{{ $plan->name }}"> {{ $plan->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <li>10 Biller / Location</li>
                    <li>Unlimited Users / Devices</li>
                    <li>Powerful Admin Panel</li>
                    <li>10 GB Disk Space</li>
                    <li>Monthly Bandwidth</li>
                </ul>
                <a href="/api/user/plans/selectplans"><button class="pricingTable-firstTable_table__getstart">Get Started Now</button></a>
            </li>
        </ul>
    </div>
    @else
    <div class="container">

        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>302</h1>
            <h2>Something Went Wrong</h2>
            {{-- <a class="btn" href="index.html">Back to home</a> --}}
            <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">

        </section>

    </div>
    @endif
</main>
@endsection
