@extends('master')

@section('content')
<main id="main" class="main">
    @if(!$invoices || count($invoices) === 0)
    <div class="container">

        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>302</h1>
            <h2>User Has no Invoices</h2>
            {{-- <a class="btn" href="index.html">Back to home</a> --}}
            <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">

        </section>

    </div>
    @else
    <style></style>
    <h1>My Invoices</h1>

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">


                            <div class="card-body">
                                <h5 class="card-title">Total <span>| Invoices</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ count($invoices) }}</h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title">Paid <span>| Invoices</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart" style="color: green;"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $invoices->where('paymentStatus', 'paid')->count() }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title"> Unpaid<span>| Invoices </span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal" style="color: red;"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $invoices->where('paymentStatus', 'pending')->count() }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title"> Total<span>| Pending Amount </span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-rupee text-danger"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>₹{{ $invoices->where('paymentStatus', 'pending')->sum('amount') }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="container-fluid">
        @if(!$invoices || count($invoices) === 0)
        <div class="container">

            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>302</h1>
                <h2>User Has no Invoices</h2>
                {{-- <a class="btn" href="index.html">Back to home</a> --}}
                <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">

            </section>

        </div>
        @else

        <div class="table-responsive">
            {{-- <table class="table datatable" id="dataTable" width="100%" cellspacing="0"> --}}

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Invoice Number</th>
                        {{-- <th scope="col">User ID</th> --}}
                        <th scope="col">Subscription ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        {{-- <th scope="col">Invoice Date</th> --}}
                        <th scope="col">Software</th>
                        <th scope="col"> Amount</th>
                        <th scope="col">PaymentStatus</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td><strong>#{{ $invoice->invoice_number }}</strong></td>
                        {{-- <td>#{{ $invoice->user_id }}</td> --}}
                        <td>#{{ $invoice->subs_id }}</td>
                        <td>{{ $invoice->email }}</td>
                        <td>{{ $invoice->phone }}</td>

                        {{-- <td>{{ $invoice->invoice_date }}</td> --}}
                        <td>{{ $invoice->software }}</td>
                        <td><strong>₹{{ $invoice->amount }}</strong></td>
                        <td class="text-center">
                            @if ($invoice->paymentStatus === 'paid')
                            <p class="text-light bg-success text-center" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Paid</p>
                            @elseif($invoice->paymentStatus === 'pending')
                            <p class="text-light bg-danger text-center" style="
                        padding:4px;border-radius:8px;font-weight:bold;">Unpaid</p>
                            @else
                            <strong class="text-danger">{{$invoice->paymentStatus}}</button>
                                @endif
                        </td>
                        <td>{{ $invoice->due_date }}</td>
                        {{-- <td><i class="fa-solid fa-trash-can text-danger m-1" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $invoice->invoice_number }}" style="cursor: pointer;font-size:25px;"></i>
                        </td> --}}
                        <td>
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="invoice-dropdown dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="" data-bs-toggle="modal" data-bs-target="#exampleView{{ $invoice->invoice_number }}"><i class="bi bi-eye-slash text-primary"></i><a class="dropdown-item" href="#">Open</a></li>
                                    <li data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $invoice->invoice_number }}"><i class="bi bi-trash text-danger"></i><a class="dropdown-item" href="#">Delete</a></li>
                                    <li onclick="downloadInvoiceData({{json_encode($invoice)}})"><i class="bi bi-cloud-arrow-down-fill text-primary"></i><a class="dropdown-item" href="#">Download</a></li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @foreach ($invoices as $invoice)
        <div class="php-email-form modal fade" id="invoiceModal{{ $invoice->invoice_number }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/api/user/cancel_invoice/{{ $invoice->invoice_number }}" method="POST" class="php-email-form">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Invoice</h5>
                        </div>
                        <div class="modal-body">
                            <p class="text-center fw-bold">Are you sure want to delete your Invoice "INV-{{ $invoice->invoice_number }}" </p>
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
        @foreach ($invoices as $invoice)
        <div class="modal fade" id="exampleView{{ $invoice->invoice_number }}" tabindex="-1" data-bs-backdrop="false">

            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background: none !important;
                border: none;">
                    <div class="container-fluid">
                        <div class="col-md-12 col-xl-12 col-md-6  receipt-main">
                            <div class="row mb-3">
                                <div class="col-md-6 text-left">
                                    <h3>My Invoice</h3>
                                </div>
                                <div class="col-md-6 text-right  text-end">
                                    <button type="button" class="btn-close btn bg-danger" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 12px;"></button>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 text-left  ">
                                    <div class="receipt-right">
                                        <h5>Customer Details </h5>
                                        <p><b>Mobile :</b> {{$invoice->phone}}</p>
                                        <p><b>Email :</b> {{$invoice->email}}</p>
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
                                <div class="col-xs-6 col-sm-6 col-md-6 text-left receipt-header-mid">
                                    <div class="receipt-right">
                                        <h5>Invoice Details </h5>
                                        <p><b>Invoice Date :</b> {{$invoice->invoice_date}}</p>
                                        <p><b>Due Date :</b> {{$invoice->due_date}}</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-5 col-md-6 receipt-header-mid">
                                    <div class="receipt-left">
                                        <h3>Invoice No #{{$invoice->invoice_number}}</h3>
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
                                            <td class="col-md-9">Software {{$invoice->software}} for {{$invoice->planInfo}}</td>
                                            <td class="col-md-3"><i class="fa fa-inr"></i> {{$invoice->paid_amount}}</td>
                                        </tr>
                                        <tr>

                                            <td class="text-right">
                                                <h2><strong>Total: </strong></h2>
                                            </td>
                                            <td class="text-left text-danger">
                                                <h2><strong><i class="fa fa-inr"></i> {{$invoice->paid_amount}}</strong></h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 text-left receipt-header-mid receipt-footer">
                                    <div class="receipt-right">
                                        <p><b>Date :</b> {{$invoice->invoice_date}}</p>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 receipt-footer">
                                    <div class="receipt-left">
                                        <strong>Devologix</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="invoice-title">
                                    <h2>Invoice</h2><h3 class="pull-right">Order # 12345</h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <address>
                                        <strong>Billed To:</strong><br>
                                            John Smith<br>
                                            1234 Main<br>
                                            Apt. 4B<br>
                                            Springfield, ST 54321
                                        </address>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <address>
                                        <strong>Shipped To:</strong><br>
                                            Jane Smith<br>
                                            1234 Main<br>
                                            Apt. 4B<br>
                                            Springfield, ST 54321
                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <address>
                                            <strong>Payment Method:</strong><br>
                                            Visa ending **** 4242<br>
                                            jsmith@email.com
                                        </address>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            March 7, 2014<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Item</strong></td>
                                                        <td class="text-center"><strong>Price</strong></td>
                                                        <td class="text-center"><strong>Quantity</strong></td>
                                                        <td class="text-right"><strong>Totals</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>BS-200</td>
                                                        <td class="text-center">$10.99</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-right">$10.99</td>
                                                    </tr>
                                                    <tr>
                                                        <td>BS-400</td>
                                                        <td class="text-center">$20.00</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-right">$60.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>BS-1000</td>
                                                        <td class="text-center">$600.00</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-right">$600.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                                        <td class="thick-line text-right">$670.99</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center"><strong>Shipping</strong></td>
                                                        <td class="no-line text-right">$15</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center"><strong>Total</strong></td>
                                                        <td class="no-line text-right">$685.99</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function downloadInvoiceData(sub) {
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
                                    <p><b>Mobile :</b> {{$invoice->phone}}</p>
                                    <p><b>Email :</b> {{$invoice->email}}</p>
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
                                    <p><b>Holder Name :</b> {{$invoice->holder_name}}</p>
                                    <p><b>Payment Method :</b> {{$invoice->payment_method}}</p>
                                    <p><b>Payment Id :</b> ****{{ substr($invoice->payment_id, -4) }}</p>
                                    {{-- <p><b>Address :</b> New York, USA</p> --}}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 receipt-header-mid">
                                <div class="receipt-left">
                                    <h3>Receipt No #{{$invoice->receipt_no}}</h3>
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
                                        <td class="col-md-9">{{$invoice->software}}</td>
                                        <td class="col-md-3"><i class="fa fa-inr"></i> {{$invoice->paid_amount}}</td>
                                    </tr>
                                    <tr>

                                        <td class="text-right">
                                            <h2><strong>Total: </strong></h2>
                                        </td>
                                        <td class="text-left text-danger">
                                            <h2><strong><i class="fa fa-inr"></i> {{$invoice->paid_amount}}</strong></h2>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left receipt-header-mid receipt-footer">
                                <div class="receipt-right">
                                    <p><b>Date :</b> {{$invoice->invoice_date}}</p>
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
            //     receiptNo: '{{$invoice->receipt_no}}'
            //     , phone: '{{$invoice->phone}}'
            //     , email: '{{$invoice->email}}'
            //     , companyName: 'Company Name'
            //     , companyPhone: '+1 3649-6589'
            //     , companyEmail: 'company@gmail.com'
            //     , companyLocation: 'USA'
            //     , holderName: '{{$invoice->holder_name}}'
            //     , paymentMethod: '{{$invoice->payment_method}}'
            //     , paymentId: '****' + '{{ substr($invoice->payment_id, -4) }}'
            //     , softwareDescription: '{{$invoice->software}}'
            //     , paidAmount: '{{$invoice->paid_amount}}'
            //     , invoiceDate: '{{$invoice->invoice_date}}'
            // , };

            // Convert data to JSON
            var blob = new Blob([htmlContent], {
                type: 'text/html'
            });
            var a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'My Invoice';

            // Append the link to the body and trigger the download
            document.body.appendChild(a);
            a.click();

            // Remove the link from the body
            document.body.removeChild(a);
        }

    </script>
    @endif

</main>
@endsection
