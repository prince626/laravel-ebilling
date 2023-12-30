@extends('master')
@section('content')
<main id="main" class="main">
    <div class="pricingTable">
        @if($software && $categories && $pricings && $validities && $subscription &&$addons )
        <div class=" m-auto bg-warning p-3 text-light text-center select-page-title" style="max-width: 100%">
            <h2 class="pricingTable-title ">Updates a plan that's right for you.</h2>
            <div class="text-center page-title-breadcrumbs"><span class="me-2"><a href="/api/user/dashboard"><i class="bi bi-house-fill text-light"></i></a></span><span class="me-2"><i class="bi bi-chevron-double-right"></i></span><span class="me-2">Pricing Plan</span></div>

        </div>
        {{-- <ul class="pricingTable-firstTable mt-5 row" >
            <li class="pricingTable-firstTable_table py-3 mt-1 col-md-4 text-center" style="line-break: 20px;">
                <div class="text-center">
                <h1 class="pricingTable-firstTable_table__header">Single Store</h1>
                <p>Best for Startups</p>
                <strike>INR <span class="singleStoreOffPrice">799</span></strike>
                <p class="pricingTable-firstTable_table__pricing"><span class="text-warning fw-bold">INR</span><span class="text-warning singleStorePrice">699</span>/<span class="singleStoreValidity">Month</span></p>

                <ul class="pricingTable-firstTable_table__options">
                    <div class="col-md-12">
                        <select id="singleStoreplan" class="form-select">
                            @php
                            $singleplans= $pricings->where('id','1');
                            @endphp
                            @foreach ($singleplans as $plan)
                            <option value="{{ $plan->validityId }}"> {{ $plan->name }} </option>
        @endforeach
        </select>
    </div>
    <li>1 Biller / Location</li>
    <li>3 Users / Devices</li>
    <li>Powerful Admin Panel</li>
    <li>10 GB Disk Space</li>
    <li>Monthly Bandwidth</li>
    </ul>
    <a href="/api/user/user_update_plan/{{$subscription->subs_id}}"><button class="btn btn-warning text-light">Get Started Now</button></a>
    </div>
    </li>
    <li class="pricingTable-firstTable_table py-3 mt-1 col-md-4 text-center">
        <h1 class="pricingTable-firstTable_table__header">Multi Store</h1>
        <p>Most Popular Choice</p>
        <strike>INR <span class="multiStoreOffPrice">1199</span></strike>
        <p class="pricingTable-firstTable_table__pricing"><span class="text-warning fw-bold">INR</span><span class="text-warning multiStorePrice">1099</span>/<span class="multiStoreValidity">Month</span></p>

        <ul class="pricingTable-firstTable_table__options">
            <div class="col-md-12">
                <select id="multiStoreplan" class="form-select">
                    @php
                    $singleplans= $pricings->where('id','2');
                    @endphp
                    @foreach ($singleplans as $plan)
                    <option value="{{ $plan->validityId }}"> {{ $plan->name }} </option>
                    @endforeach
                </select>
            </div>
            <li>3 Biller / Location</li>
            <li>10 Users / Devices</li>
            <li>Powerful Admin Panel</li>
            <li>10 GB Disk Space</li>
            <li>Monthly Bandwidth</li>
        </ul>

        <a href="/api/user/user_update_plan/{{$subscription->subs_id}}"><button class="btn btn-warning text-light">Get Started Now</button></a>
    </li>
    <li class="pricingTable-firstTable_table py-3 mt-1 col-md-4 text-center ">
        <h1 class="pricingTable-firstTable_table__header bold">Chain Store</h1>
        <p>For the whole team</p>
        <strike>INR <span class="chainStoreOffPrice">2099</span></strike>
        <p class="pricingTable-firstTable_table__pricing"><span class="text-warning fw-bold">INR</span><span class="text-warning chainStorePrice">1999</span>/<span class="chainStoreValidity">Month</span></p>

        <ul class="pricingTable-firstTable_table__options">
            <div class="col-md-12">
                <select id="chainStoreplan" class="form-select">
                    @php
                    $singleplans= $pricings->where('id','3');
                    @endphp
                    @foreach ($singleplans as $plan)
                    <option value="{{ $plan->validityId }}"> {{ $plan->name }} </option>
                    @endforeach
                </select>
            </div>
            <li>10 Biller / Location</li>
            <li>Unlimited Users / Devices</li>
            <li>Powerful Admin Panel</li>
            <li>10 GB Disk Space</li>
            <li>Monthly Bandwidth</li>
        </ul>
        <a href="/api/user/user_update_plan/{{$subscription->subs_id}}"><button class="btn btn-warning text-light">Get Started Now</button></a>
    </li>
    </ul> --}}
    <section class="pricing py-5">
        <div class="container">
            <div class="row text-center">
                <!-- Free Tier -->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-lg-0 pb-3 pricing-card">
                        <div class="card-body ">
                            <h5 class="card-title text-center fs-2">Single Store</h5>
                            <p style="font-size: 14px;">Best for Startups</p>
                            <strike class="text-muted fs-5 fw-semibold">INR <span class="singleStoreOffPrice ">799</span></strike>
                            <div class="card-price text-center" style="font-size: 40px"><span class="text-warning fw-bold">INR </span><span class="text-warning fw-semibold singleStorePrice">699</span><span class="text-muted">/</span><span class="period singleStoreValidity text-muted text-center fs-6">month</span></div>
                            <hr>
                            <div class="col-md-12 mb-3 text-center">
                                <select id="singleStoreplan" class="form-select m-auto text-center" style="width: 85%;">
                                    @php
                                    $singleplans= $pricings->where('id','1');
                                    @endphp
                                    @foreach ($singleplans as $plan)
                                    <option value="{{ $plan->validityId }}"> {{ $plan->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <ul class="fa-ul m-auto" style="font-size: 14px;">
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>1 Biller / Location</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>3 Users / Devices</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>Powerful Admin Panel</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>10 GB Disk Space</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>Monthly Bandwidth</li>
                            </ul>
                            <div class="d-grid">
                                <a href="/api/user/user_update_plan/{{$subscription->subs_id}}"><button class="btn btn-warning text-light">Get Started Now</button></a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Plus Tier -->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-lg-0 pb-3 pricing-card">
                        <div class="card-body ">
                            <h5 class="card-title  text-center fs-2">Multi Store</h5>
                            <p style="
                                font-size: 14px;">Most Popular Choice</p>
                            <strike class="text-muted fs-5 fw-semibold">INR <span class="multiStoreOffPrice">1199</span></strike>
                            <div class="card-price text-center" style="font-size: 40px"><span class="text-warning fw-bold">INR </span><span class="text-warning fw-semibold multiStorePrice"> 1099</span><span class="text-muted">/</span><span class="period multiStoreValidity text-muted fs-6">month</span></div>
                            <hr>
                            <div class="col-md-12 mb-3">
                                <select id="multiStoreplan" class="form-select m-auto text-center" style="width: 85%;">
                                    @php
                                    $singleplans= $pricings->where('id','2');
                                    @endphp
                                    @foreach ($singleplans as $plan)
                                    <option value="{{ $plan->validityId }}"> {{ $plan->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <ul class="fa-ul m-auto" style="font-size: 14px;">
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>3 Biller / Location</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>10 Users / Devices</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>Powerful Admin Panel</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>10 GB Disk Space</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>Monthly Bandwidth</li>
                            </ul>
                            <div class="d-grid">
                                <a href="/api/user/user_update_plan/{{$subscription->subs_id}}"><button class="btn btn-warning text-light">Get Started Now</button></a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pro Tier -->
                <div class="col-lg-4">
                    <div class="card mb-5 mb-lg-0 pb-3 pricing-card">
                        <div class="card-body">
                            <h5 class="card-title text-center fs-2">Chain Store</h5>
                            <p style="
                            font-size: 14px;">For the whole team</p>
                            <strike class="text-muted fs-5 fw-semibold">INR <span class="chainStoreOffPrice">2099</span></strike>
                            <div class="card-price text-center" style="font-size: 40px"><span class="text-warning fw-bold">INR </span><span class="text-warning fw-semibold chainStorePrice">1999</span><span class="text-muted">/</span><span class="period chainStoreValidity text-muted fs-6">month</span></div>
                            <hr>
                            <div class="col-md-12 mb-3">
                                <select id="chainStoreplan" class="form-select m-auto text-center" style="width: 85%;">
                                    @php
                                    $singleplans= $pricings->where('id','3');
                                    @endphp
                                    @foreach ($singleplans as $plan)
                                    <option value="{{ $plan->validityId }}"> {{ $plan->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <ul class="fa-ul text-center m-auto" style="font-size: 14px;">
                                <li class=""><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>10 Biller / Location</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>Unlimited Users / Devices</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>Powerful Admin Panel</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>10 GB Disk Space</li>
                                <li><i class="bi bi-check-lg fs-5 text-success fw-bolder p-1"></i>Monthly Bandwidth</li>
                            </ul>
                            <div class="d-grid">
                                <a href="/api/user/user_update_plan/{{$subscription->subs_id}}"><button class="btn btn-warning text-light">Get Started Now</button></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const singleStoreplan = document.getElementById('singleStoreplan');

            const singleStorePrice = document.querySelector('.singleStorePrice');
            const singleStoreOffPrice = document.querySelector('.singleStoreOffPrice');
            const singleStoreValidity = document.querySelector('.singleStoreValidity');

            singleStoreplan.addEventListener('change', function() {
                const singleStore_Price = singleStoreplan.value;
                const pricings = @json($pricings);
                pricings.forEach(function(price) {
                    if (price.validityId == singleStore_Price) {
                        singleStorePrice.textContent = price.price;
                        singleStoreOffPrice.textContent = (parseInt(price.price) + 100).toString();
                        singleStoreValidity.textContent = price.validity;
                    }
                });
            })
            const multiStoreplan = document.getElementById('multiStoreplan');

            const MultiStorePrices = document.querySelector('.multiStorePrice');
            const multiStoreValidity = document.querySelector('.multiStoreValidity');
            const multiStoreOffPrice = document.querySelector('.multiStoreOffPrice');

            multiStoreplan.addEventListener('change', function() {
                const multiStore_Price = multiStoreplan.value;
                const pricings = @json($pricings);
                pricings.forEach(function(price) {
                    if (price.validityId == multiStore_Price) {
                        MultiStorePrices.textContent = price.price;
                        multiStoreOffPrice.textContent = (parseInt(price.price) + 100).toString();
                        multiStoreValidity.textContent = price.validity;
                    }
                });
            })

            const chainStoreplan = document.getElementById('chainStoreplan');

            const ChainStorePrices = document.querySelector('.chainStorePrice');
            const chainStoreValidity = document.querySelector('.chainStoreValidity');
            const chainStoreOffPrice = document.querySelector('.chainStoreOffPrice');

            chainStoreplan.addEventListener('change', function() {
                const chainStore_Price = chainStoreplan.value;
                const pricings = @json($pricings);
                pricings.forEach(function(price) {
                    if (price.validityId == chainStore_Price) {
                        ChainStorePrices.textContent = price.price;
                        chainStoreOffPrice.textContent = (parseInt(price.price) + 100).toString();
                        chainStoreValidity.textContent = price.validity;
                    }
                });
            })
        });

    </script>
</main>
@endsection
