<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-sm-4  ">
                <h1 class="pb-4">Verify Login Page</h1>
                <form action="/api/verify_login" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Email </label>
                        <input type="text" value="{{$user?$user->email:''}}" name="email" class="form-control" id="mobileOtp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Email Otp </label>
                        <input type="text" name="emailOtp" class="form-control" id="mobileOtp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Phone Otp </label>
                        <input type="text" name="mobileOtp" class="form-control" id="mobileOtp">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
