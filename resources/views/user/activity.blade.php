@extends('master')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>My Activity</h1>
        <nav class="pt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/api/user/dashboard" class="active">Dashboard</a></li>
                <li class="breadcrumb-item " style="cursor: pointer;">Activity</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header" style="border: none">
            <div class="card-title">
                <h5 class="card-label text-dark fw-medium"> Activity List
                    <span class="d-block text-muted pt-2 font-size-sm"> You can View Activity History Here</span></h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                
                <table id="example" class="table nowrap" style="width:100%">
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

</main>
@endsection
