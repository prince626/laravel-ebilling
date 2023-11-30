@extends('master')
@section('content')

<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="col-sm-4  ">
            <h1 class="pb-4">Change Password</h1>
            <form action="/api/user/change_password" method="POST">
                @csrf
                <div class="mb-3" style="display: none">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" value={{ $user->email }} id="email" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Current Password</label>
                    <input type="password" name="currentPassword" class="form-control" id="exampleInputPassword1">
                </div>
c
                <div class="mb-3">
                    <label for="exampleInputEma1" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEma1" class="form-label">Comfirm New Password</label>
                    <input type="password" name="cpassword" class="form-control" aria-describedby="emailHelp">
                </div>

                <div class="mb-2"> <a href="/forget_password" class="">Try another way</a></div>
                <div class="col-md-12 text-center">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">
                        <span class="dynamic-message">Your message has been sent. Thank you!</span>
                    </div>

                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
