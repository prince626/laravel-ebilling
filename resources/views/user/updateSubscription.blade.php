@extends ('master')
@section('content')
<main id="main" class="main">
    
    @if($software && $categories && $pricings && $validities && $subscription &&$addons )

    <div class="container-fluid">
        <h1 class="text-center">Update Plan What suits you best ?</h1>
        <p class="text-center">There different plan for users pick the right on for you.</p>

        <form action='/api/user/update_subs/{{ $subscription->subs_id }}' method="POST" class="php-email-form">
            @csrf
            <div class="container-fluid m-auto justify-content-center select_subscription">
                {{-- <div class="bg-white mx-1 p-3">
                    <h4 class="font-bold">Select Software</h4>
                    <select class=" form-select" name="software" required aria-label="Default select example">
                        <option value="">Select</option>

                        @foreach ($software as $software)
                        <option value="{{ $software->name }}"> {{ $software->name }} </option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="bg-white row mt-4 mx-1 bg-light p-3">
                    <div class="col-md-4">
                        <h4>Select Businesss Category</h4>
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
                    <h4>Select Your Plan</h4>
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
            </div>
    </div> --}}
    <div class="col-md-4">
        <div class="row">
            <h4>Duration</h4>
            <select class="form-select" id="duration" name="duration" required aria-label="Default select example" required>
                <option value="null">SELECT</option>
            </select>
        </div>
    </div>
    </div>
    <div class="row mt-4 bg-white  mx-1 bg-light p-3">
        <div class="col-md-2">
            <h4 id="categoryId">Addons</h4>
        </div>
        {{-- <div class="col-md-11">
                    <select class="form-select" name="addons" aria-label="Default select example" required>
                        <option name="addons" value="null">SELECT</option>
                        @foreach ($addons as $addon)
                        <option name="addons" value="{{ $addon->id }}" data-price="{{ $addon->price }}">INR {{ $addon->name }} </option>
        @endforeach
        </select>
        </div> --}}
        <div class="col-md-7 ps-4">
            <select class="form-select" id="addons" name="addons" aria-label="Default select example" required>
                <option value="null">SELECT</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <p class="">See Some Addons  </p>
        </div>

    </div>
    <div class="chooseplan bg-white mt-4 mx-1 mb-3  p-3">
        <div class=" beforeplans" style="display: none;" >
            <h4 class="text-bold">Selected Plan</h4>
                <p>Enjoy plan with the following features and benefits</p>
            <div class="row">
            <div class="col-md-10">
                <p class=""><span id="description1" class="m-2"></span ><span id="description2" class="m-2"></span><span id="description3" class="m-2"></span><span id="description4" class="m-2"></span></p>
            </div>
            <div class="col-md-2">
                <p class="btn btn-warning text-end float-end" id="planAmount"></p>
            </div>
            <hr>

        </div>
        </div>
        <div class="afteraddons" style="display: none;" >
            <h4>Selected Addons</h4>
            <p>Addons : <strong id="addonsName"></strong></p>
            <div class="row">
                <div class="col-md-10">
            <p class=""><span id="addonsdescription1" class="m-2"></span ><span id="addonsdescription2" class="m-2"></span></p>
            </div>
                <div class="col-md-2">
                    < class="btn btn-warning text-end float-end" id="addonsAmount"></p>
                </div>
            </div>
            <hr>

        </div>
        <div class="afterselectedAmount" style="" >
            {{-- <h4>Selected Payment</h4> --}}
            <strong>Total :-</strong>
            <div class="row ms-1 mt-3" >
                <div class="form-check  col-md-9 ">
                    <input class="form-check-input" required name="accept" required type="checkbox" value="accept" id="flexCheckDefault" required>
                    <label class="form-check-label" for="flexCheckDefault">
                        Accept terms and Condition
                    </label>
                </div>
                <div class="col-md-3">
                    <p class="btn btn-warning text-end float-end text-light" id="afterselectedAmounted" >INR</p>
                </div>
            </div> 

        </div>
        
    </div>
    <input type="hidden" name="paymentStatus" id="paymentStatusField">
    {{-- <input type="hidden" name="paymentStatus" value="pending" id="paymentStatusField"> --}}


   
    <div class="bg-white p-3 mx-1 mt-5" style="" >
        {{-- <h4>Selected Payment</h4> --}}
        <strong>Payment Methods :</strong>
        <div class="row">
            <div class="col-md-9 mt-2">
                <p class="">Choose from a variety of secure options to complete your transaction with confidence</p>
            </div>
            <div class="col-md-3">
                <button class="btn btn-warning text-end float-end text-light" id="showChooseMethod">Pay Now</button>
            </div>
        </div> 
    <div class=" chooseMethod" style="display: none;">
        <hr>

        <div class="row">
            <div class="payment-method col-md-6">
                <label for="card" class="method card payNowButton" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                    <div class="card-logos">
                        <img src="https://designmodo.com/demo/checkout-panel/img/visa_logo.png" />
                        <img src="https://designmodo.com/demo/checkout-panel/img/mastercard_logo.png" />
                    </div>

                    <div class="radio-input">
                        <input id="card" type="radio" value="creditCard" name="payment_method">
                        Pay with credit card
                    </div>
                </label>

                <label for="paypal" class="method paypal payNowButton" data-bs-toggle="modal" data-bs-target="#verticalycentered" id="">
                    <img src="https://designmodo.com/demo/checkout-panel/img/paypal_logo.png" />
                    <div class="radio-input">
                        <input id="paypal" type="radio" value="paypal" name="payment_method">
                        Pay with PayPal
                    </div>
                </label>
            </div>
            {{-- <div class="col-md-6">
                <button type="button" class="btn btn-warning text-end float-end payNowButton" data-bs-toggle="modal" data-bs-target="#verticalycentered" id="">
                    Pay Now
                </button>
            </div> --}}
        </div>
    </div>
    </div>
    
    <div class="modal fade" id="verticalycentered" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="content">
                    <div class="container p-0">
                        <div class="card px-4">
                            <p class="h2 py-3">Payment Details</p>
                            <div class="box" >
                            <p class="h6 py-3" id="showselected">Selected Amount : <span id="selectedAmount"></span></p>
                            <p class="h6 py-3" id="showrefund">Refund Amount : <span id="refundAmount"></span></p>
                            <p class="h6 py-3" id="showtotal">Total Amount : <span id="totalAmount"></span></p>
                            </div>
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
                                        <input type="date" class="form-control mb-3" name="cardExpiryDate" type="text" placeholder="MM/YYYY">
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
    </form>
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
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script>
        // function checkCategoryMatch() {
        //     var selectedCategory = document.querySelector("select[name='businessCategory']").value;
        //     var subscriptionCategory = "{{ $subscription->business_Category }}"; // Replace with the actual property name
        //     var subscriptionExpiryDate = "{{ $subscription->expiryDate }}"; // Replace with the actual property name
        //     var subscriptionStartDate = "{{ $subscription->startDate }}"; // Replace with the actual property name
        //     // var subscriptionExpiryDate = "2023-11-30";
        //     // var subscriptionStartDate = "2023-11-01";
        //     var subscriptionAmount = {
        //         {
        //             $subscription - > amount
        //         }
        //     }; // Remove quotes to make it a numeric value

        //     var now = new Date(); // Get the current date
        //     var subscriptionStartDate = new Date(subscriptionStartDate); // Convert the subscription start date to a Date object
        //     var subscriptionExpiryDate = new Date(subscriptionExpiryDate); // Convert the subscription expiry date to a Date object

        //     var numberOfDays = Math.floor((now - subscriptionStartDate) / (1000 * 60 * 60 * 24)); // Calculate the number of days
        //     var duration = Math.floor((subscriptionExpiryDate - now) / (1000 * 60 * 60 * 24)); // Calculate the duration in days
        //     var costPerDay = subscriptionAmount / duration; // Assuming 30 days in a month
        //     var refundAmount = Math.abs((numberOfDays * costPerDay) - subscriptionAmount);
        //     // var refundAmount = Math.abs((numberOfDays * costPerDay) - 900);
        //     const userRefundAmount = document.getElementById('userRefundAmount');
        //     const selectedAddonPriceDisplay = document.getElementById('selectedAddonPriceDisplay');
        //     const totalAmount = document.getElementById('totalAmount');

        //     const selectedOption = document.querySelector(`select[name='businessCategory'] option[value='${selectedCategory}']`);
        //     const selectedPrice = selectedOption.getAttribute('data-price');

        //     if (selectedPrice !== subscriptionCategory) {
        //         userRefundAmount.textContent = 'INR ' + parseFloat(refundAmount).toFixed(2);
        //         // userRefundAmount.textContent = 'INR ' + duration;

        //         // Plan and Addon Selection
        //         const planSelect = document.querySelector('select[name="plan"]');
        //         const addonSelect = document.querySelector('select[name="addons"]');
        //         let addonPriceSelected = false;

        //         if (addonSelect) {
        //             addonSelect.addEventListener('change', function() {
        //                 const selectedOption = addonSelect.options[addonSelect.selectedIndex];
        //                 const selectedPrice = selectedOption.getAttribute('data-price');

        //                 if (selectedPrice) {
        //                     totalAmount.textContent = 'INR ' + (parseFloat(selectedPrice) - parseFloat(refundAmount)).toFixed(2);
        //                     addonPriceSelected = true;
        //                 } else {
        //                     addonPriceSelected = false;
        //                 }

        //                 updatePlanPrice();
        //             });
        //         }

        //         if (planSelect) {
        //             planSelect.addEventListener('change', function() {
        //                 updatePlanPrice();
        //             });
        //         }

        //         function updatePlanPrice() {
        //             if (!addonPriceSelected && planSelect) {
        //                 const selectedOption = planSelect.options[planSelect.selectedIndex];
        //                 const selectedPrice = selectedOption.getAttribute('data-price');

        //                 if (selectedPrice) {
        //                     totalAmount.textContent = 'INR ' + (parseFloat(selectedPrice) - parseFloat(refundAmount)).toFixed(2);
        //                 }
        //             }
        //         }
        //     }
        // }

    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const payNowButtons = document.querySelectorAll('.payNowButton');
        const selectedAmountElement = document.getElementById('selectedAmount');
        const refundAmountElement = document.getElementById('refundAmount');
        const TotalAmount = document.getElementById('totalAmount');
        const showrefund = document.getElementById('showrefund');
        const showtotal = document.getElementById('showtotal');

        // Event listener for the "Pay Now" button
        payNowButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Get the values from the <p> elements
            const selectedAmountValue = selectedAmountElement.textContent;
            const refundAmountValue = refundAmountElement.textContent;

            // Log or use the values as needed
            console.log('Selected Amount:', selectedAmountValue);
            console.log('Refund Amount:', refundAmountValue);

            if (refundAmountValue > 0) {
                console.log('Total', selectedAmountValue - refundAmountValue);
                TotalAmount.textContent = selectedAmountValue - refundAmountValue;
            } else {
                // showtotal.style.display = 'none';
            }
        });
    });
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
            // if (addonSelect) {
            //     addonSelect.addEventListener('change', function() {
            //         const selectedOption = addonSelect.options[addonSelect.selectedIndex];
            //         const selectedPrice = selectedOption.getAttribute('data-price');

            //         if (selectedPrice) {
            //             selectedAddonPriceDisplay.textContent = 'INR ' + selectedPrice;
            //             addonPriceSelected = true;
            //         } else {
            //             addonPriceSelected = false;
            //         }

            //         updatePlanPrice();
            //     });
            // }

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
            const selectedAddonPriceDisplay = document.getElementById('selectedAddonPriceDisplay');
            const description1 = document.getElementById('description1');
            const description2 = document.getElementById('description2');
            const description3 = document.getElementById('description3');
            const description4 = document.getElementById('description4');

            if (categorySelect && planSelect) {
                categorySelect.addEventListener('change', function() {
                    const selectedCategoryId = categorySelect.value;
                    // Clear existing options in the "Plan" select
                    planSelect.innerHTML = '<option value="null">SELECT</option>';
                    // Filter pricings based on the selected category
                    const pricingsForCategory = @json($pricings);
                    const categories = @json($categories);
                    categories.forEach(function(price) {
                        if (price.id == selectedCategoryId) {
                          description1.innerHTML="<i class='fa-solid fa-check text-success me-2'></i>" +  price.description;
                          description2.innerHTML="<i class='fa-solid fa-check text-success me-2'></i>" + price.description2;
                          description3.innerHTML="<i class='fa-solid fa-check text-success me-2'></i>" + price.description3;
                          description4.innerHTML="<i class='fa-solid fa-check text-success me-2'></i>" + price.description4;
                        }
                    });
                    // Populate the "Plan" select with the filtered pricings
                    pricingsForCategory.forEach(function(price) {
                        if (price.id == selectedCategoryId) {
                            const option = document.createElement('option');
                            option.value = price.validityId;
                            option.setAttribute('data-price', price.price);
                            option.textContent = price.name;
                            planSelect.appendChild(option);
                        }
                    });
                    selectedAddonPriceDisplay.textContent=null;
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
                    // Clear existing options in the "Plan" select
                    document.getElementById('planAmount').textContent = "INR " + selectedPrice;

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

                            addons.appendChild(option);
                        }
                    });
                });
            }
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const planSelect = document.querySelector('select[name="plan"]');
            const addonSelect = document.querySelector('select[name="addons"]');
            const selectedAddonPriceDisplay = document.getElementById('selectedAddonPriceDisplay');
            const selectedAmount = document.getElementById('selectedAmount');
            const paymentStatusButton = document.getElementById('paymentStatus');
            const addonsName = document.getElementById('addonsName');
            const addonsAmount = document.getElementById('addonsAmount');
            const description1 = document.getElementById('addonsdescription1');
            const description2 = document.getElementById('addonsdescription2');
            const afteraddons = document.querySelector('.afteraddons');
            const afterselectedAmount = document.querySelector('.afterselectedAmount');
            const afterselectedAmounted = document.getElementById('afterselectedAmounted');
            let addonPriceSelected = false;

            if (addonSelect) {
                addonSelect.addEventListener('change', function() {

                    const selectedOption = addonSelect.options[addonSelect.selectedIndex];
                    const selectedPrice = selectedOption.getAttribute('data-price');
                    var selectedAddonsName = selectedOption.textContent;

                    console.log('datasdjbkj',selectedPrice);

                    if (selectedPrice) {
                        addonsName.textContent = selectedAddonsName;
                        const addons = @json($addons);
                        addons.forEach(function(price) {
                        if (price.id == addonSelect.value) {
                          description1.innerHTML="<i class='fa-solid fa-check text-success me-2'></i>" + ' ' +  price.description;
                          description2.innerHTML="<i class='fa-solid fa-check text-success me-2'></i>" +' ' + price.description2;
                          
                        }
                        });
                        addonsAmount.textContent ='INR' +' ' + selectedPrice;
                        selectedAddonPriceDisplay.textContent = 'INR ' + ' ' + selectedPrice;
                        addonPriceSelected = parseFloat(selectedPrice);
                        console.log('datasdjbkj')
                        afteraddons.style.display = 'block';
                    } else {
                        selectedAddonPriceDisplay.textContent = '';
                        addonPriceSelected = false;
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
                    selectedAmount.textContent=totalPrice;
                    paymentStatusButton.textContent = 'Pay INR ' + totalPrice + ' ' + ' ' + '→';
                    afterselectedAmounted.textContent = 'Total Price :' + 'INR ' + totalPrice ;
                    afterselectedAmount.style.display='block';

                }
            }
        });

    </script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const planSelect = document.getElementById('plan');
        const durationSelect = document.getElementById('duration');
        const addonsSelect = document.getElementById('addons');

        // Function to check if the selected category matches the subscription category
        function checkCategoryMatch() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const selectedCategoryName = selectedOption.text; // Use textContent if needed
            const subscriptionCategory = @json($subscription->business_Category);

            if (selectedCategoryName !== subscriptionCategory) {
                console.log('subscriptionCategory Amount:', subscriptionCategory ,selectedCategoryName);
                // Category doesn't match, perform actions (e.g., display subscription details, create refund)
                displaySubscriptionDetails();
            } else {
                // Category matches, reset actions (e.g., hide subscription details)
                resetActions();
            }
        }

        // Function to display subscription details and potentially create a refund
        function displaySubscriptionDetails() {
            // Get subscription details (replace with actual data retrieval logic)
            const subscriptionAmount = @json($subscription->amount);
            const subscriptionExpiryDate = @json($subscription->expiryDate);

            // Display subscription details (replace with actual display logic)
           
            console.log('Subscription Amount:', subscriptionAmount);
            console.log('Subscription Expiry Date:', subscriptionExpiryDate);

            // Potential refund logic (replace with actual refund creation logic)
            createRefund();
        }

        // Function to reset actions when the category matches
        function resetActions() {
            // Reset actions (e.g., hide subscription details)
            console.log('Category matches, resetting actions.');
        }

        // Attach the checkCategoryMatch function to the change event of the category select
        if (categorySelect) {
            categorySelect.addEventListener('change', checkCategoryMatch);
        }
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const planSelect = document.getElementById('plan');
        const durationSelect = document.getElementById('duration');
        const addonsSelect = document.getElementById('addons');
        const getrefundAmount = document.getElementById('refundAmount');
        const showrefund = document.getElementById('showrefund');
        const showtotal = document.getElementById('showtotal');

        // Function to check if the selected category matches the subscription category
        function checkCategoryMatch() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const selectedCategoryName = selectedOption.text; // Use textContent if needed
            const subscriptionCategory = @json($subscription->business_Category);

            

            if (selectedCategoryName !== subscriptionCategory) {
                console.log('subscriptionCategory:', subscriptionCategory);
                console.log('selectedCategoryName:', selectedCategoryName);
                // Category doesn't match, perform actions (e.g., display subscription details, create refund)
                displaySubscriptionDetails();
            } else {
                showrefund.style.display = 'none';
                showtotal.style.display = 'none';
                // Category matches, reset actions (e.g., hide subscription details)
                // totalAmountElement.style.display = 'none';
                resetActions();
            }
        }

        // Function to display subscription details and potentially create a refund
        function displaySubscriptionDetails() {
            // Get subscription details (replace with actual data retrieval logic)
            // const subscriptionAmount = @json($subscription->amount);
            // const subscriptionExpiryDate = @json($subscription->expiryDate);
            // const subscriptionStartDate = @json($subscription->startDate);
            // const now = new Date();
            // const startDate = new Date(subscriptionStartDate);
            // const expiryDate = new Date(subscriptionExpiryDate);
            // const remainingDays = Math.ceil((expiryDate - now) / (1000 * 60 * 60 * 24));
            // const numberofDays = Math.ceil(( now-startDate ) / (1000 * 60 * 60 * 24));
            // var costPerDay=subscriptionAmount/remainingDays;
            // var refundAmount = Math.abs(  subscriptionAmount-(numberofDays * costPerDay));
            // getrefundAmount.textContent = refundAmount.toFixed(0);
            // showrefund.style.display = 'block';
            //     showtotal.style.display = 'block';
            // console.log('Refund Amount:', refundAmount);
            const subscriptionAmount = @json($subscription->amount);
const subscriptionExpiryDate = @json($subscription->expiryDate);
const subscriptionStartDate = @json($subscription->startDate);

const now = new Date();
const startDate = new Date(subscriptionStartDate);
const expiryDate = new Date(subscriptionExpiryDate);

const oneDay = 24 * 60 * 60 * 1000; // Number of milliseconds in a day

const remainingDays = Math.ceil((expiryDate - now) / oneDay);
const numberOfDays = Math.ceil((startDate-now ) / oneDay);

// Ensure that remainingDays and numberOfDays are not negative
const validRemainingDays = Math.max(remainingDays, 0);
const validNumberOfDays = Math.max(numberOfDays, 0);

const costPerDay = subscriptionAmount / validRemainingDays;
const refundAmount = Math.abs(subscriptionAmount - validNumberOfDays * costPerDay);

getrefundAmount.textContent = refundAmount.toFixed(0);
showrefund.style.display = 'block';
showtotal.style.display = 'block';

console.log('Refund Amount:', refundAmount);

        }
        // Function to reset actions when the category matches
        function resetActions() {
            // Reset actions (e.g., hide subscription details)
            getrefundAmount.textContent = 0;

            console.log('Category matches, resetting actions.');
        }

        // Attach the checkCategoryMatch function to the change event of the category select
        if (categorySelect) {
            categorySelect.addEventListener('change', checkCategoryMatch);
        }
    });
</script>

</main>
@endsection
