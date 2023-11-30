<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-comm</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap4.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    {{-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> --}}

</head>
<style>
    /* VARIABLES */
    .snackbar {
        position: fixed;
        left: 10px;
        /* Adjust the left position as needed */
        top: 10px;
        /* Adjust the bottom position as needed */
        /* Green background color */
        color: white;
        padding: 15px;
        border-radius: 5px;
        transition: left 0.5s ease-in-out;
        z-index: 9999;
    }

    .snackbar.show {
        left: 10px;
        /* Adjust the left position as needed */
    }

    /* Animation Keyframes */
    @keyframes fadein {
        from {
            left: -300px;
            opacity: 0;
        }

        to {
            left: 10px;
            opacity: 1;
        }
    }

    @keyframes fadeout {
        from {
            left: 10px;
            opacity: 1;
        }

        to {
            left: -300px;
            opacity: 0;
        }
    }

    .container {
        margin: 0 auto;
        max-width: 480px;
        min-width: 320px;
        padding: 0 40px;
    }

    .modal {
        border-radius: 4px;
        overflow: hidden;
    }

    .form .form-row {
        display: flex;
        flex-direction: row;
        margin: 0 0 30px;
    }

    .form .form-row:last-child {
        margin: 0;
    }

    /* .form .form-row:last-child .input-group {
        width: 75%;
        margin: 0 15px 0 0;
    }

    .form .form-row:last-child .input-group:last-child {
        width: 25%;
        margin: 0 0 0 15px;
    } */

    .form .input-group {
        width: 100%;
        margin: 12px;
    }

    .form label {
        display: block;
        width: 100%;
        margin: 0 0 10px;
        color: #00a6ea;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .form input {
        outline: none;
        display: block;
        background: #cbd7e3;
        width: 100%;
        margin: 0;
        border: 0;
        border-radius: 4px;
        padding: 15px;
        color: #999;
        font-size: 12px;
        font-weight: 700;
    }

    .header {
        background: #00a6ea;
        padding: 30px;
        text-align: center;
    }



    .header h1 {
        margin: 0 0 15px;
        color: #fff;
        font-size: 1.4em;
        text-transform: uppercase;
    }

    .card-type {
        width: 100%;
        margin: auto;
        justify-content: center;
    }

    .card-type a {
        margin: 8px;
    }

</style>
<style>
    html {
        position: relative;
        min-height: 100%;
    }

    body {
        overflow-x: hidden;
    }

    a {
        text-decoration: none;
    }

    body.sticky-footer {
        margin-bottom: 56px;
    }

    body.sticky-footer .content-wrapper {
        min-height: calc(100vh - 56px - 56px);
    }

    body.fixed-nav {
        padding-top: 56px;
    }

    .content-wrapper {
        min-height: calc(100vh - 56px);
        padding-top: 1rem;
    }

    .scroll-to-top {
        position: fixed;
        right: 15px;
        bottom: 3px;
        display: none;
        width: 50px;
        height: 50px;
        text-align: center;
        color: white;
        background: rgba(52, 58, 64, 0.5);
        line-height: 45px;
    }

    .scroll-to-top:focus,
    .scroll-to-top:hover {
        color: white;
    }

    .scroll-to-top:hover {
        background: #343a40;
    }

    .scroll-to-top i {
        font-weight: 800;
    }

    .smaller {
        font-size: 0.7rem;
    }

    .o-hidden {
        overflow: hidden !important;
    }

    .z-0 {
        z-index: 0;
    }

    .z-1 {
        z-index: 1;
    }

    #mainNav .navbar-collapse {
        overflow: auto;
        max-height: 75vh;
    }

    #mainNav .navbar-collapse .navbar-nav .nav-item .nav-link {
        cursor: pointer;
    }

    #mainNav .navbar-collapse .navbar-sidenav .nav-link-collapse:after {
        float: right;
        content: '\f107';
        font-family: 'FontAwesome';
    }

    #mainNav .navbar-collapse .navbar-sidenav .nav-link-collapse.collapsed:after {
        content: '\f105';
    }

    #mainNav .navbar-collapse .navbar-sidenav .sidenav-second-level,
    #mainNav .navbar-collapse .navbar-sidenav .sidenav-third-level {
        padding-left: 0;
    }

    #mainNav .navbar-collapse .navbar-sidenav .sidenav-second-level>li>a,
    #mainNav .navbar-collapse .navbar-sidenav .sidenav-third-level>li>a {
        display: block;
        padding: 0.5em 0;
    }

    #mainNav .navbar-collapse .navbar-sidenav .sidenav-second-level>li>a:focus,
    #mainNav .navbar-collapse .navbar-sidenav .sidenav-second-level>li>a:hover,
    #mainNav .navbar-collapse .navbar-sidenav .sidenav-third-level>li>a:focus,
    #mainNav .navbar-collapse .navbar-sidenav .sidenav-third-level>li>a:hover {
        text-decoration: none;
    }

    #mainNav .navbar-collapse .navbar-sidenav .sidenav-second-level>li>a {
        padding-left: 1em;
    }

    #mainNav .navbar-collapse .navbar-sidenav .sidenav-third-level>li>a {
        padding-left: 2em;
    }

    #mainNav .navbar-collapse .sidenav-toggler {
        display: none;
    }

    #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown>.nav-link {
        position: relative;
        min-width: 45px;
    }

    #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown>.nav-link:after {
        float: right;
        width: auto;
        content: '\f105';
        border: none;
        font-family: 'FontAwesome';
    }

    #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown>.nav-link .indicator {
        position: absolute;
        top: 5px;
        left: 21px;
        font-size: 10px;
    }

    #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown.show>.nav-link:after {
        content: '\f107';
    }

    #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown .dropdown-menu>.dropdown-item>.dropdown-message {
        overflow: hidden;
        max-width: none;
        text-overflow: ellipsis;
    }

    @media (min-width: 992px) {
        #mainNav .navbar-brand {
            width: 250px;
        }

        #mainNav .navbar-collapse {
            overflow: visible;
            max-height: none;
        }

        #mainNav .navbar-collapse .navbar-sidenav {
            position: absolute;
            top: 0;
            left: 0;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            margin-top: 56px;
        }

        #mainNav .navbar-collapse .navbar-sidenav>.nav-item {
            width: 250px;
            padding: 0;
        }

        #mainNav .navbar-collapse .navbar-sidenav>.nav-item>.nav-link {
            padding: 1em;
        }

        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level,
        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level {
            padding-left: 0;
            list-style: none;
        }

        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li,
        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li {
            width: 250px;
        }

        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a,
        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a {
            padding: 1em;
        }

        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a {
            padding-left: 2.75em;
        }

        #mainNav .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a {
            padding-left: 3.75em;
        }

        #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown>.nav-link {
            min-width: 0;
        }

        #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown>.nav-link:after {
            width: 24px;
            text-align: center;
        }

        #mainNav .navbar-collapse .navbar-nav>.nav-item.dropdown .dropdown-menu>.dropdown-item>.dropdown-message {
            max-width: 300px;
        }
    }

    #mainNav.fixed-top .sidenav-toggler {
        display: none;
    }

    @media (min-width: 992px) {
        #mainNav.fixed-top .navbar-sidenav {
            height: calc(100vh - 112px);
        }

        #mainNav.fixed-top .sidenav-toggler {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            margin-top: calc(100vh - 56px);
        }

        #mainNav.fixed-top .sidenav-toggler>.nav-item {
            width: 250px;
            padding: 0;
        }

        #mainNav.fixed-top .sidenav-toggler>.nav-item>.nav-link {
            padding: 1em;
        }
    }

    #mainNav.fixed-top.navbar-dark .sidenav-toggler {
        background-color: #212529;
    }

    #mainNav.fixed-top.navbar-dark .sidenav-toggler a i {
        color: #adb5bd;
    }

    #mainNav.fixed-top.navbar-light .sidenav-toggler {
        background-color: #dee2e6;
    }

    #mainNav.fixed-top.navbar-light .sidenav-toggler a i {
        color: rgba(0, 0, 0, 0.5);
    }

    body.sidenav-toggled #mainNav.fixed-top .sidenav-toggler {
        overflow-x: hidden;
        width: 55px;
    }

    body.sidenav-toggled #mainNav.fixed-top .sidenav-toggler .nav-item,
    body.sidenav-toggled #mainNav.fixed-top .sidenav-toggler .nav-link {
        width: 55px !important;
    }

    body.sidenav-toggled #mainNav.fixed-top #sidenavToggler i {
        -webkit-transform: scaleX(-1);
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        transform: scaleX(-1);
        filter: FlipH;
        -ms-filter: 'FlipH';
    }

    #mainNav.static-top .sidenav-toggler {
        display: none;
    }

    @media (min-width: 992px) {
        #mainNav.static-top .sidenav-toggler {
            display: flex;
        }
    }

    body.sidenav-toggled #mainNav.static-top #sidenavToggler i {
        -webkit-transform: scaleX(-1);
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        transform: scaleX(-1);
        filter: FlipH;
        -ms-filter: 'FlipH';
    }

    .content-wrapper {
        overflow-x: hidden;
        background: white;
    }

    @media (min-width: 992px) {
        .content-wrapper {
            margin-left: 250px;
        }
    }

    #sidenavToggler i {
        font-weight: 800;
    }

    .navbar-sidenav-tooltip.show {
        display: none;
    }

    @media (min-width: 992px) {
        body.sidenav-toggled .content-wrapper {
            margin-left: 55px;
        }
    }

    body.sidenav-toggled .navbar-sidenav {
        width: 55px;
    }

    body.sidenav-toggled .navbar-sidenav .nav-link-text {
        display: none;
    }

    body.sidenav-toggled .navbar-sidenav .nav-item,
    body.sidenav-toggled .navbar-sidenav .nav-link {
        width: 55px !important;
    }

    body.sidenav-toggled .navbar-sidenav .nav-item:after,
    body.sidenav-toggled .navbar-sidenav .nav-link:after {
        display: none;
    }

    body.sidenav-toggled .navbar-sidenav .nav-item {
        white-space: nowrap;
    }

    body.sidenav-toggled .navbar-sidenav-tooltip.show {
        display: flex;
    }

    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav .nav-link-collapse:after {
        color: #868e96;
    }

    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item>.nav-link {
        color: #868e96;
    }

    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item>.nav-link:hover {
        color: #adb5bd;
    }

    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a,
    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a {
        color: #868e96;
    }

    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a:focus,
    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a:hover,
    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a:focus,
    #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a:hover {
        color: #adb5bd;
    }

    #mainNav.navbar-dark .navbar-collapse .navbar-nav>.nav-item.dropdown>.nav-link:after {
        color: #adb5bd;
    }

    @media (min-width: 992px) {
        #mainNav.navbar-dark .navbar-collapse .navbar-sidenav {
            background: #343a40;
        }

        #mainNav.navbar-dark .navbar-collapse .navbar-sidenav li.active a {
            color: white !important;
            background-color: #495057;
        }

        #mainNav.navbar-dark .navbar-collapse .navbar-sidenav li.active a:focus,
        #mainNav.navbar-dark .navbar-collapse .navbar-sidenav li.active a:hover {
            color: white;
        }

        #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level,
        #mainNav.navbar-dark .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level {
            background: #343a40;
        }
    }

    #mainNav.navbar-light .navbar-collapse .navbar-sidenav .nav-link-collapse:after {
        color: rgba(0, 0, 0, 0.5);
    }

    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item>.nav-link {
        color: rgba(0, 0, 0, 0.5);
    }

    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item>.nav-link:hover {
        color: rgba(0, 0, 0, 0.7);
    }

    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a,
    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a {
        color: rgba(0, 0, 0, 0.5);
    }

    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a:focus,
    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level>li>a:hover,
    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a:focus,
    #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level>li>a:hover {
        color: rgba(0, 0, 0, 0.7);
    }

    #mainNav.navbar-light .navbar-collapse .navbar-nav>.nav-item.dropdown>.nav-link:after {
        color: rgba(0, 0, 0, 0.5);
    }

    @media (min-width: 992px) {
        #mainNav.navbar-light .navbar-collapse .navbar-sidenav {
            background: #f8f9fa;
        }

        #mainNav.navbar-light .navbar-collapse .navbar-sidenav li.active a {
            color: #000 !important;
            background-color: #e9ecef;
        }

        #mainNav.navbar-light .navbar-collapse .navbar-sidenav li.active a:focus,
        #mainNav.navbar-light .navbar-collapse .navbar-sidenav li.active a:hover {
            color: #000;
        }

        #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-second-level,
        #mainNav.navbar-light .navbar-collapse .navbar-sidenav>.nav-item .sidenav-third-level {
            background: #f8f9fa;
        }
    }

    .card-body-icon {
        position: absolute;
        z-index: 0;
        top: -25px;
        right: -25px;
        font-size: 5rem;
        -webkit-transform: rotate(15deg);
        -ms-transform: rotate(15deg);
        transform: rotate(15deg);
    }

    @media (min-width: 576px) {
        .card-columns {
            column-count: 1;
        }
    }

    @media (min-width: 768px) {
        .card-columns {
            column-count: 2;
        }
    }

    @media (min-width: 1200px) {
        .card-columns {
            column-count: 2;
        }
    }

    .card-login {
        max-width: 25rem;
    }

    .card-register {
        max-width: 40rem;
    }

    footer.sticky-footer {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 56px;
        background-color: #e9ecef;
        line-height: 55px;
    }

    @media (min-width: 992px) {
        footer.sticky-footer {
            width: calc(100% - 250px);
        }
    }

    @media (min-width: 992px) {
        body.sidenav-toggled footer.sticky-footer {
            width: calc(100% - 55px);
        }
    }

    .alert {
        position: relative;
        top: 80px;
        right: 10px;
        width: 500px;
        margin: 120px color: black;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        /* z-index: 1000; */
    }

    .toast.show {
        display: block;
    }

    .box {
        position: absolute;
        /* top: 100px; */
        right: 10px;
        z-index: 1000;
        /* width: auto; */
        /* overflow: scroll; */
        height: 200px;
    }

</style>

</head>
<body class="sidenav-toggled">
    {{-- @if(isset($messageCount) && count($messageCount) > 0)
    <div class="box">

        
        @foreach ($messageCount as $index => $notification)
        @if ($notification->type === 'warning')
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: absolute;top: {{50 * $index}}px;">
    <strong>Holy guacamole!</strong> {{ $notification->message }}
    <a href="/api/user/alert/read/{{$notification->sno}}" class="btn-close"> </a>
    </div>
    @elseif ($notification->type === 'alert')
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: absolute;top: {{50 * $index}}px;">
        <strong>Holy guacamole!</strong> {{ $notification->message }}
        <a href="/api/user/alert/read/{{$notification->sno}}" class="btn-close"> </a>
    </div>
    @elseif ($notification->type === 'success')
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: {{50 * $index}}px;">
        <strong>Holy guacamole!</strong> {{ $notification->message }}
        <a href="/api/user/alert/read/{{$notification->sno}}" class="btn-close"> </a>
    </div>
    @endif
    @endforeach
    </div>

    @endif --}}

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #343a40;;" id="mainNav">
        <div id="toast-container" class="box"></div>

        <a class="navbar-brand ms-3" href="index.html">User Panel</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion" style="height: 90vh; overflow-y: auto;">
                <li class=" nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="/api/user/get/dashboard">
                        <i class="fa fa-fw fa-dashboard"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>

                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-user"></i>
                        <span class="nav-link-text">Profile</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseComponents">
                        <li>
                            <a href="/api/user/get/profile">Profile</a>
                        </li>
                        <li>
                            <a href="/api/user/edit/profile/update">Edit Profile</a>
                        </li>
                        <li>
                            <a href="/api/user/forget_page/changePassword">Change Passsword</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Plans">
                    <a class="nav-link" href="/api/user/plans">
                        <i class="fa fa-fw fa-area-chart"></i>
                        <span class="nav-link-text">Plans</span>
                    </a>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tickets">
                    <a class="nav-link" href="/api/user/get_tickets">
                        {{-- <i class="fa fa-fw fa-table"></i> --}}
                        <i class="fa fa-fw fa-ticket"></i>
                        <span class="nav-link-text">Tickets</span>
                    </a>
                </li>
                {{-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Admin Tickets">
                    <a class="nav-link" href="/users_messages">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="nav-link-text">Admin Messages</span>
                    </a>
                </li> --}}
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Subscription History">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-file"></i>
                        <span class="nav-link-text">History</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseExamplePages">
                        <li>
                            <a href="/api/user/subs_history">Subscription History</a>
                        </li>
                        <li>
                            <a href="/api/user/bill/history">Bill History</a>
                        </li>
                        {{-- <li>
                            <a href="forgot-password.html">Forgot Password Page</a>
                        </li>
                        <li>
                            <a href="blank.html">Blank Page</a>
                        </li> --}}
                    </ul>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Subscription">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-sitemap"></i>
                        <span class="nav-link-text">Subscription</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti">
                        <li>
                            <a href="/api/user/subscription">User Subscription</a>
                        </li>
                        <li>
                            <a href="/api/user/cancel_subs">Cancel Subscription</a>
                        </li>
                        <!-- <li>
                                <a href="#">Second Level Item</a>
                            </li> -->
                        <li>
                            <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Invoices
                            </a>
                            <ul class="sidenav-third-level collapse" id="collapseMulti2">
                                <li>
                                    {{-- <a href="/recharge_invoices">Recharge Invoice</a> --}}
                                    <a class="nav-link" href="/api/user/recharge_invoices">
                                        <i class="fa-solid fa-file-invoice"></i>
                                        <span class="nav-link-text">Recharge Invoice</span>
                                    </a>
                                </li>
                                <li>
                                    {{-- <i class="fa fa-fw fa-receipt"></i>
                                    <a href="/invoices">Invoice Receipt</a> --}}
                                    <a class="nav-link" href="/api/user/invoices">
                                        <i class="fa fa-fw fa-receipt"></i>
                                        <span class="nav-link-text">Receipt</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Admin">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages1" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-user"></i>

                        <span class="nav-link-text">Admin</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseExamplePages1">
                        <li>
                            <a href="/api/admin/users_messages">Tickets</a>
                        </li>
                        <li>
                            <a href="/api/admin/actions">Actions</a>
                        </li>
                        <li>
                            <a href="/api/admin/log/actions">Log Actions</a>
                        </li>
                        <li>
                            <a href="/api/admin/all/Subscriptions">Subscriptions</a>
                        </li>
                        {{-- <li>
                            <a href="forgot-password.html">Forgot Password Page</a>
                        </li>
                        <li>
                            <a href="blank.html">Blank Page</a>
                        </li> --}}
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto " style="align-items: center">
                <li class="nav-item m-2">
                    <a class="nav-link" href="/api/user/notifications" data-target="#exampleModal">
                        <i class="fa fa-fw fa-envelope"></i>
                        <sup>
                            @if (isset($messageCount) && count($messageCount) > 0)
                            <span class="badge badge-danger" style="position: absolute;">{{ count($messageCount) }}</span>
                            @endif
                        </sup>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="/notifications" data-target="#exampleModal">
                        <i class="fa fa-fw fa-bell"></i>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="/api/user/ticket" data-target="#exampleModal">
                        <i class="mb-2">Get Quote ></i>
                    </a>
                </li>

                <li class="nav-item">
                    <form class="form-inline my-2 my-lg-0 mr-lg-2" style="align-items: baseline !important;">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Search for...">
                            <span class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </li>
            </ul>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </nav>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/api/user/logout">Logout</a>
                </div>
            </div>
        </div>
        {{-- <button id="showToastButton">Show Toast</button> --}}
        <div class="toast-container" style="display: none;"></div>
    </div>
    {{-- {{View::make('header')}} --}}
    <div class="mt-5 ms-5" id="myAreaChart">
        @yield('content')
    </div>
    {{-- {{View::make('footer')}} --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> --}}
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        (function($) {
            "use strict"; // Start of use strict
            // Configure tooltips for collapsed side navigation
            $('.navbar-sidenav [data-toggle="tooltip"]').tooltip({
                template: '<div class="tooltip navbar-sidenav-tooltip" role="tooltip" style="pointer-events: none;"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            })
            // Toggle the side navigation
            $("#sidenavToggler").click(function(e) {
                e.preventDefault();
                $("body").toggleClass("sidenav-toggled");
                $(".navbar-sidenav .nav-link-collapse").addClass("collapsed");
                $(".navbar-sidenav .sidenav-second-level, .navbar-sidenav .sidenav-third-level").removeClass("show");
            });
            // Force the toggled class to be removed when a collapsible nav link is clicked
            $(".navbar-sidenav .nav-link-collapse").click(function(e) {
                e.preventDefault();
                $("body").removeClass("sidenav-toggled");
            });
            $(".navbar-sidenav").mouseenter(function() {
                $("body").removeClass("sidenav-toggled");
            });
            $(".navbar-sidenav").mouseleave(function() {
                $("body").toggleClass("sidenav-toggled");
                $(".navbar-sidenav .nav-link-collapse").addClass("collapsed");
                $(".navbar-sidenav .sidenav-second-level, .navbar-sidenav .sidenav-third-level").removeClass("show");
            });
            // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
            $('body.fixed-nav .navbar-sidenav, body.fixed-nav .sidenav-toggler, body.fixed-nav .navbar-collapse').on('mousewheel DOMMouseScroll', function(e) {
                var e0 = e.originalEvent
                    , delta = e0.wheelDelta || -e0.detail;
                this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                e.preventDefault();
            });
            // Scroll to top button appear
            $(document).scroll(function() {
                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });
            // Configure tooltips globally
            $('[data-toggle="tooltip"]').tooltip()
            // Smooth scrolling using jQuery easing
            $(document).on('click', 'a.scroll-to-top', function(event) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top)
                }, 1000, 'easeInOutExpo');
                event.preventDefault();
            });
        })(jQuery);

    </script>
    <script>
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';
        // -- Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line'
            , data: {
                labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"]
                , datasets: [{
                    label: "Sessions"
                    , lineTension: 0.3
                    , backgroundColor: "rgba(2,117,216,0.2)"
                    , borderColor: "rgba(2,117,216,1)"
                    , pointRadius: 5
                    , pointBackgroundColor: "rgba(2,117,216,1)"
                    , pointBorderColor: "rgba(255,255,255,0.8)"
                    , pointHoverRadius: 5
                    , pointHoverBackgroundColor: "rgba(2,117,216,1)"
                    , pointHitRadius: 20
                    , pointBorderWidth: 2
                    , data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451]
                , }]
            , }
            , options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        }
                        , gridLines: {
                            display: false
                        }
                        , ticks: {
                            maxTicksLimit: 7
                        }
                    }]
                    , yAxes: [{
                        ticks: {
                            min: 0
                            , max: 40000
                            , maxTicksLimit: 5
                        }
                        , gridLines: {
                            color: "rgba(0, 0, 0, .125)"
                        , }
                    }]
                , }
                , legend: {
                    display: false
                }
            }
        });
        // -- Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myLineChart = new Chart(ctx, {
            type: 'bar'
            , data: {
                labels: ["January", "February", "March", "April", "May", "June"]
                , datasets: [{
                    label: "Revenue"
                    , backgroundColor: "rgba(2,117,216,1)"
                    , borderColor: "rgba(2,117,216,1)"
                    , data: [4215, 5312, 6251, 7841, 9821, 14984]
                , }]
            , }
            , options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        }
                        , gridLines: {
                            display: false
                        }
                        , ticks: {
                            maxTicksLimit: 6
                        }
                    }]
                    , yAxes: [{
                        ticks: {
                            min: 0
                            , max: 15000
                            , maxTicksLimit: 5
                        }
                        , gridLines: {
                            display: true
                        }
                    }]
                , }
                , legend: {
                    display: false
                }
            }
        });
        // -- Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'pie'
            , data: {
                labels: ["Blue", "Red", "Yellow", "Green"]
                , datasets: [{
                    data: [12.21, 15.58, 11.25, 8.32]
                    , backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745']
                , }]
            , }
        , });

        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        (function($) {
            "use strict"; // Start of use strict
            // Configure tooltips for collapsed side navigation
            $('.navbar-sidenav [data-toggle="tooltip"]').tooltip({
                template: '<div class="tooltip navbar-sidenav-tooltip" role="tooltip" style="pointer-events: none;"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            })
            // Toggle the side navigation
            $("#sidenavToggler").click(function(e) {
                e.preventDefault();
                $("body").toggleClass("sidenav-toggled");
                $(".navbar-sidenav .nav-link-collapse").addClass("collapsed");
                $(".navbar-sidenav .sidenav-second-level, .navbar-sidenav .sidenav-third-level,.sidenav-fourth-level").removeClass("show");
            });
            // Force the toggled class to be removed when a collapsible nav link is clicked
            $(".navbar-sidenav .nav-link-collapse").click(function(e) {
                e.preventDefault();
                $("body").removeClass("sidenav-toggled");
            });
            // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
            $('body.fixed-nav .navbar-sidenav, body.fixed-nav .sidenav-toggler, body.fixed-nav .navbar-collapse').on('mousewheel DOMMouseScroll', function(e) {
                var e0 = e.originalEvent
                    , delta = e0.wheelDelta || -e0.detail;
                this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                e.preventDefault();
            });
            // Scroll to top button appear
            $(document).scroll(function() {
                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });
            // Configure tooltips globally
            $('[data-toggle="tooltip"]').tooltip()
            // Smooth scrolling using jQuery easing
            $(document).on('click', 'a.scroll-to-top', function(event) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top)
                }, 1000, 'easeInOutExpo');
                event.preventDefault();
            });
        })(jQuery); // End of use

    </script>
    <script>
        $(document).ready(function() {
            // Show the toast when the "Show Toast" button is clicked
            $('#showToastButton').click(function() {
                showToast("This is a simple toast notification!");
            });

            // Function to display a toast notification
            function showToast(message) {
                // Create a new toast element
                var $toast = $('<div class="toast">' + message + '</div>');

                // Append the toast to the container
                $('.toast-container').append($toast);

                // Fade in the toast
                $toast.fadeIn();

                // Set a timeout to remove the toast after a few seconds (e.g., 3 seconds)
                setTimeout(function() {
                    $toast.fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        });

    </script>

</body>
</html>
