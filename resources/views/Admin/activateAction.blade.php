@extends('master')

@section('content')
<div class="container-fluid  pt-5">
    @if(!$action)
    <h1>User has no Subscription</h1>
    @else
    <h1>Subscription Actions</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Subscription ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Plan Info</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($action as $sub)
                <tr>
                    <td>{{ $sub->user_id }}</td>
                    <td>{{ $sub->subs_id }}</td>
                    <td>{{ $sub->user_email }}</td>
                    <td>{{ $sub->user_phone }}</td>
                    <td>{{ $sub->planInfo }}</td>
                    {{-- <td>{{ $sub->action?'Activated':'Deactivated' }}</td> --}}
                    <td class="text-center">
                        @if ($sub->action)
                        <p class="text-success text-center " style="background: #8bd98e;
                        padding:4px;border-radius:8px;font-weight:bold;">Activated</p>
                        @else
                        <p class="text-danger text-center" style="background: #caa5a5;
                        padding:4px;border-radius:8px;font-weight:bold;">Deactivated</p>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
@endsection
