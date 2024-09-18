<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .form-wrapper {
            display: flex;
            flex-direction: row;
            height: 100%;
        }

        .left-section {
            flex: 1;
            background-color: #3B4CB8;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .left-section h1 {
            margin-bottom: 10px;
        }

        .left-section a {
            color: white;
            text-decoration: none;
        }

        .left-section form {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 400px;
        }

        .left-section form input {
            margin-bottom: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        label {
            /* margin-bottom: 4px; */
            color: #bcdde7;
            font-size: 13px
        }

        .left-section form button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #7A96D5;
            color: white;
            cursor: pointer;
            margin-top: 20px;
            transition: .3s;
            font-weight: 600
        }

        .left-section form button:hover {
            background-color: #3749a3;
        }

        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-section img {
            max-width: 100%;
            height: auto;
        }

        .link a {
            font-size: 14px;
            color: rgb(241, 239, 239);
            margin-right: 10px !important;
        }

        .link a:hover {
            color: rgb(147, 191, 236);
            border-bottom: 1px solid rgb(147, 191, 236);
        }

        @media (max-width: 767px) {
            .form-wrapper {
                flex-direction: column;
                height: auto;
            }

            .left-section form input {
                margin-bottom: 10px;
                padding: 10px;
                font-size: 12px;
                border: none;
                border-radius: 5px;
            }

            label {
                font-size: 14px;
                /* margin-bottom: 4px; */
                color: #bcdde7;
            }

            .right-section {
                order: -1;
                /* Ensures the logo appears above the form */
                padding: 20px;
            }

            .left-section h1 {
                font-size: 28px;
            }

            .left-section p {
                font-size: 14px;
            }

            .right-section img {
                width: 50px;
                height: auto;
            }
        }

        @media (min-width: 768px) {

            .left-section form input {
                margin-bottom: 10px;
                padding: 10px;
                font-size: 12px;
                border: none;
                border-radius: 5px;
            }

            label {
                font-size: 14px;
                /* margin-bottom: 4px; */
                color: #bcdde7;
            }

            .form-wrapper {
                flex-direction: row;
                height: 100%;
                /* Ensure height is 100% for larger screens */
            }

            .right-section {
                order: 2;
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .left-section h1 {
                font-size: 28px;
            }

            .left-section p {
                font-size: 14px;
            }

            .left-section {
                order: 1;
                flex: 1;
            }
        }
    </style>
</head>

<body>
    <div class="form-wrapper">
        <div class="right-section">
            <img src="{{ asset('admin/dist/img/logo.JPG') }}" alt="Logo">
        </div>
        <div class="left-section">
            <h1>Let's you sign up</h1>
            <p>Welcome to Easy Rent</p>
            @if (Session::has('message'))
                <div class="alert alert-danger" role="alert">
                    <strong class="text-danger">{{ Session::get('message') }}!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12" class="form-group">
                        <label for="">Name </label>
                        <input type="text" placeholder="Full Name" class="form-control" name="name"
                            required>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12" class="form-group">
                        <label for="">Phone </label>
                        <input type="text" placeholder="Valid Phone" class="form-control" name="phone"
                            required>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12" class="form-group">
                        <label for="">Address </label>
                        <input type="text" placeholder="Address" class="form-control" name="address" required>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12" class="form-group">
                        <label for="">NID / NRC Number </label>
                        <input type="text" placeholder="NID / NRC Number" class="form-control" name="nid_no"
                            required>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12" class="form-group">
                        <label for="">Email</label>
                        <input type="email" placeholder="Valid Email" class="form-control" name="email"
                            required>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12" class="form-group">
                        <label for="">Password </label>
                        <input type="password" placeholder="Password" class="form-control" name="password" required>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12" class="form-group">
                        <label for="">Password Confirmation </label>
                        <input type="password" placeholder="Retype Password" class="form-control"
                            name="password_confirmation" required>
                    </div>
                </div>
                <span style="color: #f96d27; font-size:11px;; margin-top:-5px; font-weight: 600;">Info: All fields are
                    required. Email will unique.</span>

                <button type="submit">Sign Up</button>
            </form>

            <div class="d-flex justify-content-between link">
                <a href="{{ route('login_form') }}" class="text-center ">I have already a membership</a>
            </div>
        </div>
    </div>
</body>

</html>
