@extends('master')

@section('content')
<main id="main" class="main">

    @if (isset($activity) && count($activity) > 0)
    <div class="pagetitle">
        <h1>My Activity</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/api/user/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" style="cursor: pointer;">Activity</li>
            </ol>
        </nav>
    </div>

    <div class="card ">
        <div class="card-header">
            <i class="fa fa-table"></i> Activity Data Table
        </div>
        <div class="card-body mt-3">
            <div class="table-responsive">
                <table class="table dataTable " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th> ID</th>
                            <th>DATETIME</th>
                            <th>ACTION</th>
                            <th>ACTION PERFORMED</th>
                            

                        </tr>
                    </thead>
                   
                    <tbody>
                        @foreach ($activity as $activity)
                        <tr>
                            <td class="align-middle"><strong>#{{ $activity->sno }}</strong></td>
                            <td class="align-middle">{{ $activity->created_at }}</td>

                            <td class="align-middle">{{ $activity->action_type }}</td>
                            <td class="align-middle">{{ $activity->action_performed }}</td>

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
