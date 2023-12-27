@extends('master')
@section('content')
<style>
.card-body h6{
    font-weight: 600;
    color: rgba(1, 41, 112, 0.6);
}
</style>
<!-- Include Bootstrap JavaScript -->
{{-- @if(isset($notifications) && count($notifications) > 0)
<div class="box">

    @foreach ($notifications as $index => $notification)
    @if ($notification->type === 'warning')
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: absolute;top: {{100 * $index}}px;">
<strong>Holy guacamole!</strong> {{ $notification->message }}
<a href="/api/user/alert/read/{{$notification->sno}}" class="btn-close"> </a>
</div>
@elseif ($notification->type === 'alert')
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: absolute;top: {{100 * $index}}px;">
    <strong>Holy guacamole!</strong> {{ $notification->message }}
    <a href="/api/user/alert/read/{{$notification->sno}}" class="btn-close"> </a>
</div>
@elseif ($notification->type === 'success')
<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: {{100 * $index}}px;">
    <strong>Holy guacamole!</strong> {{ $notification->message }}
    <a href="/api/user/alert/read/{{$notification->sno}}" class="btn-close"> </a>
</div>
@endif
@endforeach
</div>

@endif --}}
<main id="main" class="main pb-5">
    <div class="pagetitle">
        <h1>My Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">User</li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="row dashboard">
        <div class="col-md-8">
            <section class="section2  dashboard">
                <!-- Left side columns -->
                <div class="row">

                    <div class="col-xxl-4 col-md-4">
                        <a href="/api/user/subscription" class="card info-card sales-card" style="background: #7E63B5;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">


                            <div class="card-body" style="">
                                <h5 class="card-title text-light">Subscriptions</h5>

                                <div class="d-flex align-items-center text-light">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div class="ps-3">

                                        <h6 class="text-light">
                                            @if($user_subscription || count($user_subscription) > 0)
                                            {{ count($user_subscription) }}
                                            @endif
                                        </h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class=" small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <a href="/api/user/profile" class="card info-card sales-card"  style="background: #F98099;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                            <div class="card-body">
                                <h5 class="card-title text-light">Customize Profile <span></span></h5>
                                <div class="d-flex align-items-center text-light">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p>View and Edit Profile</p>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class=" small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <a href="/api/user/recharge_invoices" class="card info-card sales-card" style="background: #42A5F5;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">



                            <div class="card-body">
                                <h5 class="card-title text-light">View Invoices<span> </span></h5>

                                <div class="d-flex align-items-center text-light">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="text-light">
                                            @if($user_invoices || count($user_invoices) > 0)

                                            {{ count($user_invoices) }}
                                            @endif
                                        </h6>

                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
            </section>
            <section class="" style="background-color: #f4f5f7;">
                @if($user)

                <div class="container-fluid h-100">
                    <div class="row d-flex h-100">
                        <div class="card mb-3" style="border-radius: .5rem;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                            <div class="row g-0">
                                <div class="col-md-4 gradient-custom text-center" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                    {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="Avatar" class="img-fluid mt-5 mb-1" style="width: 80px;" /> --}}
                                    {{-- <i class="bi bi-person-circle mt-5 mb-1" style="font-size: 100px;color: rgba(1, 41, 112, 0.6);"></i> --}}
                                    <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid mt-5 mb-1" style="width: 80px;" alt="">
                                    <h5>{{ ucwords($user->name) }}</h5>
                                    <p>{{ ucwords($user->email) }}</p>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h5>Information</h5>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-6 mb-3">
                                                <h6>Name</h6>
                                                <p class="">{{ $user->name }}</p>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <h6>Phone</h6>
                                                <p class="">{{ $user->phone }}</p>
                                            </div>
                                        </div>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-6 mb-3">
                                                <h6>Company Name</h6>
                                                <p class="">{{ $user->companyName }}</p>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <h6>Address</h6>
                                                <p class="">{{ $user->address }}</p>
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex justify-content-start">
                                        <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                        <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                        <a href="#!"><i class="fab fa-instagram fa-lg"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
                @endif
            </section>
        </div>
        <div class="col-md-4">

            <!-- Recent Activity -->
            <div class="card">
                {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div> --}}

                <div class="card-body">
                    <h5 class="card-title">My Activity <span></span></h5>

                    <div class="activity">
                        @if(!$activities || count($activities) === 0)
                        No Activity Present
                        @else
                        @foreach($activities as $activity)
                        <div class="activity-item d-flex">
                            <div class="activite-label">
                                @php
                                // Use a valid timestamp format (Y-m-d H:i:s) for Carbon::parse
                                $createdAt = Carbon\Carbon::parse($activity->created_at, 'Asia/Kolkata');
                                $now = Carbon\Carbon::now('Asia/Kolkata');
                                @endphp
                                @if ($now->diffInWeeks($createdAt) > 1)
                                {{ $now->diffInWeeks($createdAt) }} weeks
                                @elseif ($now->diffInDays($createdAt) > 1)
                                {{ $now->diffInDays($createdAt) }} days
                                @elseif ($now->diffInMinutes($createdAt) >= 60)
                                {{ $now->diffInHours($createdAt) }} hrs
                                @elseif ($now->diffInMinutes($createdAt) >= 1)
                                {{ $now->diffInMinutes($createdAt) }} min
                                @else
                                Now
                                @endif
                            </div>
                            <i class="bi bi-circle-fill activity-badge text-@if($activity->action_type == 'login_success')success @elseif($activity->action_type == 'password_changed')primary @elseif($activity->action_type == 'receipt_read')danger @else secondary @endif align-self-start"></i>

                            <div class="activity-content">
                                {{$activity->action_type}}
                                {{-- @if($activity->action_type == 'password_changed')
                                Last Change Password
                                @elseif($activity->action_type == 'login_success')
                                Last login
                                @elseif($activity->action_type == 'receipt_read')
                                Receipt Read
                                @else
                                Not Activity
                                @endif --}}
                            </div>
                        </div>
                        @endforeach
                        {{-- <button class="btn  text-center mt-1">View All Activity</button> --}}
                        <a href="/api/user/activity"><button type="button" class="btn btn-outline-secondary mt-3 text-dark"  style="width:100%;">View All Activity</button></a>

                        @endif

                        {{-- <div class="activity-item d-flex">
                            <div class="activite-label">32 min</div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                                Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">56 min</div>
                            <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                            <div class="activity-content">
                                Voluptatem blanditiis blanditiis eveniet
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">2 hrs</div>
                            <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                            <div class="activity-content">
                                Voluptates corrupti molestias voluptatem
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">1 day</div>
                            <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                            <div class="activity-content">
                                Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">2 days</div>
                            <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                            <div class="activity-content">
                                Est sit eum reiciendis exercitationem
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">4 weeks</div>
                            <i class='bi bi-circle-fill activity-badge  align-self-start'></i>
                            <div class="activity-content">
                                Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                            </div>
                        </div><!-- End activity item--> --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
