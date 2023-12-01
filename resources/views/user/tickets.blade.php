@extends('master')

@section('content')
<main id="main" class="main">

    @if (isset($tickets) && count($tickets) > 0)
    <h1>Your Tickets</h1>

    <div class="card m-5">
        <div class="card-header">
            <i class="fa fa-table"></i> Data Table Example
        </div>
        <div class="card-body mt-3">
            <div class="table-responsive">
                <table class="table dataTable " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Time</th>
                            <th>status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Email</th>
                            <th>Software Name</th>
                            <th>Time</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($tickets as $ticket)
                        <tr>
                            <td><strong>#{{ $ticket->ticketId }}</strong></td>
                            <td>{{ $ticket->email }}</td>

                            <td>{{ $ticket->software_name }}</td>
                            <td>
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

                            <td>
                                @if ($ticket->status === 'pending')
                                <button class="btn btn-warning">Pending</button>
                                @elseif ($ticket->status === 'closed')
                                <button class="btn btn-warning text-light " style="border-radius: 16px;">closed</button>
                                {{-- <a href="api/user/ticket/action/{{$ticket->ticketId}}"><button class="btn btn-success">Open Ticket</button></a> --}}
                                @elseif ($ticket->status === 'open')
                                <p class="text-light bg-success p-1 text-center" style="border-radius: 8px;">Opened</p>
                                @elseif ($ticket->status === 'solved')
                                <p class="text-light bg-success p-1 text-center" style="border-radius: 8px;">Solved</p>
                                @elseif ($ticket->status === 'generated')
                                <p class="text-light bg-success p-1 text-center" style="border-radius: 8px;">Generated</p>
                          
                                {{-- Display the chat conversation when the status is "open" --}}
                                <div>
                                    {{-- Your chat conversation display logic goes here --}}
                                    {{-- You can loop through the messages or use a chat component --}}
                                </div>

                                @else
                                <button class="btn btn-info">Unknown</button>
                                @endif
                            </td>
                            @if ($ticket->status === 'open')
                            <td>
                                <a href="/api/user/userChat/{{$ticket->ticketId}}"><button class="btn bg-primary text-light" style="border-radius: 20px;"><i class="fa-brands fa-rocketchat"></i></button></a>
                                <a href="/api/user/ticket/action/{{$ticket->ticketId}}" class="activateAction"><button class=" btn bg-danger text-light" style="border-radius: 20px;"><i class="fa-solid fa-circle-xmark"></i></button></a>
                            </td>
                            {{-- <a href="userChat/{{$ticket->ticketId}}"><button class="btn btn-info">Reply Admin</button></a></td> --}}
                            @elseif ($ticket->status === 'unread' ||$ticket->status === 'generated')
                            <td><p class="text-light bg-success p-1 text-center" style="border-radius: 8px;">Unread</p></td>
                            @elseif ($ticket->status === 'closed' || $ticket->status === 'solved'  )
                            <td><a href="/api/user/ticket/action/{{$ticket->ticketId}}" class="activateAction"><button class="btn btn-success"style="padding:7px;border-radius:8px">Open Ticket</button></a> </td>
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
