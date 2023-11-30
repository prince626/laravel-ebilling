@extends('master')

@section('content')
<main id="main" class="main">
<div class="container-fluid p-3 m-auto">
    <h1 class="text-center">USERS TICKETS</h1>
    @if(isset($messages) && count($messages) > 0)
    <div class="card m-auto">
        <div class="card-header">
            <i class="fa fa-table"></i> Data Table Example
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Message Id</th>
                            <th>Name</th>
                            <th>Problem</th>
                            <th>status</th>
                            <th>Action</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>UserId</th>
                            <th>Email</th>
                            <th>Problem</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Time</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($messages as $sub)
                        <tr style="background-color: {{ $sub->type === 'alert' ? 'red !important' : 'inherit' }};">
                            <td>{{ $sub->ticketId }}</td>
                            <td>Prince</td>
                            <td>{{ $sub->software_name }}</td>
                            <td>
                                @if ($sub->status === 'pending')
                                <button class="btn btn-warning">Pending</button>
                                @elseif ($sub->status === 'closed')
                                <strong class="text-success " style="border-radius: 23px;">closed</strong>
                                {{-- <a href="/api/admin/action/{{$sub->ticketId}}"><button class="btn btn-success">Open Ticket</button></a> --}}
                                @elseif ($sub->status === 'open')
                                <strong class="text-success " style="border-radius: 23px;">Opened</strong>
                                @elseif ($sub->status === 'solved')
                                <strong class="text-success">Solved</strong>
                                @elseif ($sub->status === 'generated')
                                <button class="btn btn-success">Generated</button>

                                {{-- Display the chat conversation when the status is "open" --}}
                                <div>
                                    {{-- Your chat conversation display logic goes here --}}
                                    {{-- You can loop through the messages or use a chat component --}}
                                </div>
                                @else
                                <button class="btn btn-info">Unknown</button>
                                @endif
                            </td>
                            <td>
                                @if ($sub->status === 'open' ||$sub->status === 'generated')
                                <a href="/api/admin/adminChat/{{$sub->ticketId}}"><button class="btn bg-primary text-light"><i class="fa-brands fa-rocketchat"></i></button></a>
                                <a href="/api/admin/action/{{$sub->ticketId}}"><button class=" btn bg-danger text-light"><i class="fa-solid fa-circle-xmark"></i></button></a>

                                <button class=" btn bg-success text-light " data-toggle="modal" data-target="#exampleModal1{{ $sub->ticketId }}"><i class="fa-solid fa-circle-check"></i></i></button>

                                @elseif ($sub->status === 'closed'||$sub->status === 'solved')
                                <a href="/api/admin/action/{{$sub->ticketId}}"><button class="btn btn-success">Open Ticket</button></a>
                                @endif
                            </td>
                            <td>
                                @php
                                // Use a valid timestamp format (Y-m-d H:i:s) for Carbon::parse
                                $createdAt = Carbon\Carbon::parse($sub->created_at, 'Asia/Kolkata');
                                $now = Carbon\Carbon::now('Asia/Kolkata');
                                @endphp

                                @if ($now->diffInMinutes($createdAt) > 1440) {{-- 1440 minutes = 24 hours --}}
                                {{ $createdAt->format('Y-m-d H:i:s') }} {{-- Display the full date and time --}}
                                @elseif ($now->diffInMinutes($createdAt) > 60) {{-- Check if the message is older than an hour --}}
                                {{ $now->diffInHours($createdAt) }} hours ago {{-- Display hours --}}
                                @else
                                {{ $now->diffInMinutes($createdAt) }} minutes ago
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>

</div>
</div>
</main>
<div class="modal fade" id="exampleModal1{{ $sub->ticketId }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/api/admin/solved/{{$sub->ticketId}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Comfirm solved problem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm Solved</button>
                </footer>
            </form>
        </div>
    </div>
</div>
</div>
@else

<h1>NO TICKETS AVAILABLE</h1>
@endif

@endsection
