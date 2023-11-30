@extends('master')

@section('content')
<div class="container-fluid  pt-5">
    @if(!$action)
    <h1>User has no Subscription</h1>
    @else
    <h1>Log Actions</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Action Type</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">User Agent</th>
                    <th scope="col">Status</th>
                    <th scope="col">Time Stamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($action as $sub)
                <tr>
                    <td>{{ $sub->user_id }}</td>
                    <td>{{ $sub->action_type }}</td>
                    <td>{{ $sub->ip_address }}</td>
                    <td>{{ $sub->user_agent }}</td>
                    {{-- <td>{{ $sub->action?'Activated':'Deactivated' }}</td> --}}
                    <td class="text-center">
                        @if ($sub->status)
                        <p class="text-success text-center " style="background: #8bd98e;
                        padding:4px;border-radius:8px;font-weight:bold;">Success</p>
                        @else
                        <p class="text-danger text-center" style="background: #caa5a5;
                        padding:4px;border-radius:8px;font-weight:bold;">False</p>
                        @endif
                    </td>
                    <td>{{ $sub->TimeStamp }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
@endsection
