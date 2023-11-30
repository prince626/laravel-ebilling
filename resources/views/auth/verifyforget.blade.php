<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .php-email-form .error-message {
            display: none;
            color: #fff;
            background: #ed3c0d;
            text-align: left;
            padding: 15px;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .php-email-form .sent-message {
            display: none;
            color: #fff;
            background: #18d26e;
            text-align: center;
            padding: 15px;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .php-email-form .loading {
            display: none;
            background: #fff;
            text-align: center;
            padding: 15px;
            margin-bottom: 24px;
        }

        .php-email-form .loading:before {
            content: "";
            display: inline-block;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            margin: 0 10px -6px 0;
            border: 3px solid #18d26e;
            border-top-color: #eee;
            animation: animate-loading 1s linear infinite;
        }

        .php-email-form input,
        .php-email-form textarea {
            border-radius: 0;
            box-shadow: none;
            font-size: 14px;
            border-radius: 0;
        }

        .php-email-form input:focus,
        .php-email-form textarea:focus {
            border-color: #4154f1;
        }

        /* .php-email-form input {
  padding: 10px 15px;
} */

        .php-email-form textarea {
            padding: 12px 15px;
        }

        .php-email-form button[type=submit] {
            background: #4154f1;
            border: 0;
            padding: 10px 30px;
            color: #fff;
            transition: 0.4s;
            border-radius: 4px;
        }

        .php-email-form button[type=submit]:hover {
            background: #5969f3;
        }
        body{
            background: #f6f9ff;


        }
        .Reset-form {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-sm-4  Reset-form">
                <h1 class="pb-4 text-center">Reset Password</h1>
                <form action="/api/verify_forget" method="POST" class="php-email-form">
                    @csrf
                    <div class="mb-3" style="display:none;">
                        <label for="exampleInputPassword1" class="form-label">Email </label>
                        <input type="text" value="{{$user}}" name="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Email Otp<span class="text-danger">*</span> </label>
                        <input type="text" name="emailOtp" class="form-control" id="mobileOtp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Phone Otp<span class="text-danger">*</span> </label>
                        <input type="text" name="mobileOtp" class="form-control" id="mobileOtp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">New Password<span class="text-danger">*</span> </label>
                        <input type="password" name="password" class="form-control" id="mobileOtp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Comfirm Password<span class="text-danger">*</span> </label>
                        <input type="password" name="cpassword" class="form-control" id="mobileOtp">
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">
                            <span class="dynamic-message">Your message has been sent. Thank you!</span>
                        </div>

                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        (function() {
            "use strict";

            let forms = document.querySelectorAll('.php-email-form');

            forms.forEach(function(e) {
                e.addEventListener('submit', function(event) {
                    event.preventDefault();

                    let thisForm = this;

                    let action = thisForm.getAttribute('action');
                    let recaptcha = thisForm.getAttribute('data-recaptcha-site-key');


                    thisForm.querySelector('.loading').classList.add('d-block');
                    // thisForm.querySelector('.error-message').classList.remove('d-block');
                    thisForm.querySelector('.sent-message').classList.remove('d-block');

                    let formData = new FormData(thisForm);

                    if (recaptcha) {
                        if (typeof grecaptcha !== "undefined") {
                            grecaptcha.ready(function() {
                                try {
                                    grecaptcha.execute(recaptcha, {
                                            action: 'php_email_form_submit'
                                        })
                                        .then(token => {
                                            formData.set('recaptcha-response', token);
                                            php_email_form_submit(thisForm, action, formData);
                                        })
                                } catch (error) {
                                    displayError(thisForm, error);
                                }
                            });
                        } else {
                            displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
                        }
                    } else {
                        php_email_form_submit(thisForm, action, formData);
                    }
                });
            });

            function php_email_form_submit(thisForm, action, formData) {
                fetch(action, {
                        method: 'POST'
                        , body: formData
                        , headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {

                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error(`${response.status} ${response.statusText} ${response.url}`);
                        }
                    })
                    .then(data => {
                        thisForm.querySelector('.loading').classList.remove('d-block');
                        let dynamicMessageContainer = thisForm.querySelector('.dynamic-message');
                        if (data.success) {
                            dynamicMessageContainer.textContent = data.status;
                            // dynamicMessageContainer.value = data.status;
                            console.log('status', data.status);
                            thisForm.querySelector('.sent-message').classList.add('d-block');

                            if (data.status == 'success') {
                                window.location.href = `http://localhost:8000/login`;
                            }
                            // else {
                            //     thisForm.reset();
                            //     location.reload();
                            //     // window.location.href = 'http://localhost:8000/api/user/get_tickets'; 
                            // }
                        } else {
                            throw new Error(data ? data.status + ' ' + data.data : 'Form submission failed and no error message returned from: ' + action);
                        }
                    })
                    .catch((error) => {
                        displayError(thisForm, error);
                        setTimeout(function() {
                            thisForm.querySelector('.error-message').innerHTML = null;
                            thisForm.querySelector('.error-message').classList.remove('d-block');
                        }, 3000);
                    });
            }

            function displayError(thisForm, error) {
                thisForm.querySelector('.loading').classList.remove('d-block');
                thisForm.querySelector('.error-message').innerHTML = error;
                thisForm.querySelector('.error-message').classList.add('d-block');

            }

        })();

    </script>
</body>
</html>
