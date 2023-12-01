@extends('master')

@section('content')
<main id="main" class="main">
    <style>
        .text-danger strong {
            color: #9f181c;
        }

        .receipt-main {
            background: #ffffff none repeat scroll 0 0;
            border-bottom: 12px solid #333333;
            border-top: 12px solid hsl(358, 74%, 36%);
            /* margin-top: 50px; */
            margin-bottom: 50px;
            padding: 40px 30px !important;
            position: relative;
            box-shadow: 0 1px 21px #acacac;
            color: #333333;
            font-family: open sans;
        }

        .receipt-main p {
            color: #333333;
            font-family: open sans;
            line-height: 1.42857;
        }

        .receipt-footer h1 {
            font-size: 15px;
            font-weight: 400 !important;
            margin: 0 !important;
        }

        .receipt-main::after {
            background: #414143 none repeat scroll 0 0;
            content: "";
            height: 5px;
            left: 0;
            position: absolute;
            right: 0;
            top: -13px;
        }

        .receipt-main thead {
            background: #414143 none repeat scroll 0 0;
        }

        .receipt-main thead th {
            /* color:#fff; */
        }

        .receipt-right h5 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 7px 0;
        }

        .receipt-right p {
            font-size: 12px;
            margin: 0px;
        }

        .receipt-right p i {
            text-align: center;
            width: 18px;
        }

        .receipt-main td {
            padding: 9px 20px !important;
        }

        .receipt-main th {
            padding: 13px 20px !important;
        }

        .receipt-main td {
            font-size: 13px;
            font-weight: initial !important;
        }

        .receipt-main td p:last-child {
            margin: 0;
            padding: 0;
        }

        .receipt-main td h2 {
            font-size: 20px;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
        }

        .receipt-header-mid .receipt-left h1 {
            font-weight: 100;
            margin: 34px 0 0;
            text-align: right;
            text-transform: uppercase;
        }

        .receipt-header-mid {
            margin: 24px 0;
            overflow: hidden;
        }

        #container {
            background-color: #dcdcdc;
        }

    </style>
    @if(!$invoiceReceipt || count($invoiceReceipt) === 0)

    <div class="container-fluid">
        <div class="container">

            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>302</h1>
                <h2>User Has no Receipt</h2>
                {{-- <a class="btn" href="index.html">Back to home</a> --}}
                <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">

            </section>

        </div>
        @else
        <h1>My Receipt</h1>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Receipt No</th>
                        {{-- <th scope="col">User ID</th> --}}
                        {{-- <th scope="col">Subscription ID</th> --}}
                        {{-- <th scope="col">Email</th> --}}
                        <th scope="col">Phone</th>
                        <th scope="col">Invoice Date</th>
                        <th scope="col">Due Date</th>
                        {{-- <th scope="col">Plan Info</th> --}}
                        <th scope="col">Paid Amount</th>
                        <th scope="col">PaymentStatus</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">View</th>
                        {{-- <th scope="col">Transaction Id</th> --}}
                        {{-- <th scope="col">Payment Date</th> --}}

                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoiceReceipt as $receipt)
                    <tr>
                        <td><strong>#{{ $receipt->receipt_no }}</strong></td>
                        {{-- <td>{{ $receipt->user_id }}</td> --}}
                        {{-- <td>{{ $receipt->subs_id }}</td> --}}
                        {{-- <td>{{ $receipt->email }}</td> --}}
                        <td>{{ $receipt->phone }}</td>
                        <td>{{ $receipt->invoice_date }}</td>
                        <td>{{ $receipt->due_date }}</td>
                        {{-- <td>{{ $receipt->planInfo }}</td> --}}
                        <td><strong>₹{{ $receipt->paid_amount }}</strong></td>
                        <td class="text-center">
                            @if ($receipt->paymentStatus === 'paid')
                            <p class="text-light bg-success text-center" style="
                            padding:4px;border-radius:8px;font-weight:bold;">Paid</p>
                            @else
                            <p class="text-light bg-danger text-center" style="
                            padding:4px;border-radius:8px;font-weight:bold;">Unpaid</p>
                                @endif
                        </td>
                        <td>{{ $receipt->payment_method }}</td>
                        <td>
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="invoice-dropdown dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $receipt->receipt_no }}"><i class="bi bi-eye-slash text-primary"></i><a href="/api/user/read_receipt/{{$receipt->user_id}}" class="readReceipt dropdown-item">Open</a></li>
                                    <li data-bs-toggle="modal" data-bs-target="#receiptModal{{ $receipt->receipt_no }}"><i class="bi bi-trash text-danger"></i><a class="dropdown-item" href="#">Delete</a></li>
                                    <li onclick="downloadReceiptData({{json_encode($receipt)}})"><i class="bi bi-cloud-arrow-down-fill text-primary"></i><a class="dropdown-item" href="#">Download</a></li>

                                </ul>
                            </div>
                            
                        </td>
                        {{-- <td>{{ $receipt->payment_id }}</td> --}}
                        {{-- <td>{{ $receipt->payment_date }}</td> --}}

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @foreach ($invoiceReceipt as $receipt)
        <div class="php-email-form modal fade" id="receiptModal{{ $receipt->receipt_no }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/api/user/delete_receipt/{{ $receipt->receipt_no }}" method="POST" class="php-email-form">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete receipt</h5>
                        </div>
                        <div class="modal-body">
                            <p class="text-center fw-bold">Are you sure want to delete your receipt "receipt-{{ $receipt->receipt_no }}" </p>
                            <div class="form-group">
                            </div>
                        </div>
                        <footer class="modal-footer">
                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">
                                    <span class="dynamic-message"></span>
                                </div>

                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>

                        </footer>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @foreach ($invoiceReceipt as $receipt)
    <div class="modal fade" id="exampleModal{{ $receipt->receipt_no }}" tabindex="-1" data-bs-backdrop="false">

        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: none !important;
            border: none;">
                <div class="container-fluid">
                    {{-- <div class="row"> --}}
                    <div class="col-md-12 col-xl-12 col-md-6  receipt-main">
                        <div class="row mb-3">
                            <div class="col-md-6 text-left">
                                <h3>My Receipt</h3>
                            </div>
                            <div class="col-md-6 text-right  text-end">
                                <button type="button" class="btn-close btn bg-danger" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 12px;"></button>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 text-left ">
                                <div class="receipt-right">
                                    <h5>Customer Details </h5>
                                    <p><b>Mobile :</b> {{$receipt->phone}}</p>
                                    <p><b>Email :</b> {{$receipt->email}}</p>
                                    {{-- <p><b>Address :</b> New York, USA</p> --}}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right receipt-header my-5">
                                <div class="text-end receipt-right">
                                    <h5>Company Name.</h5>
                                    <p>+1 3649-6589 <i class="fa fa-phone"></i></p>
                                    <p>company@gmail.com <i class="fa fa-envelope-o"></i></p>
                                    <p>USA <i class="fa fa-location-arrow"></i></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left receipt-header-mid">
                                <div class="receipt-right">
                                    <h5>Payment Details </h5>
                                    <p><b>Holder Name :</b> {{$receipt->holder_name}}</p>
                                    <p><b>Payment Method :</b> {{$receipt->payment_method}}</p>
                                    <p><b>Payment Id :</b> ****{{ substr($receipt->payment_id, -4) }}</p>
                                    {{-- <p><b>Address :</b> New York, USA</p> --}}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 receipt-header-mid">
                                <div class="receipt-left">
                                    <h3>Receipt No #{{$receipt->receipt_no}}</h3>
                                </div>
                            </div>
                        </div>

                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-9">{{$receipt->software}}</td>
                                        <td class="col-md-3"><i class="fa fa-inr"></i> {{$receipt->paid_amount}}</td>
                                    </tr>
                                    <tr>

                                        <td class="text-right">
                                            <h2><strong>Total: </strong></h2>
                                        </td>
                                        <td class="text-left text-danger">
                                            <h2><strong><i class="fa fa-inr"></i> {{$receipt->paid_amount}}</strong></h2>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left receipt-header-mid receipt-footer">
                                <div class="receipt-right">
                                    <p><b>Date :</b> {{$receipt->invoice_date}}</p>
                                    {{-- <h5 style="color: rgb(140, 140, 140);">Thanks for shopping.!</h5> --}}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 receipt-footer">
                                <div class="receipt-left">
                                    <strong>Devologix</strong>
                                </div>
                            </div>
                        </div>
                        {{-- <button class="btn bg-primary text-light m-2" onclick="downloadReceiptData({{json_encode($receipt)}})"><i class="bi bi-download mx-2 text-light"></i>Download Receipt</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endforeach

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script>
        function downloadReceiptData(sub) {
            // Get data from the modal
            // var receiptData = JSON.parse(sub);
            // var receiptData = sub;
            // console.log(receiptData)
            var htmlContent = `
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Receipt Data</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
                <style>
                .text-danger strong {
                color: #9f181c;
                }

                .receipt-main {
                    background: #ffffff none repeat scroll 0 0;
                    border-bottom: 12px solid #333333;
                    border-top: 12px solid hsl(358, 74%, 36%);
                    /* margin-top: 50px; */
                    margin-bottom: 50px;
                    padding: 40px 30px !important;
                    position: relative;
                    box-shadow: 0 1px 21px #acacac;
                    color: #333333;
                    font-family: open sans;
                }

                .receipt-main p {
                    color: #333333;
                    font-family: open sans;
                    line-height: 1.42857;
                }

                .receipt-footer h1 {
                    font-size: 15px;
                    font-weight: 400 !important;
                    margin: 0 !important;
                }

                .receipt-main::after {
                    background: #414143 none repeat scroll 0 0;
                    content: "";
                    height: 5px;
                    left: 0;
                    position: absolute;
                    right: 0;
                    top: -13px;
                }

                .receipt-main thead {
                    background: #414143 none repeat scroll 0 0;
                }

                .receipt-main thead th {
                    /* color:#fff; */
                }

                .receipt-right h5 {
                    font-size: 16px;
                    font-weight: bold;
                    margin: 0 0 7px 0;
                }

                .receipt-right p {
                    font-size: 12px;
                margin: 0px;
                }

                .receipt-right p i {
                    text-align: center;
                    width: 18px;
                }

                .receipt-main td {
                    padding: 9px 20px !important;
                }

                .receipt-main th {
                    padding: 13px 20px !important;
                }

                .receipt-main td {
                    font-size: 13px;
                    font-weight: initial !important;
                }

                .receipt-main td p:last-child {
                    margin: 0;
                    padding: 0;
                }

                .receipt-main td h2 {
                    font-size: 20px;
                    font-weight: 900;
                    margin: 0;
                    text-transform: uppercase;
                }

                .receipt-header-mid .receipt-left h1 {
                    font-weight: 100;
                    margin: 34px 0 0;
                    text-align: right;
                    text-transform: uppercase;
                }

                .receipt-header-mid {
                    margin: 24px 0;
                    overflow: hidden;
                }

                #container {
                    background-color: #dcdcdc;
                }
                </style>
            </head>
            <body>
            <div class="container receipt-main">
                        <div class="row mb-3">
                            <div class="col-md-6 text-left">
                                <h3>My Receipt</h3>
                            </div>
                            <div class="col-md-6 text-right  text-end">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 text-left ">
                                <div class="receipt-right">
                                    <h5>Customer Details </h5>
                                    <p><b>Mobile :</b> {{$receipt->phone}}</p>
                                    <p><b>Email :</b> {{$receipt->email}}</p>
                                    {{-- <p><b>Address :</b> New York, USA</p> --}}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right receipt-header">
                                <div class="text-end receipt-right">
                                    <h5>Company Name.</h5>
                                    <p>+1 3649-6589 <i class="fa fa-phone"></i></p>
                                    <p>company@gmail.com <i class="fa fa-envelope-o"></i></p>
                                    <p>USA <i class="fa fa-location-arrow"></i></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left receipt-header-mid">
                                <div class="receipt-right">
                                    <h5>Payment Details </h5>
                                    <p><b>Holder Name :</b> {{$receipt->holder_name}}</p>
                                    <p><b>Payment Method :</b> {{$receipt->payment_method}}</p>
                                    <p><b>Payment Id :</b> ****{{ substr($receipt->payment_id, -4) }}</p>
                                    {{-- <p><b>Address :</b> New York, USA</p> --}}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 receipt-header-mid">
                                <div class="receipt-left">
                                    <h3>Receipt No #{{$receipt->receipt_no}}</h3>
                                </div>
                            </div>
                        </div>

                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-9">{{$receipt->software}}</td>
                                        <td class="col-md-3"><i class="fa fa-inr"></i> {{$receipt->paid_amount}}</td>
                                    </tr>
                                    <tr>

                                        <td class="text-right">
                                            <h2><strong>Total: </strong></h2>
                                        </td>
                                        <td class="text-left text-danger">
                                            <h2><strong><i class="fa fa-inr"></i> {{$receipt->paid_amount}}</strong></h2>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left receipt-header-mid receipt-footer">
                                <div class="receipt-right">
                                    <p><b>Date :</b> {{$receipt->invoice_date}}</p>
                                    {{-- <h5 style="color: rgb(140, 140, 140);">Thanks for shopping.!</h5> --}}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 receipt-footer">
                                <div class="receipt-left">
                                    <h1>Devologix</h1>
                                </div>
                            </div>
                        </div>
                    </div> 
                </body>
            </html>`
            // var receiptData = {
            //     receiptNo: '{{$receipt->receipt_no}}'
            //     , phone: '{{$receipt->phone}}'
            //     , email: '{{$receipt->email}}'
            //     , companyName: 'Company Name'
            //     , companyPhone: '+1 3649-6589'
            //     , companyEmail: 'company@gmail.com'
            //     , companyLocation: 'USA'
            //     , holderName: '{{$receipt->holder_name}}'
            //     , paymentMethod: '{{$receipt->payment_method}}'
            //     , paymentId: '****' + '{{ substr($receipt->payment_id, -4) }}'
            //     , softwareDescription: '{{$receipt->software}}'
            //     , paidAmount: '{{$receipt->paid_amount}}'
            //     , invoiceDate: '{{$receipt->invoice_date}}'
            // , };

            // Convert data to JSON
            var blob = new Blob([htmlContent], {
                type: 'text/html'
            });
            var a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'receipt_data';

            // Append the link to the body and trigger the download
            document.body.appendChild(a);
            a.click();

            // Remove the link from the body
            document.body.removeChild(a);
        }

    </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var activateButtons = document.querySelectorAll('.readReceipt');
            activateButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default behavior of the link

                    fetch(this.href)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // window.location.reload();
                            } else {
                                // Handle non-successful response
                                showSnackbar(data.status, data.data);
                            }
                        })
                        .catch(error => {
                            showSnackbar('Fetch Error: ', error.message);
                        });
                });
            });

            function showSnackbar(status, data) {
                var snackBar = document.getElementById("snackbar");
                snackBar.className = "show-bar";
                snackBar.textContent = status + data;
                setTimeout(function() {
                    snackBar.className = snackBar.className.replace("show-bar", "");
                }, 5000);
            }
        });

    </script>

    @endsection
