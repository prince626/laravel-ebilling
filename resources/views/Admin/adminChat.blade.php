@extends('master') {{-- Include your master layout if you have one --}}

@section('content')
{{-- <div class="container-fluid mt-5 pt-3" style="border: 2px solid black; margin: 5rem auto !important;width:800px;border-radius: 20px;">
    <h1 class="text-center mb-4">ADMIN CHAT</h1>
    <div class="chat-container">
        <div class="messages">
            @foreach($messages as $message)
            <div class="message" style="text-align: {{ $message->type === 'Admin' ? 'right' : 'left' }}">

<p style="background-color: transparent; display: inline-block; padding: 10px; border-radius: 5px; background-color: {{ $message->type === 'Admin' ? 'lightblue' : 'gray' }};max-awidth:400px; "> {{ $message->message }}</p>
<p style="font-size: 12px;margin-top:-8px;">
    @php
    $createdAt = Carbon\Carbon::parse($message->created_at, 'Asia/Kolkata');
    $now = Carbon\Carbon::now('Asia/Kolkata');
    @endphp

    @if ($now->diffInMinutes($createdAt) > 1440)
    {{ $createdAt->format('Y-m-d H:i:s') }}
    @elseif ($now->diffInMinutes($createdAt) > 60)
    {{ $now->diffInHours($createdAt) }} hours ago
    @elseif ($now->diffInMinutes($createdAt) > 1)
    {{ $now->diffInMinutes($createdAt) }} minutes ago
    @else
    now
    @endif
</p>
</div>
@endforeach
</div>

<form action="/api/admin/send/message/{{ $ticket->ticketId }}" method="POST" style="text-align: right">

    @csrf
    <div class="d-flex m-2">
        <input type="text" name="message" class="form-control me-3" placeholder="Type your message...">
        <button class="btn btn-primary" type="messagemit">Send</button>
    </div>

</form>
</div>
</div> --}}
<section style="background-color: #eee;">
    <div class="container-fluid py-5">

        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">

                <div class="card" id="chat2">
                    <div class="card-header d-flex align-items-center p-3">
                        <h5 class="mb-0">Chat</h5>
                        <div class="justify-content-end" style="flex:auto;text-align:end;">
                            <a href="/api/admin/users_messages"><button type="button" class="btn btn-primary  btn-sm justify-content-end" data-mdb-ripple-color="dark">Back
                                </button></a>
                            <button type="button" class="btn btn-primary btn-sm" data-mdb-ripple-color="dark">Let's Chat
                                App</button>
                        </div>
                    </div>
                    <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative;height: 50vh; overflow-y: auto;">
                        @if(isset($messages) && count($messages) > 0)
                        @foreach($messages as $message)

                        <div class="d-flex flex-row m-2 {{ $message->type==="Admin" ? 'justify-content-end' :' justify-content-start'}}">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1" style="width: 35px; height: 100%;">
                            <div>
                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color:{{ $message->type === 'Admin' ? ' #0d6efd' : '#f5f6f7' }}">{{ $message->message }}</p>
                                <p class="ms-4" style="font-size: 12px;margin-top:-6px;">
                                    @php
                                    // Use a valid timestamp format (Y-m-d H:i:s) for Carbon::parse
                                    $createdAt = Carbon\Carbon::parse($message->created_at, 'Asia/Kolkata');
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
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @endif


                    </div>
                    <form action="/api/admin/send/message/{{ $ticket->ticketId }}" method="POST" class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                        @csrf

                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 3" style="width: 40px; height: 100%;">
                        <input type="text" required name="message" class="form-control form-control-lg" id="exampleFormControlInput1" placeholder="Type message">
                        <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                        <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                        {{-- <a class="ms-3" type="submit"><i class="fas fa-paper-plane"></i></a> --}}
                        <button class="btn" type="submit" style="background: none"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
