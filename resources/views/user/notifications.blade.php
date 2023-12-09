@extends('master')

@section('content')
<main id="main" class="main">


    <h1>Notifications Details</h1>
    <div class=" pe-5 " style=" width:100%; text-align: end;">
    </div>
    <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">User</a></li>
                <li class="breadcrumb-item">Notification</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                {{-- <div class="card">
                    <div class="card-body"> --}}
                {{-- <h5 class="card-title">Datatables</h5>
                        <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. --}}

                <section class=" profile">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body pt-3">
                                    <!-- Bordered Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-bordered">

                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Unread</button>
                                        </li>

                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">All</button>
                                        </li>
                                        <div class="float-end ms-auto">
                                            <a href="/api/user/read_all/{{$user?$user->user_id:''}}" class="activateAction">
                                                <p class="p-2 text-light bg-primary " style="border-radius:2px;">Marked All</p>
                                            </a>
                                        </div>
                                        {{-- <li class="nav-item">
                                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                                                    </li> --}}



                                    </ul>
                                    {{-- @if(isset($messages) && count($messages) > 0) --}}

                                    <div class="tab-content pt-2">

                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                            <div class="row">
                                                <div class="table-responsive">

                                                    <h5 class="card-title">Datatables</h5>

                                                    <table class="table dataTable  " id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>UserId</th>
                                                                <th>Email</th>
                                                                <th>Message</th>
                                                                <th>Type</th>
                                                                <th>Mark</th>
                                                                <th>Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>userId</th>
                                                                <th>Email</th>
                                                                <th>Message</th>
                                                                <th>Type</th>
                                                                <th>Mark</th>
                                                                <th>Time</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            @foreach ($messages as $message)
                                                            <tr class="" style="color: {{ $message->type === 'alert' ? 'red' : 'inherit' }}; background-color: {{ $message->type === 'alert' ? 'red' : 'inherit' }};">

                                                                <td class="align-middle"><strong>#{{ $message->user_id }}</strong></td>
                                                                <td class="align-middle"> <span>{{ $message->email }}</span> </td>
                                                                <td class="align-middle" style="width: 350px;"><span>{{ $message->message }}</span></td>
                                                                <td class="align-middle">@if ($message->type === 'success')
                                                                    <span class=" text-light bg-success text-center" style="border-radius:8px
                                                                            ;padding:4px;">Success</span>
                                                                    @elseif ($message->type === 'alert')
                                                                    <span class="text-light bg-danger text-center" style="
                                                                            padding:4px;border-radius:8px;">Alert</span>
                                                                    @elseif ($message->type === 'warning')
                                                                    <span class=" text-center text-light bg-warning" style="
                                                                            padding:4px;border-radius:8px;">warning</span>
                                                                    @endif</td>
                                                                <td class="align-middle"><a href="/api/user/read/{{$message->sno}}" class="activateAction">
                                                                        <span class=" text-center text-light bg-primary" style="width: 130px;
                                                                    padding:4px;border-radius:8px;">Mark As Read</span>
                                                                    </a></td>
                                                                <td class="align-middle">
                                                                    @php
                                                                    // Use a valid timestamp format (Y-m-d H:i:s) for Carbon::parse
                                                                    $createdAt = Carbon\Carbon::parse($message->created_at, 'Asia/Kolkata');
                                                                    $now = Carbon\Carbon::now('Asia/Kolkata');
                                                                    @endphp
                                                                    @if ($now->diffInWeeks($createdAt) >= 1) {{-- 1440 minutes = 24 hours --}}
                                                                    {{ $now->diffInWeeks($createdAt) }} week ago
                                                                    @elseif ($now->diffInMinutes($createdAt) >= 1440) {{-- 1440 minutes = 24 hours --}}
                                                                    {{ $now->diffInDays($createdAt) }} day ago{{-- Display the full date and time --}}
                                                                    @elseif ($now->diffInMinutes($createdAt) >= 60) {{-- Check if the message is older than an hour --}}
                                                                    {{ $now->diffInHours($createdAt) }} hrs ago {{-- Display hours --}}
                                                                    @elseif ($now->diffInMinutes($createdAt) >= 1)
                                                                    {{ $now->diffInMinutes($createdAt) }} min ago
                                                                    @else
                                                                    Now
                                                                    @endif
                                                                </td>


                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade profile-edit " id="profile-edit">

                                            <!-- Profile Edit Form -->
                                            {{-- <div class="row"> --}}
                                            <div class="table-responsive">

                                                <h5 class="card-title">Datatables</h5>

                                                <table class="table dataTable " id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>UserId</th>
                                                            <th>Email</th>
                                                            <th>Message</th>
                                                            <th>Type</th>
                                                            <th>Mark</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>userId</th>
                                                            <th>Email</th>
                                                            <th>Message</th>
                                                            <th>Type</th>
                                                            <th>Mark</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        @foreach ($allMessages as $message)
                                                        <tr class="datatable-row align-middle" style="color: {{ $message->type === 'alert' ? 'red' : 'inherit' }}; background-color: {{ $message->type === 'alert' ? 'red' : 'inherit' }};">

                                                            <td class=" align-middle"><strong>#{{ $message->user_id }}</strong></td>
                                                            <td class="align-middle"> <span>{{ $message->email }}</span> </td>
                                                            <td class="align-middle" style="width: 350px;">
                                                                <span style="width: 350px;">{{ $message->message }}</span>
                                                            </td>
                                                            <td class="align-middle">@if ($message->type === 'success')
                                                                <span class=" text-light bg-success text-center" style="border-radius:8px
                                                                            ;padding:4px 8px;">Success</span>
                                                                @elseif ($message->type === 'alert')
                                                                <span class="text-light bg-danger text-center" style="
                                                                            padding:4px 8px;border-radius:8px;">Alert</span>
                                                                @elseif ($message->type === 'warning')
                                                                <span class=" text-center text-light bg-warning" style="
                                                                            padding:4px 8px;border-radius:8px;">warning</span>
                                                                @endif</td>
                                                            <td class="align-middle">
                                                                @if($message->status=='read')
                                                                <span class=" text-center text-light bg-secondary" style="width: 130px;
                                                                    padding:4px 8px;border-radius:8px;display: inline-block;">Mark As Read</span>
                                                                @else
                                                                <a href="/api/user/read/{{$message->sno}}" class="activateAction">
                                                                    <span class=" text-center text-light bg-primary" style="width: 130px;
                                                                        padding:4px 8px;border-radius:8px;display: inline-block;">Mark As Read</span>
                                                                </a>
                                                                @endif

                                                            </td>

                                                            <td class="align-middle">
                                                                <span style="width: 100px;">
                                                                    @php
                                                                    // Use a valid timestamp format (Y-m-d H:i:s) for Carbon::parse
                                                                    $createdAt = Carbon\Carbon::parse($message->created_at, 'Asia/Kolkata');
                                                                    $now = Carbon\Carbon::now('Asia/Kolkata');
                                                                    @endphp
                                                                    @if ($now->diffInWeeks($createdAt) >= 1) {{-- 1440 minutes = 24 hours --}}
                                                                    {{ $now->diffInWeeks($createdAt) }} week ago
                                                                    @elseif ($now->diffInMinutes($createdAt) >= 1440) {{-- 1440 minutes = 24 hours --}}
                                                                    {{ $now->diffInDays($createdAt) }} day ago{{-- Display the full date and time --}}
                                                                    @elseif ($now->diffInMinutes($createdAt) >= 60) {{-- Check if the message is older than an hour --}}
                                                                    {{ $now->diffInHours($createdAt) }} hrs ago {{-- Display hours --}}
                                                                    @elseif ($now->diffInMinutes($createdAt) >= 1)
                                                                    {{ $now->diffInMinutes($createdAt) }} min ago
                                                                    @else
                                                                    Now
                                                                    @endif
                                                                </span>
                                                            </td>


                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @else

                                    <h1>User has no notifications</h1>
                                    @endif --}}
                                </div>



                            </div>
                        </div>
                    </div>



                </section>
            </div>
        </div>

    </section>




</main>
@endsection
