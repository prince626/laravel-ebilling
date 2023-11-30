@extends('master')
@section('content')
<style>
    .form {
        max-width: calc(100vw - 40px);
        width: 500px;
        height: auto;
        background: rgba(255, 255, 255, 1);
        border-radius: 8px;
        box-shadow: 0 0 40px -10px #fff;
        margin: 3% auto;
        padding: 20px 30px;
        box-sizing: border-box;
        position: relative;
    }

    form:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 8px;
    }

    .form h2 {
        margin: 18px 0;
        padding-bottom: 10px;
        width: 210px;
        color: #1e439b;
        font-size: 22px;
        border-bottom: 3px solid #ff5501;
        font-weight: 600;
        margin-bottom: 30px;
    }

    input {
        width: 60%;
        padding: 10px;
        box-sizing: border-box;
        background: none;
        outline: none;
        resize: none;
        border: 0;
        font-family: 'Montserrat', sans-serif;
        border: 2px solid #bebed2;
        transition: all .3s;
    }

    .form p:before {
        content: attr(type);
        display: block;
        margin: 10px 0 0;
        font-size: 13px;
        color: #5a5a5a;
        float: left;
        width: 40%;
        transition: all .3s;
    }

    /* button {
        padding: 8px 12px;
        margin: 8px 0 0;
        font-family: 'Montserrat', sans-serif;
        border: 2px solid #78788c;
        background: 0;
        color: #5a5a6e;
        cursor: pointer;
        transition: all .3s;
    } */

    button:hover {
        background: #78788c;
        color: #fff;
    }

    .tright {
        text-align: right;
    }

    .ui-menu {
        max-height: 150px;
        overflow: auto;
    }

    .ui-menu .ui-menu-item {
        padding: 5px;
        font-size: 14px;
    }

    .relative {
        position: relative;
    }

    .relative i.fa:before {
        color: #444;
        padding: 10px;
        position: absolute;
        left: -3px;
        text-align: center;
    }

    .relative i.fa {
        position: absolute;
        top: 0;
        right: 0;
        width: 40px;
        text-align: center;
        border-radius: 0 4px 4px 0;
        width: 0;
        height: 0;
        z-index: 99;
        border-left: 20px solid transparent;
        border-right: 30px solid #ccc;
        border-bottom: 34px solid #ccc;
        transition: all 0.15s ease-in-out;

    }

    .form-control:focus {
        border-color: #1e439b;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(30, 102, 195);
    }

    .relative input:focus+i.fa {
        border-left: 20px solid transparent;
        border-right: 30px solid #1e439b;
        border-bottom: 34px solid #1e439b;
    }

    .relative input:focus+i.fa:before {
        color: #fff;
    }

    .input-group .form-control:not(:first-child):not(:last-child),
    .input-group-addon:not(:first-child):not(:last-child),
    .input-group-btn:not(:first-child):not(:last-child) {
        border-radius: 0 4px 4px 0;
    }

    .form-control[disabled],
    .form-control[readonly],
    fieldset[disabled] .form-control {
        background-color: #fff;
    }

    /* --- Thanks Message Popup --- */
    .thanks {
        max-width: calc(100vw - 40px);
        width: 200px;
        height: auto;
        background-color: #444;
        border-radius: 8px;
        box-shadow: 0 0 40px -10px #000;
        padding: 20px;
        box-sizing: border-box;
        position: relative;
        position: absolute;
        top: 20px;
        right: 20px;
        transition: all .3s;
    }

    .thanks h4,
    .thanks p {
        color: #fff;
        text-align: center;
    }

    /* --- Animated Buttons --- */
    .movebtn {
        background-color: transparent;
        display: inline-block;
        width: 100px;
        background-image: none;
        padding: 8px 10px;
        margin-bottom: 20px;
        border-radius: 0;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        transition: all 0.5s;
        -webkit-transition-timing-function: cubic-bezier(0.5, 1.65, 0.37, 0.66);
        transition-timing-function: cubic-bezier(0.5, 1.65, 0.37, 0.66);
    }

    .movebtnre {
        border: 2px solid #ff5501;
        box-shadow: inset 0 0 0 0 #ff5501;
        color: #ff5501;
    }

    .movebtnsu {
        border: 2px solid #1e439b;
        box-shadow: inset 0 0 0 0 #1e439b;
        color: #1e439b;
    }

    .movebtnre:focus,
    .movebtnre:hover,
    .movebtnre:active {
        background-color: transparent;
        color: #FFF;
        border-color: #ff5501;
        box-shadow: inset 96px 0 0 0 #ff5501;
    }

    .movebtnsu:focus,
    .movebtnsu:hover,
    .movebtnsu:active {
        background-color: transparent;
        color: #FFF;
        border-color: #1e439b;
        box-shadow: inset 96px 0 0 0 #1e439b;
    }


    /* --- Media Queries --- */

    @media only screen and (max-width: 600px) {
        p:before {
            content: attr(type);
            width: 100%
        }

        input {
            width: 100%;
        }
    }

</style>
<main id="main" class="main">

<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="col-sm-4  ">
            {{-- <h1 class="pb-4">Update Page</h1> --}}
            <form class="form" action="/api/user/update/{{$user->user_id}}" method="POST">
                @csrf
                <h2>Update Profile</h2>
                <div class="form-group">
                    <label for="email">Full Name:</label>
                    <div class="relative">
                        <input class="form-control" id="name" name="name" value={{ $user->name }} type="text" pattern="[a-zA-Z\s]+" required="" autofocus="" title="Username should only contain letters. e.g. Piyush Gupta" autocomplete="" placeholder="Type your name here...">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <div class="relative">
                        <input class="form-control" type="email" name="email" value="{{ $user->email }}" required="" placeholder="Type your email address..." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Contact Number:</label>
                    <div class="relative">
                        <input class="form-control" type="text" name="phone" maxlength="10" value="{{ $user->phone }}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required="" placeholder="Type your Mobile Number...">
                        <i class="fa fa-phone"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Company Name:</label>
                    <div class="relative">
                        <input class="form-control" type="text" name="companyName" value="{{ $user->companyName }}" required="" placeholder="Mention your company name...">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Category Code:</label>
                    <div class="relative">
                        <input class="form-control" type="text" name="category" value="{{ $user->category }}" required placeholder="Mention your company name...">
                        <i class="fa fa-solid fa-code"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <div class="relative">
                        <input class="form-control" type="text" id="address" name="address" value="{{ $user->address }}" required="" placeholder="Type your address...">
                        <i class="fa fa-solid fa-address-card"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">City:</label>
                    <div class="relative">
                        <input class="form-control" type="text" id="tags" required="" name="city" value="{{ $user->city }}" placeholder="Type your city...">
                        <i class="fa fa-solid fa-city"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Password:</label>
                    <div class="relative">
                        <input class="form-control" name="password" type="text" id="tags" required="" value={{ App\Helpers\HashHelper::decrypt($user->password) }} placeholder="Type your password...">
                        <i class="fa fa-solid fa-lock"></i>
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label for="email">Attachment:</label>
                    <div class="relative">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-default">
                                    Browse&hellip; <input type="file" style="display: none;" multiple>
                                </span>
                            </label>
                            <input type="text" class="form-control" required="" placeholder="Attachment..." readonly>
                            <i class="fa fa-link"></i>
                        </div>
                    </div>
                </div> --}}

                <div class="tright">
                    <a href=""><button class="movebtn movebtnre" type="Reset"><i class="fa fa-fw fa-refresh"></i> Reset </button></a>
                    <a href=""><button class="movebtn movebtnsu" type="Submit">Submit <i class="fa fa-fw fa-paper-plane"></i></button></a>
                </div>
            </form>

            <div class="thanks" style="display: none;">
                <h4>Thank you!</h4>
                <p><small>Your message has been successfully sent.</small></p>
            </div>
            {{-- <form action="/api/user/update/{{$user->user_id}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value={{ $user->name }} id="name" aria-describedby="emailHelp">
            </div>


            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" value={{ $user->email }} id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">companyName address</label>
                <input type="text" name="companyName" class="form-control" value={{ $user->companyName }} id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">phone</label>
                <input type="text" name="phone" class="form-control" value={{ $user->phone }} id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputEma1" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value={{ $user->address }} aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEma1" class="form-label">City</label>
                <input type="text" name="city" class="form-control" value={{ $user->city }} aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEma1" class="form-label">password</label>
                <input type="password" name="password" class="form-control" value={{ App\Helpers\HashHelper::decrypt($user->password) }} aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Category Name</label>
                <input type="text" name="category" class="form-control" value={{ $user->category }} aria-describedby="emailHelp">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            </form> --}}
        </div>
    </div>
</div>
<script>
    $(function() {

        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this)
                , numFiles = input.get(0).files ? input.get(0).files.length : 1
                , label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready(function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text')
                    , log = numFiles > 1 ? numFiles + ' files selected' : label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });
        });
    });

    // Function for Specilization Input
    $(function() {
        var availableTags = [
            "ActionScript"
            , "AppleScript"
            , "Asp"
            , "BASIC"
            , "C"
            , "C++"
            , "Clojure"
            , "COBOL"
            , "ColdFusion"
            , "Erlang"
            , "Fortran"
            , "Groovy"
            , "Haskell"
            , "Java"
            , "JavaScript"
            , "Lisp"
            , "Perl"
            , "PHP"
            , "Python"
            , "Ruby"
            , "Scala"
            , "Scheme"
        ];
        $("#tags").autocomplete({
            source: availableTags
        });
    });

    // Function for Designation Input
    $(function() {
        var availableTags = [
            "Analyst L1"
            , "Analyst L2"
            , "Senior Analyst"
            , "UI Developer L1"
            , "UI Developer L2"
            , "Senior UI Developer"
            , "Graphics Designer L1"
            , "Graphics Designer L2"
            , "Senior Graphics Designer"
        , ];
        $("#designation").autocomplete({
            source: availableTags
        });
    });

    $('form').submit(function() {
        $('.thanks').show();
        $('.thanks').delay(2000).fadeOut();
        window.setInterval(function() {
            window.location.reload();
            $('form input#name').focus();
        }, 2500);
        event.preventDefault(); // Here triggering stops
    });

    // Autocomplete for Specialization
    $("#tags").autocomplete({
        source: tags,
        //To select only from the autocomplete
        change: function(event, ui) {
            if (ui.item == null || ui.item == undefined) {
                $(this).val("");
                $(this).attr("disabled", false);
            }
        }
    });

    // Autocomplete for Designation
    $("#designation").autocomplete({
        source: tags,
        //To select only from the autocomplete
        change: function(event, ui) {
            if (ui.item == null || ui.item == undefined) {
                $(this).val("");
                $(this).attr("disabled", false);
            }
        }
    });

</script>
</main>
@endsection
