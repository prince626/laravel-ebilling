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
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
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
                                            <a href="/api/user/read_all/{{$user?$user->user_id:''}}" class="activateAction"><button class="btn btn-primary ">Marked All</button></a>
                                        </div>
                                        {{-- <li class="nav-item">
                                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                                                    </li> --}}



                                    </ul>
                                    {{-- @if(isset($messages) && count($messages) > 0) --}}

                                    <div class="tab-content pt-2">

                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <h5 class="card-title">Datatables</h5>

                                                    <table class="table dataTable table-striped" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>userId</th>
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

                                                                <td>{{ $message->user_id }}</td>
                                                                <td><strong>{{ $message->email }} </strong> </td>
                                                                <td>{{ $message->message }}</td>
                                                                <td>@if ($message->type === 'success')
                                                                    <p class=" text-light bg-success text-center" style="border-radius:8px
                                                                            ;padding:4px;font-weight:bold;">Success</p>
                                                                    @elseif ($message->type === 'alert')
                                                                    <p class="text-light bg-danger text-center" style="
                                                                            padding:4px;border-radius:8px;font-weight:bold;">Alert</p>
                                                                    @elseif ($message->type === 'warning')
                                                                    <p class=" text-center text-light bg-warning" style="
                                                                            padding:4px;border-radius:8px;font-weight:bold;">warning</p>
                                                                    @endif</td>
                                                                <td><a href="/api/user/read/{{$message->sno}}" class="activateAction"> <p class=" text-center text-light bg-primary" style="
                                                                    padding:4px;border-radius:8px;font-weight:bold;">Mark As Read</p></a></td>
                                                                <td>
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
                                            <div class="col-lg-12">

                                                <h5 class="card-title">Datatables</h5>

                                                    <table class="table dataTable table-striped" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>userId</th>
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
                                                            <tr class="" style="color: {{ $message->type === 'alert' ? 'red' : 'inherit' }}; background-color: {{ $message->type === 'alert' ? 'red' : 'inherit' }};">

                                                                <td>{{ $message->user_id }}</td>
                                                                <td><strong>{{ $message->email }} </strong> </td>
                                                                <td>{{ $message->message }}</td>
                                                                <td>@if ($message->type === 'success')
                                                                    <p class=" text-light bg-success text-center" style="border-radius:8px
                                                                            ;padding:4px;font-weight:bold;">Success</p>
                                                                    @elseif ($message->type === 'alert')
                                                                    <p class="text-light bg-danger text-center" style="
                                                                            padding:4px;border-radius:8px;font-weight:bold;">Alert</p>
                                                                    @elseif ($message->type === 'warning')
                                                                    <p class=" text-center text-light bg-warning" style="
                                                                            padding:4px;border-radius:8px;font-weight:bold;">warning</p>
                                                                    @endif</td>
                                                                <td>
                                                                    @if($message->status=='read')
                                                                    <p class=" text-center text-light bg-secondary" style="
                                                                    padding:4px;border-radius:8px;font-weight:bold;">Mark As Read</p>
                                                                    @else
                                                                    <a href="/api/user/read/{{$message->sno}}" class="activateAction"> <p class=" text-center text-light bg-primary" style="
                                                                        padding:0px;border-radius:8px;font-weight:bold;">Mark As Read</p></a>
                                                                    @endif

                                                                </td>

                                                                <td>
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
                                                                    @endif
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
