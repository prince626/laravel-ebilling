{{-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #343a40;;" id="mainNav">
    <a class="navbar-brand ms-3" href="index.html">Start Bootstrap</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion" style="height: 90vh; overflow-y: auto;">
            <li class=" nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="/get/dashboard">
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
                        <a href="/get/profile">Profile</a>
                    </li>
                    <li>
                        <a href="/edit/profile/update">Edit Profile</a>
                    </li>
                    <li>
                        <a href="/forget_page/changePassword">Change Passsword</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Plans">
                <a class="nav-link" href="/plans">
                    <i class="fa fa-fw fa-area-chart"></i>
                    <span class="nav-link-text">Plans</span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tickets">
                <a class="nav-link" href="/get_tickets">
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
            <a href="/api/subs_history">Subscription History</a>
        </li>
        <li>
            <a href="/api/bill/history">Bill History</a>
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
            <a href="/api/subscription">User Subscription</a>
        </li>
        <li>
            <a href="/api/cancel_subs">Cancel Subscription</a>
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
                    <a class="nav-link" href="/api/recharge_invoices">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span class="nav-link-text">Recharge Invoice</span>
                    </a>
                </li>
                <li>
                    {{-- <i class="fa fa-fw fa-receipt"></i>
                                <a href="/invoices">Invoice Receipt</a> --}}
                    <a class="nav-link" href="/api/invoices">
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
            <a href="/api/users_messages">Tickets</a>
        </li>
        <li>
            <a href="/api/admin/actions">Actions</a>
        </li>
        <li>
            <a href="/api/admin/log/actions">Log Actions</a>
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
<ul class="navbar-nav ml-auto" style="align-items: center">
    <li class="nav-item">
        <a class="nav-link" href="/api/notifications" data-target="#exampleModal">
            <i class="fa fa-fw fa-envelope"></i></a>
    </li>
    {{-- <li class="nav-item">
                <a class="nav-link" href="/notifications" data-target="#exampleModal">
                    <i class="fa fa-fw fa-bell"></i>
            </li> --}}
    <li class="nav-item">
        <a class="nav-link" href="/api/ticket" data-target="#exampleModal">
            <i class="mb-2">Get Quote ></i>
        </a>
    </li>

    <li class="nav-item">
        <form class="form-inline my-2 my-lg-0 mr-lg-2" style="align-items: baseline;">
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
                <a class="btn btn-primary" href="api/logout">Logout</a>
            </div>
        </div>
    </div>
</div>
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
