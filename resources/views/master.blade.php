<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>My Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="https://fonts.gstatic.com" rel="preconnect"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block text-light">Dashboard</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn text-light"></i>
        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        @if (isset($messageCount) && count($messageCount) > 0)
                        <span class="badge bg-danger badge-number">{{ count($messageCount) }}</span>
                        {{-- @else
                        <span class="badge badge-number"><i class="bi bi-dot" style="font-size: 20px;color:red;"></i></span> --}}

                        @endif
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        @if (isset($messageCount) && count($messageCount) > 0)
                        <li class="dropdown-header">
                            You have {{ count($messageCount) }} new notifications
                            <a href="/api/user/notifications"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @foreach ($messageCount as $message)
                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-{{ $message->type }}"></i>
                            <div>
                                <h4>{{ $message->email }}</h4>
                                <p>{{ $message->message }}</p>
                                <p>
                                    @php
                                    // Use a valid timestamp format (Y-m-d H:i:s) for Carbon::parse
                                    $createdAt = Carbon\Carbon::parse($message->created_at, 'Asia/Kolkata');
                                    $now = Carbon\Carbon::now('Asia/Kolkata');
                                    @endphp

                                    @if ($now->diffInMinutes($createdAt) >= 1440) {{-- 1440 minutes = 24 hours --}}
                                    {{ $createdAt->format('Y-m-d H:i:s') }} {{-- Display the full date and time --}}
                                    @elseif ($now->diffInMinutes($createdAt) >= 60) {{-- Check if the message is older than an hour --}}
                                    {{ $now->diffInHours($createdAt) }} Hours Ago {{-- Display hours --}}
                                    @elseif ($now->diffInMinutes($createdAt) >= 1)
                                    {{ $now->diffInMinutes($createdAt) }} Minutes Ago
                                    @else
                                    Just now
                                    @endif</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @endforeach


                        <li class="dropdown-footer">
                            <a href="/api/user/notifications">Show all notifications</a>
                        </li>
                        @else
                        <li class="dropdown-header">
                            You have no new notifications
                            <a href="/api/user/notifications"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>

                        </li>
                        @endif
                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->

                {{-- <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a><!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="{{asset('assets/img/messages-2.jpg')}}" alt="" class="rounded-circle">
                <div>
                    <h4>Anna Nelson</h4>
                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                    <p>6 hrs. ago</p>
                </div>
                </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li class="message-item">
                    <a href="#">
                        <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4>David Muldon</h4>
                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                            <p>8 hrs. ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li class="dropdown-footer">
                    <a href="#">Show all messages</a>
                </li>

            </ul><!-- End Messages Dropdown Items -->

            </li><!-- End Messages Nav --> --}}

            <li class="nav-item dropdown pe-3 me-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{-- <i class="fa-solid fa-user rounded-circle"></i> --}}
                    {{-- <img src=" {{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle"> --}}
                    <i class="bi bi-person-circle" style="font-size: 25px;"></i>
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{$user?ucwords($user->name):null}}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{$user?ucwords($user->name):null}} </h6>
                        <span>{{$user?$user->email:null}}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center text-dark" href="/api/user/profile">
                            <i class="bi bi-person text-dark"></i>
                            <span class="text-dark">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/api/user/profile">
                            <i class="bi bi-gear text-dark"></i>
                            <span class="text-dark">Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/api/user/ticket">
                            <i class="bi bi-question-circle text-dark"></i>
                            <span class="text-dark">Need Help?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/api/user/logout">
                            <i class="bi bi-box-arrow-right text-dark"></i>
                            <span class="text-dark">Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-heading">Main Menu</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/plans/viewPlans">
                    <i class="bi bi-flower2"></i>
                    <span>Choose Plan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/profile">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Subscription</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/api/user/subscription">
                            <i class="bi bi-circle"></i><span>User Subscriptions</span>
                        </a>
                    </li>
                    <li>
                        <a href="/api/user/subs_history">
                            <i class="bi bi-circle"></i><span>Subscription History</span>
                        </a>
                    </li>
                    <li>
                        <a href="/api/user/cancel_subs">
                            <i class="bi bi-circle"></i><span>Canceled Subscriptions</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="/api/user/recharge_invoices">
                            <i class="bi bi-circle"></i><span>Invoice</span>
                        </a>
                    </li> --}}
                    {{-- <li>
                        <a href="/api/user/invoices">
                            <i class="bi bi-circle"></i><span>Receipt</span>
                        </a>
                    </li> --}}

                    {{-- <li>
                        <a href="/api/user/bill/history">
                            <i class="bi bi-circle"></i><span>Bill History</span>
                        </a>
                    </li> --}}
                    {{-- <li>
                        <a href="components-carousel.html">
                            <i class="bi bi-circle"></i><span>Carousel</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-list-group.html">
                            <i class="bi bi-circle"></i><span>List group</span>
                        </a>
                    </li> --}}

                </ul>
            </li><!-- End Components Nav -->

            {{-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="forms-elements.html">
                            <i class="bi bi-circle"></i><span>Form Elements</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-layouts.html">
                            <i class="bi bi-circle"></i><span>Form Layouts</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-editors.html">
                            <i class="bi bi-circle"></i><span>Form Editors</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-validation.html">
                            <i class="bi bi-circle"></i><span>Form Validation</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Forms Nav --> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/recharge_invoices">
                    <i class="bi bi-file-earmark-fill"></i>
                    <span>My Invoices</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/bill/history">
                    <i class="bi bi-person"></i>
                    <span>Billing Info</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/receipt">
                    <i class="bi bi-journal-richtext"></i>
                    <span>Receipts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/get_tickets">
                    <i class="bi bi-ticket-detailed"></i>
                    <span>My Tickets</span>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link " data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="charts-chartjs.html">
                            <i class="bi bi-circle"></i><span>Chart.js</span>
                        </a>
                    </li>
                    <li>
                        <a href="charts-apexcharts.html" class="active">
                            <i class="bi bi-circle"></i><span>ApexCharts</span>
                        </a>
                    </li>
                    <li>
                        <a href="charts-echarts.html">
                            <i class="bi bi-circle"></i><span>ECharts</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Charts Nav --> --}}

            {{-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="icons-bootstrap.html">
                            <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                        </a>
                    </li>
                    <li>
                        <a href="icons-remix.html">
                            <i class="bi bi-circle"></i><span>Remix Icons</span>
                        </a>
                    </li>
                    <li>
                        <a href="icons-boxicons.html">
                            <i class="bi bi-circle"></i><span>Boxicons</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Icons Nav --> --}}

            <li class="nav-heading">Other</li>

            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/get/profile">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav --> --}}

            <!-- End F.A.Q Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="/api/user/ticket">
                    <i class="bi bi-envelope"></i>
                    <span>Support & Ticket</span>
                </a>
            </li><!-- End Contact Page Nav -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/api/admin/users_messages">
                            <i class="bi bi-circle"></i><span>Tickets</span>
                        </a>
                    </li>
                    <li>
                        <a href="tables-data.html">
                            <i class="bi bi-circle"></i><span>Data Tables</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            <!-- End Tables Nav -->

            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="pages-register.html">
                    <i class="bi bi-card-list"></i>
                    <span>Register</span>
                </a>
            </li><!-- End Register Page Nav --> --}}

            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.html">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li><!-- End Login Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-error-404.html">
                    <i class="bi bi-dash-circle"></i>
                    <span>Error 404</span>
                </a>
            </li><!-- End Error 404 Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-blank.html">
                    <i class="bi bi-file-earmark"></i>
                    <span>Blank</span>
                </a>
            </li><!-- End Blank Page Nav --> --}}

        </ul>

    </aside><!-- End Sidebar-->

    <div class="toast__container" style="">
        <div class="toast__cell" style="">
            @foreach ($messageCount as $message)
            {{-- <div class="toast toast--green"> --}}
            <div class="toast  @if($message->type == 'success') toast--green add-margin @elseif($message->type == 'info') toast--blue add-margin @elseif($message->type == 'alert') toast--red add-margin @elseif($message->type == 'warning') toast--yellow add-margin @endif">
                <div class="toast__icon">
                    <i class="bi @if($message->type == 'success') bi-check-lg  @elseif($message->type == 'info') bi-info  @elseif($message->type == 'alert') bi-exclamation-circle @elseif($message->type == 'warning') bi-exclamation @endif  text-light" style="font-size: px;"></i>
                </div>
                <div class="row" style="align-items: center;height: 80px;">
                    <div class="toast__content col-md-10">
                        <p class="toast__type">@if($message->type == 'success') Success @elseif($message->type == 'info') Info @elseif($message->type == 'alert') Alert @elseif($message->type == 'warning') Warning @endif</p>
                        <p class="toast__message">{{ Illuminate\Support\Str::limit($message->message, 45) }}</p>
                        <div class="notiError text-danger"></div>
                    </div>
                    <div class="toast__close p-2 col-md-1">
                        <a href="/api/user/read/{{$message->sno}}" class="activateAction"> <i class="bi bi-x" style="font-size: 50px"></i></a>
                    </div>
                </div>


            </div>
            @endforeach
        </div>
        <div id="snackbar"></div>

    </div>

    <div class="" id="myAreaChart">
        @yield('content')
    </div>
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Devo</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        </div>
    </footer><!-- End Footer -->
    {{-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> --}}
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- Include Select2 CSS -->

    <!-- Include jQuery -->

    <!-- Include Select2 JS -->

    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable();
        });
       
    </script>

</body>

</html>
