@extends('master') {{-- Include your master layout if you have one --}}

@section('content')
{{-- @if($success)
<div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: absolute;top:100px;">
    <strong>Holy guacamole!</strong> {{ $success }}
</div>
@endif --}}
<main id="main" class="main">
    <h1>User Chat Conversation</h1>
    <section style="background-color: #eee;">
        <div class="container-fluid pt-3 ">

            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-12 col-xl-8">

                    <div class="card" id="chat2">
                        <div class="card-header d-flex align-items-center p-3">
                            <h5 class="mb-0">Chat</h5>
                            <div class="justify-content-end" style="flex:auto;text-align:end;">
                                <a href="/api/user/get_tickets"><button type="button" class="btn btn-primary  btn-sm justify-content-end" data-mdb-ripple-color="dark">Back
                                    </button></a>
                                <button type="button" class="btn btn-primary btn-sm" data-mdb-ripple-color="dark">Let's Chat
                                    App</button>
                            </div>
                        </div>
                        <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative;height: 50vh; overflow-y: auto;">
                            @if(isset($messages) && count($messages) > 0)
                            @foreach($messages as $message)

                            <div class="d-flex flex-row m-2 {{ $message->type==="Admin" ? 'justify-content-start' :' justify-content-end'}}">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1" style="width: 35px; height: 100%;">
                                <div>
                                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color:{{ $message->type === 'Admin' ? '#f5f6f7' : '#0d6efd' }}">{{ $message->message }}</p>
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
                        <form action=" http://localhost:8000/api/user/send/message/{{ $tickets->ticketId }}" method="POST" class="php-email-form card-footer text-muted d-flex justify-content-start align-items-center p-3">
                            @csrf

                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 3" style="width: 40px; height: 100%;">
                            <input type="text" required name="message" class="form-control mx-2" id="exampleFormControlInput1" placeholder="Type message">
                            {{-- <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a> --}}
                       
                            <button class=" text-muted fs-4" type="submit" style="background: none;border:none;"><i class="fas fa-paper-plane text-primary"></i></button>
                                 {{-- <a class="ms-3" type="submit"><i class="fas fa-paper-plane"></i></a> --}}
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
            </div>

        </div>
    </section>
    {{-- <div class="container-fluid mt-5 pt-3" style="border: 2px solid black; margin: 5rem auto !important;width:800px;border-radius: 20px;">
    <h2 class="text-center mb-3">USER CHAT</h2>
    <div class="chat-container">
        @if(isset($messages) && count($messages) > 0)
        <div class="messages">
            @foreach($messages as $message)
            <div class="message" style="text-align: {{ $message->type === 'Admin' ? 'left' : 'right' }}">
    <p style="background-color: transparent; display: inline-block; padding: 10px; border-radius: 5px; background-color: {{ $message->type === 'Admin' ? 'gray' : 'lightblue' }}; max-width:400px;"> {{ $message->message }}</p>

    <p style="font-size: 12px;margin-top:-8px;">
        @php
        $createdAt = Carbon\Carbon::parse($message->created_at, 'Asia/Kolkata');
        $now = Carbon\Carbon::now('Asia/Kolkata');
        @endphp

        @if ($now->diffInMinutes($createdAt) >= 1440)
        {{ $createdAt->format('Y-m-d H:i:s') }}
        @elseif ($now->diffInMinutes($createdAt) >= 60)
        {{ $now->diffInHours($createdAt) }} hours ago
        @elseif ($now->diffInMinutes($createdAt) >= 1)
        {{ $now->diffInMinutes($createdAt) }} minutes ago
        @else
        now
        @endif
    </p>
    </div>
    @endforeach
    </div>
    @else

    <h1>User has no chat</h1>
    @endif
    <form action=" http://localhost:8000/api/user/send/message/{{ $tickets->ticketId }}" method="POST" style="text-align: right">
        @csrf
        <div class="d-flex m-2">
            <input type="text" name="message" class="form-control me-3" placeholder="Type your message...">
            <button class="btn btn-primary" type="submit">Send</button>
        </div>

    </form>
    </div>

    </div> --}}
</main>
@endsection
