@extends('master')
@section('content')

<style>
    select option:hover {
        background-color: black !important;
        /* Change this to the desired hover color */
    }

</style>
<main id="main" class="main">
    @if($software && $categories && $pricings && $validities && $user &&$addons )

    <div class="container-fluid ">
        <div class="bg-warning  py-4 px-4 text-light" style="span:not(:last-child) {
            margin-right: 10px;">
            <h4 class="text-center">Seamless Transactions, Elevated Experiences: Your Software, Your Way</h4>
            <p class="text-center">Unlock the full potential of our software with a simple payment. Begin your journey today and enjoy enchanced features and endless possibilities.</p>
            <div class="text-center"><span class="me-2 "><a href="/api/user/dashboard" class="text-light"><i class="bi bi-house-fill"></i></a></span><span class="me-2"><i class="bi bi-chevron-double-right"></i></span><span class="me-2">Detail</span><span class="me-2"><i class="bi bi-chevron-double-right"></i></span><span>payment</span></div>
        </div>

        <form action='/api/user/subs/{{ $user->token }}' method="POST" class="php-email-form mt-4">
            @csrf
            <div class=" justify-content-center select_subscription">
                <div class="bg-white p-3 mx-1">
                    <h5 class="font-bold">Select Software</h5>
                    <select class=" form-select" name="software" required aria-label="Default select example" id="softwareSelect">
                        <option value="">Select</option>

                        @foreach ($software as $software)
                        <option value="{{ $software->name }}"> {{ $software->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-white row mt-4 mx-1 bg-light p-3">
                    <div class="col-md-4">
                        <h5>Select Businesss Category</h5>
                        <select class=" form-select" id="category" name="businessCategory" required aria-label="Default select example" required>
                            <option name="businessCategory" value="">SELECT</option>
                            @foreach ($categories as $category)
                            <option name="businessCategory" value="{{ $category->id }}">{{ $category->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="col-md-4">
                        <h3>Plan</h3>
                        <select class="form-select" id="plan" name="plan" required aria-label="Default select example">
                            <option value="null">SELECT</option>
                        </select>
                    </div> --}}
                    {{-- <div class="col-md-4">
                        <h3>Plan</h3>
                        <select class="form-select" name="plan" required aria-label="Default select example" required>
                            <option name="plan" value="null">SELECT</option>
                            @foreach ($pricings as $price)
                            <option name="plan" value="{{ $price->id }} " data-price=" {{ $price->price }} "> {{ $price->name }} </option>
                    @endforeach
                    </select>
                </div> --}}
                <div class="col-md-4">
                    <h5 class="" >Select Your Plan</h5>
                    <select class="form-select" id="plan" name="plan" style="" required aria-label="Default select example" required>
                        <option value="null">SELECT</option>
                    </select>
                </div>
                {{-- <div class="col-md-4">
                    <div class="row">
                        <h3>Duration</h3>
                        <select class="form-select" name="duration" required aria-label="Default select example" required>
                            <option name="duration" value="null">SELECT</option>
                            @foreach ($validities as $validity)
                            <option name="duration" value="{{ $validity->id }}">{{ $validity->duration }} {{ $validity->durationType }} </option>
                @endforeach
                </select>
            </div> --}}
            {{-- </div> --}}
            <div class="col-md-4">
                {{-- <div class="row"> --}}
                <h5>Duration</h5>
                <select class="form-select" id="duration" name="duration" required aria-label="Default select example" required>
                    <option value="null">SELECT</option>
                </select>
                {{-- </div> --}}
            </div>
    </div>
    <div class="row mt-4 bg-white  mx-1 p-4" style="align-items: center">
        <div class="col-md-2">
            <h5 id="categoryId">Addons</h5>
        </div>
        {{-- <div class="col-md-11">
                    <select class="form-select" name="addons" aria-label="Default select example" required>
                        <option name="addons" value="null">SELECT</option>
                        @foreach ($addons as $addon)
                        <option name="addons" value="{{ $addon->id }}" data-price="{{ $addon->price }}">INR {{ $addon->name }} </option>
        @endforeach
        </select>
    </div> --}}
        <div class="col-md-7 ">
            <select class="form-select" id="addons" name="addons" aria-label="Default select example" required>
                <option class="custom" -bg value="null">SELECT</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <p class="text-warning" id="seeSomeAddons" style="cursor:pointer;"><span class="text-warning" style="text-decoration: underline;">See Some Addons </span><i class="bi bi-plus text-light bg-warning m-1 px-1"></i> </p>
        </div>

    </div>
    <div class="chooseplan bg-white mt-4  p-4">
        <div class=" afteraddons" style="display: none;">
            <h5>Selected Addons</h5>
            <p style="font-size: 16px;">Addons : <span id="addonsName">Not Selected</span></p>
            <div class="row">
                <div class="col-md-10">
                    <p class="" style="font-size: 16px;"><span id="addonsdescription1" class="m-2"></span><span id="addonsdescription2" class="m-2"></span></p>
                </div>
                <div class="col-md-2">
                    <p class="btn btn-warning text-end float-end text-light" id="addonsAmount">Not Selected</p>
                </div>
            </div>
            <hr>

        </div>
        <div class=" beforeplans" style="display: none;">
            <h5 class="text-bold">Selected Plan</h5>
            <p>Enjoy plan with the following features and benefits</p>
            <div class="row">
                <div class="col-md-10">
                    <p class="" style="font-size: 16px;"><span id="description1" class="m-2"></span><span id="description2" class="m-2"></span><span id="description3" class="m-2"></span><span id="description4" class="m-2"></span></p>
                </div>
                <div class="col-md-2">
                    <p class="btn btn-warning text-end float-end text-light" id="planAmount"></p>
                </div>
                <hr>

            </div>
        </div>
        
        
        <div class="afterselectedAmount" >
            {{-- <h4>Selected Payment</h4> --}}
            <h5>Total :-</h5>
            <div class="row" style="align-items:center;">
                <div class="col-md-9 mt-0">
                    <p> <a href="#kitaction" class="text-warning fw-bold">Have A kit code ?</a></p>
                </div>
                <div class="col-md-3">
                    <p class="btn btn-warning text-light text-end float-end " id="selectedAmount">INR</p>
                </div>
            </div>
            {{-- <hr> --}}

        </div>
        <div class="form-check  ">
            <input class="form-check-input" name="accept" type="checkbox" value="accept" id="flexCheckDefault" required>
            <label class="form-check-label" for="flexCheckDefault" style="font-size: 14px;">
                I Agree with the terms and Condition
            </label>
        </div>
    </div>

    <input type="hidden" name="paymentStatus" id="paymentStatusField">

    <div class="bg-white p-3 mt-4" style="">
        {{-- <h4>Selected Payment</h4> --}}
        <h5>Payment Methods :</h5>
        <div class="row">
            <div class="col-md-8 mt-2">
                <p class="" style="font-size: 16px;">Choose from a variety of secure options to complete your transaction with confidence</p>
            </div>
            <div class="col-md-4 ">

                <button type="button" class="btn btn-warning float-end text-light" data-bs-toggle="modal" data-bs-target="#paymentModal3">
                    Pay Later
                </button>
                <button class="btn btn-warning text-end me-2 float-end text-light" id="showChooseMethod">Choose Method</button>
            </div>
        </div>
        <div class=" chooseMethod" style="display: none;">
            <hr>
            <div class="row">
                {{-- <div class="col-md-3 m-2 bg-info">

                        <label for="visa" class="visa">
                                <img src="https://designmodo.com/demo/checkout-panel/img/visa_logo.png" />
                                <img src="https://designmodo.com/demo/checkout-panel/img/mastercard_logo.png" />
                            <div class="radio-input">
                                <input id="card" type="radio" value="visa" name="payment_method">
                            </div>
                        </label>
                    </div>
                    <div class="col-md-3 m-2 bg-info">

                        <label for="paypal" class="paypal">
                            <img src="https://designmodo.com/demo/checkout-panel/img/paypal_logo.png" />
                            <div class="radio-input">
                                <input id="paypal" type="radio" value="paypal" name="payment_method" style="">
                            </div>
                        </label>
                    </div> --}}
                <div class="payment-method col-md-6">
                    <label for="card" class="method card" data-bs-toggle="modal" data-bs-target="#verticalycentered" id="payNowButton">
                        <div class="card-logos">
                            <img src="https://designmodo.com/demo/checkout-panel/img/visa_logo.png" />
                            <img src="https://designmodo.com/demo/checkout-panel/img/mastercard_logo.png" />
                        </div>

                        <div class="radio-input">
                            <input id="card" type="radio" value="Credit Card" name="payment_method">
                            Pay with credit card
                        </div>
                    </label>

                    <label for="paypal" class="method paypal" data-bs-toggle="modal" data-bs-target="#verticalycentered" id="payNowButton">
                        <img src="https://designmodo.com/demo/checkout-panel/img/paypal_logo.png" />
                        <div class="radio-input">
                            <input id="paypal" type="radio" value="paypal" name="payment_method">
                            Pay with PayPal
                        </div>
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="buttons float-end">

                        {{-- <button type="button" class="btn btn-warning text-end" data-bs-toggle="modal" data-bs-target="#verticalycentered" id="payNowButton">
                            Pay Now
                        </button> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="verticalycentered" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {{-- <header class="header">
                                <p><strong>Selected Price:</strong> <span id="selectedAddonPriceDisplay"></span></p>
                            <div class="card-type d-flex">
                                <a href="" class="card active"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/Amex.png' alt="" /></a>
                                <a href="" class="card"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/Discover.png' alt="" /></a>
                                <a href="" class="card"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/Visa.png' alt="" /></a>
                                <a href="" class="card"><img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/MC.png' alt="" /></a>
                            </div>
                            </header> --}}
                <div class="content">
                    <div class="container p-0">
                        <div class="card px-4">
                            <p class="h2 py-3">Payment Details</p>
                            <div class="row gx-3">
                                <div class="col-12">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">Person Name</p>
                                        <input class="form-control mb-3" name="holderName" type="text" placeholder="Name" value="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">Card Number</p>
                                        <input class="form-control mb-3" name="card_number" type="number" maxlength="16" placeholder="1234 5678 435678">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">Expiry</p>
                                        <input class="form-control mb-3" name="cardExpiryDate" type="date" placeholder="MM/YYYY">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">CVV/CVC</p>
                                        <input class="form-control mb-3 pt-2 " name="cvvcvc" type="password" placeholder="***">
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{-- <div class="btn btn-primary mb-3"> --}}
                                    <div class="col-md-12 text-center">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">
                                            <span class="dynamic-message">Your message has been sent. Thank you!</span>
                                        </div>

                                    </div>
                                    <button class="btn bg-primary" id="paymentStatus" class="ps-3">Pay <span id="selectedAddonPriceDisplay"></span> <span class="fas fa-arrow-right"></span></button>

                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="verticalycentered" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <header class="header">
                                <h1>Comfirm Payment</h1>
                                <h4 id="modalHeading"></h4>
                                <p><strong>Selected Price:</strong> <span id="selectedAddonPriceDisplay"></span></p>
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
                            <footer class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="paymentStatus">Complete Payment</button>
                            </footer>
                        </div>
                    </div>
                </div> --}}

    <div class="modal fade" id="paymentModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLabel">Comfirm Payment Later</h5>
                    {{-- <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close"> --}}
                    {{-- <span aria-hidden="true">&times;</span> --}}
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        Thank you for choosing the 'Pay Later' option. You have grace period to complete your payment. Please ensure payment is made within this timeframe to avoid any potential issues. If you have any questions or need assistance, feel free to reach out to our support team.
                    </div>
                </div>
                <footer class="modal-footer">
                    <div class="col-md-12 text-center">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">
                            <span class="dynamic-message">Your message has been sent. Thank you!</span>
                        </div>

                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="" class="btn btn-warning text-light" id="cancelPayment">Comfirm Later Payment</button>
                </footer>
            </div>
        </div>
    </div>
    </form>


    <div class="mt-4 bg-white p-3" id="kitaction" style="">
        {{-- <h4>Selected Payment</h4> --}}
        <h5>Activate by kit</h5>
        <div class="row">
            <div class="col-md-9 mt-2">
                <p class="" style="font-size: 16px;">Scratch your key kit and enter your key code</p>
            </div>
            <div class="col-md-3">
                <button class="btn btn-warning text-end float-end text-light" id="openkitform">Enter your Code</button>
            </div>
        </div>
        <div class="row kitform" style="display: none;height:100px">
            {{-- <hr> --}}

            <form action="/api/user/activate" method="POST" class="php-email-form">
                @csrf
                <div class="mb-3">
                    {{-- <label for="Username">Enter kit Code<span class="text-danger">*</span></label> --}}
                    <input type="text" name="kit" required class="form-control" id="kit" placeholder="Enter Kit Code">
                </div>
                <div class="col-md-12 text-center">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">
                        <span class="dynamic-message">Your message has been sent. Thank you!</span>
                    </div>

                </div>
                <button type="submit" class="btn btn-success m-2 col-md-2 ">Acivate</button>

            </form>
        </div>
    </div>
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
    {{-- <div class="grid grid--plans">
    <section class="card tier1">
        <header>
            <h3 class="badge">Starter</h3>
            <p class="bold-price">$400
                <small>/month</small>
            </p>
            <p>Great to start and to solve first issues on any kind of project!</p>
        </header>
        <ul>
            <li>Accessibility Statement creation</li>
            <li>Monthly call to align and discuss</li>
            <li>Basic Instant Fixes: 10 out of 50</li>
            <li>Private Dashboard</li>
            <li>Email for Support</li>
        </ul>
        <footer>
            <p>
                <a href="https://app.netlify.com/signup" class="button">Get started</a>
            </p>
        </footer>
    </section>
    <section class="card tier2">
        <header>
            <h3 class="badge">Pro</h3>
            <p class="bold-price">$700
                <small>/month</small>
            </p>
            <p>Get examples and more calls! Starter features plus...</p>
        </header>
        <ul>
            <li>Library of Accessible Components</li>
            <li>Weekly call to align and discuss</li>
            <li>Complete Instant Fixes: 50 out of 50</li>
            <li>Multiple roles</li>
            <li>Slack private chat for Support</li>
        </ul>
        <footer>
            <p>
                <a href="https://app.netlify.com/signup" class="button">Get started</a>
            </p>
        </footer>
    </section>
    <section class="card tier3">
        <header>
            <h3 class="badge">Business</h3>
            <p class="bold-price">$900+
                <small>/month</small>
            </p>
            <p>Custom solution designed for the needs of your company. Pro features plus...</p>
        </header>
        <ul>
            <li>Dedicated Server for testing</li>
            <li>24x7x365 premium support options</li>
            <li>Custom high-performance components</li>
            <li>Enterprise pipeline integration</li>
            <li>No Branding</li>
        </ul>
        <footer>
            <p>
                <a href="/enterprise" class="button">Contact sales</a>
            </p>
        </footer>
    </section>
</div> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const categoryId = document.getElementById('categoryId');

            if (categorySelect && categoryId) {
                categorySelect.addEventListener('change', function() {
                    const selectedCategoryId = categorySelect.value;
                    categoryId.textContent = 'Category ID: ' + selectedCategoryId;
                });
            }
        });

    </script> --}}
    <!-- Include the Select2 CSS -->


    <script>
        function selectCard(element) {
            // Remove the border from all cards
            event.preventDefault();

            var cards = document.querySelectorAll('.paymentcard');
            cards.forEach(function(card) {
                card.classList.remove('card-selected');
            });

            // Add border to the selected card
            var selectedCard = element.parentNode.querySelector('.paymentcard');
            selectedCard.classList.add('card-selected');
            console.log(selectedCard.value);
        }

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var clickButton = document.getElementById("openkitform");
            var kitForm = document.querySelector(".kitform");

            clickButton.addEventListener("click", function() {
                event.preventDefault();
                kitForm.style.display = kitForm.style.display === "none" ? "block" : "none";
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            var seeSomeAddons = document.getElementById("seeSomeAddons");
            var afteraddons = document.querySelector(".afteraddons");
            seeSomeAddons.addEventListener("click", function() {
                event.preventDefault();
                afteraddons.style.display = afteraddons.style.display === "none" ? "block" : "none";
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var showChooseMethod = document.getElementById("showChooseMethod");
            var chooseMethod = document.querySelector(".chooseMethod");
            showChooseMethod.addEventListener("click", function() {
                event.preventDefault();
                chooseMethod.style.display = chooseMethod.style.display === "none" ? "block" : "none";
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const planSelect = document.getElementById('plan');
            
            const description1 = document.getElementById('description1');
            const description2 = document.getElementById('description2');
            const description3 = document.getElementById('description3');
            const description4 = document.getElementById('description4');
            const beforePlans = document.querySelector('.beforeplans');

            if (categorySelect && planSelect) {
                categorySelect.addEventListener('change', function() {
                    const selectedCategoryId = categorySelect.value;
                    // Clear existing options in the "Plan" select
                    planSelect.innerHTML = '<option value="null">SELECT</option>';

                    // Filter pricings based on the selected category categories
                    const pricingsForCategory = @json($pricings);
                    const categories = @json($categories);
                    categories.forEach(function(price) {
                        if (price.id == selectedCategoryId) {
                            description1.innerHTML = "<i class='fa-solid fa-check text-success me-2'></i>" + price.description;
                            description2.innerHTML = "<i class='fa-solid fa-check text-success me-2'></i>" + price.description2;
                            description3.innerHTML = "<i class='fa-solid fa-check text-success me-2'></i>" + price.description3;
                            description4.innerHTML = "<i class='fa-solid fa-check text-success me-2'></i>" + price.description4;
                        }
                    });
                    // Populate the "Plan" select with the filtered pricings
                    pricingsForCategory.forEach(function(price) {
                        if (price.id == selectedCategoryId) {
                            const option = document.createElement('option');
                            option.value = price.validityId;
                            option.setAttribute('data-price', price.price);
                            option.textContent = price.name;
                            // console.log(price.name)

                            planSelect.appendChild(option);
                        }
                    });
                    beforePlans.style.display = 'none';
                    
                });
            }
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const plan = document.getElementById('plan');
            const duration = document.getElementById('duration');
            const beforePlans = document.querySelector('.beforeplans');

            if (plan && duration) {
                plan.addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var selectedPrice = selectedOption.getAttribute('data-price');

                    const selectedCategoryId = plan.value;

                    document.getElementById('planAmount').textContent = "INR " + selectedPrice;
                    // Clear existing options in the "Plan" select
                    duration.innerHTML = '<option value="null">SELECT</option>';

                    // Filter pricings based on the selected category
                    const validities = @json($validities);
                    // Populate the "Plan" select with the filtered pricings
                    validities.forEach(function(price) {
                        if (price.planId == selectedCategoryId) {
                            const option = document.createElement('option');
                            option.value = price.planId;
                            option.setAttribute('data-price', price.amount);
                            option.textContent = price.duration + price.durationType;
                            console.log(price.name)

                            duration.appendChild(option);
                        }
                    });
                    beforePlans.style.display = 'block';


                });
            }
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const duration = document.getElementById('duration');
            const addons = document.getElementById('addons');
           

            if (duration && addons) {
                
                duration.addEventListener('change', function() {
                    const selectedCategoryId = duration.value;
                    // Clear existing options in the "Plan" select
                    addons.innerHTML = '<option value="null">SELECT</option>';

                    // Filter pricings based on the selected category
                    const validities = @json($addons);
                    // Populate the "Plan" select with the filtered pricings
                    validities.forEach(function(price) {
                        if (price.id == selectedCategoryId) {
                            const option = document.createElement('option');
                            option.value = price.id;
                            option.setAttribute('data-price', price.price);
                            option.textContent = price.name;
                            // console.log(price.name)
                            addons.appendChild(option);
                        }
                    });
                });
            }
        });

    </script>

    <script>
        document.getElementById("paymentStatus").addEventListener("click", function() {
            // Handle "OK" button click
            document.getElementById("paymentStatusField").value = "paid";
        });

        document.getElementById("cancelPayment").addEventListener("click", function() {
            // Handle "Cancel" button click
            document.getElementById("paymentStatusField").value = "pending";
        });

    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const planSelect = document.querySelector('select[name="plan"]');
            const addonSelect = document.querySelector('select[name="addons"]');
            const selectedAddonPriceDisplay = document.getElementById('selectedAddonPriceDisplay');
            let addonPriceSelected = false;
            if (addonSelect) {
                addonSelect.addEventListener('change', function() {
                    const selectedOption = addonSelect.options[addonSelect.selectedIndex];
                    const selectedPrice = selectedOption.getAttribute('data-price');

                    if (selectedPrice) {
                        selectedAddonPriceDisplay.textContent = 'INR ' + selectedPrice;
                        addonPriceSelected = true;
                    } else {
                        addonPriceSelected = false;
                    }

                    updatePlanPrice();
                });
            }

            if (planSelect) {
                planSelect.addEventListener('change', function() {
                    updatePlanPrice();
                });
            }

            function updatePlanPrice() {
                if (!addonPriceSelected && planSelect) {
                    const selectedOption = planSelect.options[planSelect.selectedIndex];
                    const selectedPrice = selectedOption.getAttribute('data-price');

                    if (selectedPrice) {
                        selectedAddonPriceDisplay.textContent = 'INR ' + selectedPrice;
                    }
                }
            }
        });

    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const planSelect = document.querySelector('select[name="plan"]');
            const addonSelect = document.querySelector('select[name="addons"]');
            const selectedAddonPriceDisplay = document.getElementById('selectedAddonPriceDisplay');
            const paymentStatusButton = document.getElementById('paymentStatus');
            const selectedAmount = document.getElementById('selectedAmount');
            const addonsName = document.getElementById('addonsName');
            const addonsAmount = document.getElementById('addonsAmount');
            const description1 = document.getElementById('addonsdescription1');
            const description2 = document.getElementById('addonsdescription2');
            const afteraddons = document.querySelector('.afteraddons');
            const afterselectedAmount = document.querySelector('.afterselectedAmount');

            let addonPriceSelected = false;

            if (addonSelect) {
                addonSelect.addEventListener('change', function() {
                    const selectedOption = addonSelect.options[addonSelect.selectedIndex];
                    const selectedPrice = selectedOption.getAttribute('data-price');
                    var selectedAddonsName = selectedOption.textContent;
                    console.log('datasdjbkj', selectedPrice);

                    if (selectedPrice) {
                        addonsName.textContent = selectedAddonsName;
                        const addons = @json($addons);
                        addons.forEach(function(price) {
                            if (price.id == addonSelect.value) {
                                description1.innerHTML = "<i class='fa-solid fa-check text-success me-2'></i>" + ' ' + price.description;
                                description2.innerHTML = "<i class='fa-solid fa-check text-success me-2'></i>" + ' ' + price.description2;
                            }
                        });
                        addonsAmount.textContent = 'INR' + ' ' + selectedPrice;
                        selectedAddonPriceDisplay.textContent = 'INR ' + ' ' + selectedPrice;
                        addonPriceSelected = parseFloat(selectedPrice);
                        // afteraddons.style.display = 'block';
                        // afteraddons
                    } else {
                        selectedAddonPriceDisplay.textContent = '';
                        addonPriceSelected = false;
                        addonsName.textContent = 'Not Selected';
                        description1.innerHTML = '';
                        description2.innerHTML='';

                    }

                    updateTotalPrice();
                });
            }

            if (planSelect) {
                planSelect.addEventListener('change', function() {
                    updateTotalPrice();
                });
            }

            function updateTotalPrice() {
                let totalPrice = 0;

                if (addonPriceSelected) {
                    totalPrice += addonPriceSelected;
                }

                if (planSelect) {
                    const selectedPlanOption = planSelect.options[planSelect.selectedIndex];
                    const selectedPlanPrice = selectedPlanOption.getAttribute('data-price');

                    if (selectedPlanPrice) {
                        totalPrice += parseFloat(selectedPlanPrice);
                    }
                }

                // Update the total price display here if needed
                // Example: document.getElementById('totalPriceDisplay').textContent = 'INR ' + totalPrice;

                // Update the payment status button text
                if (paymentStatusButton) {
                    paymentStatusButton.textContent = 'Pay INR ' + totalPrice + ' ' + 'Pay' + ' ' + '→';
                    selectedAmount.textContent = 'Total Price :' + 'INR ' + totalPrice;
                    afterselectedAmount.style.display = 'block';
                }
            }
        });

    </script>

</main>




@endsection
