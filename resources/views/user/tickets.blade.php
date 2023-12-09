@extends('master')

@section('content')
<main id="main" class="main">

    @if (isset($tickets) && count($tickets) > 0)
    <div class="pagetitle">
        <h1>My Tickets</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/api/user/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" style="cursor: pointer;">Tickets</li>
            </ol>
        </nav>
    </div>

    <div class="card ">
        <div class="card-header">
            <i class="fa fa-table"></i> Tickets Data Table
        </div>
        <div class="card-body mt-3">
            <div class="table-responsive">
                <table class="table dataTable " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>status</th>
                            <th>Time</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Email</th>
                            <th>Software Name</th>
                            <th>status</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($tickets as $ticket)
                        <tr>
                            <td class="align-middle"><strong>#{{ $ticket->ticketId }}</strong></td>
                            <td class="align-middle">{{ $ticket->email }}</td>

                            <td class="align-middle">{{ $ticket->software_name }}</td>


                            <td class="align-middle">
                                @if ($ticket->status === 'pending')
                                <span class="text-light  text-start" style="border-radius: 6px;background-color:rgb(19, 19, 15) 195, 189);padding:4px 8px;">Pending</span>

                                @elseif ($ticket->status === 'closed')
                                <span class="text-light text-start " style="border-radius: 6px;background-color:#D9534F;padding:4px 8px;">closed</span>
                                {{-- <a href="api/user/ticket/action/{{$ticket->ticketId}}"><button class="btn btn-success">Open Ticket</button></a> --}}
                                @elseif ($ticket->status === 'open')
                                <span class="text-light  text-start" style="border-radius: 6px;background-color:#1BC5BD;padding:4px 8px;">Opened</span>
                                @elseif ($ticket->status === 'solved')
                                <span class="text-light  text-start" style="border-radius: 6px;background-color:#5CB85C;padding:4px 8px;">Solved</span>

                                @elseif ($ticket->status === 'generated')
                                <span class="text-light  text-start" style="border-radius: 6px;background-color:#8950FC;padding:4px 8px;">Unread</span>


                                {{-- Display the chat conversation when the status is "open" --}}
                                <div>
                                    {{-- Your chat conversation display logic goes here --}}
                                    {{-- You can loop through the messages or use a chat component --}}
                                </div>

                                @else
                                <button class="btn btn-info">Unknown</button>
                                @endif
                            </td>
                            <td class="align-middle">
                                @php
                                // Use a valid timestamp format (Y-m-d H:i:s) for Carbon::parse
                                $createdAt = Carbon\Carbon::parse($ticket->created_at, 'Asia/Kolkata');
                                $now = Carbon\Carbon::now('Asia/Kolkata');
                                @endphp
                                @if ($now->diffInMinutes($createdAt) >= 1440) {{-- 1440 minutes = 24 hours --}}
                                {{ $createdAt->format('Y-m-d H:i:s') }} {{-- Display the full date and time --}}
                                @elseif ($now->diffInMinutes($createdAt) >= 60) {{-- Check if the message is older than an hour --}}
                                {{ $now->diffInHours($createdAt) }} hours ago {{-- Display hours --}}
                                @elseif ($now->diffInMinutes($createdAt) >= 1)
                                {{ $now->diffInMinutes($createdAt) }} minutes ago
                                @else
                                now
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if ($ticket->status === 'open')
                                {{-- <a href="/api/user/userChat/{{$ticket->ticketId}}"><button class="btn bg-primary text-light text-start" style="border-radius: 2px;"><i class="fa-brands fa-rocketchat"></i></button></a> --}}
                                <button class="btn bg-primary btn-sm text-light text-start" style="border-radius: 4px;" data-bs-toggle="offcanvas" href="#offcanvasExample{{$ticket->ticketId}}"><i class="fa-brands fa-rocketchat"></i></button>
                                <a href="/api/user/ticket/action/{{$ticket->ticketId}}" class="activateAction"><button class=" btn btn-sm bg-danger text-light text-start" style="border-radius: 2px;"><i class="bi bi-x-lg"></i></button></a>
                                @elseif ($ticket->status === 'unread' ||$ticket->status === 'generated')
                                <span class="text-light text-start" style="border-radius: 6px;background-color:#4fcff6;padding:4px 8px;">Generated</span>
                                @elseif ($ticket->status === 'closed' || $ticket->status === 'solved' )
                                <a href="/api/user/ticket/action/{{$ticket->ticketId}}" class="activateAction"><button class="btn btn-primary btn-sm px-2" style="border-radius:2px">Open Ticket</button></a>
                            </td>
                            {{-- <a href="userChat/{{$ticket->ticketId}}"><button class="btn btn-info">Reply Admin</button></a></td> --}}
                            {{-- <td></td>
                            <td</td> --}}
                            @endif

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="snackbar"></div>

            </div>
        </div>

        {{-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> --}}
    </div>

    @foreach ($tickets as $ticket)
    <div class="container-fluid offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample{{$ticket->ticketId}}" aria-labelledby="offcanvasExampleLabel" style="padding: 0px;min-width:40%;box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
        <div class="card" id="chat2">
            <div class="card-header d-flex align-items-center p-3">
                <h5 class="mb-0">Chat</h5>
                <div class="justify-content-end" style="flex:auto;text-align:end;">
                    <button type="button" class="btn btn-primary  btn-sm justify-content-end" data-mdb-ripple-color="dark" data-bs-dismiss="offcanvas" aria-label="Close">Back
                    </button>

                </div>
            </div>
            <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative;height: 50vh; overflow-y: auto;">
                @foreach($messages[$ticket->ticketId] as $message)
                <div class="d-flex flex-row m-2 {{ $message->type=="Admin" ? 'justify-content-start' :' justify-content-end'}}">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1" style="width: 35px; height: 100%;">
                    <div>
                        <p class=" p-1 {{ $message->type=="Admin" ? 'text-dark' :' text-light'}} ms-3 mb-1 rounded-3 px-2" style="background-color:{{ $message->type === 'Admin' ? '#f5f6f7' : '#0d6efd' }}">{{ $message->message }}</p>
                        <p class="ms-4 message_time" style="margin-top:-6px;">
                            @php
                            $createdAt = Carbon\Carbon::parse($message->created_at, 'Asia/Kolkata');
                            $now = Carbon\Carbon::now('Asia/Kolkata');
                            @endphp

                            @if ($now->diffInMinutes($createdAt) >= 1440)
                            {{ $createdAt->format('Y-m-d H:i:s') }}
                            @elseif ($now->diffInMinutes($createdAt) >= 60)
                            {{ $now->diffInHours($createdAt) }} hrs ago
                            @elseif ($now->diffInMinutes($createdAt) >= 1)
                            {{ $now->diffInMinutes($createdAt) }} min ago
                            @else
                            now
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            <form action=" http://localhost:8000/api/user/send/message/{{ $ticket->ticketId }}" method="POST" class="php-email-form card-footer text-muted d-flex justify-content-start align-items-center p-3">
                @csrf

                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 3" style="width: 40px; height: 100%;">
                <input type="text" required name="message" class="form-control mx-2" id="exampleFormControlInput1" placeholder="Type message">


                <button class=" text-muted fs-4" type="submit" style="background: none;border:none;"><i class="fas fa-paper-plane text-primary"></i></button>
                <div class="col-md-12 text-center" style="display: none;">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">
                        <span class="dynamic-message">Your message has been sent. Thank you!</span>
                    </div>

                </div>
            </form>
        </div>

    </div>
    @endforeach

    @else
    <div class="container">

        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>302</h1>
            <h2>User Has no Tickets</h2>
            {{-- <a class="btn" href="index.html">Back to home</a> --}}
            <img src="{{asset('assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">

        </section>

    </div>
    @endif
    </div>

</main>
@endsection
