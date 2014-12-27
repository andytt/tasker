<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.nanoscroller/0.8.4/css/nanoscroller.css">
    <style>
        body {
            background-color: #000;
        }

        body:before, body::before {
            content: " ";
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            opacity: .2;
            background-color: #fff;
        }

        .modal-login-form .modal-content, .modal-signup-form .modal-content {
            background-color: #F0ED8C;
        }

        .modal-login-form input, .modal-signup-form input {
            border: 0;
        }

        .modal-login-form button, .modal-signup-form button {
            background-color: #F0ED8C;
            border: 0;
            color: #7B770C;
            outline: none;
        }

        .modal-login-form .bg-info {
            border-radius: 30px;
        }

        .task-container {
            position: relative;
            padding: 10px;
        }

        .task-container-toolbar {
            display: none;
            position: absolute;
            padding-top: 5px;
            padding-bottom: 5px;
            top: auto;
            bottom: 10px;
            background-color: #83826C;
            border-radius: 5px;
            opacity: .8;
        }

        .task-container-toolbar .btn {
            background-color: transparent;
            border: 0;
            color: #fff;
        }

        .task {
            position: relative;
            background-color: #F0ED8C;
        }

        .task-heading {
            background-color: #F0ED8C;
        }

        .task-title {
        }

        .task-description {
        }

        .task-footer {
            display: none;
            position: absolute;
            top: auto;
            bottom: 0;
            left: auto;
            right: 0;
            background-color: #F0ED8C;
            border-top: 0;
            width: 50%;
        }

        .task-btn, .task:focus {
            background-color: #F0ED8C;
            border: 0;
            color: #7B770C;
            outline: none;
        }

        .modal-add-task .modal-content {
            background-color: #F0ED8C;
        }

        .modal-add-task input {
            border: 0;
        }

        .modal-add-task button {
            background-color: #F0ED8C;
            border: 0;
            color: #7B770C;
            outline: none;
        }

        #quadrant-2 {
            border: 0;
        }

        #quadrant-2::after {
            position: absolute;
            content: " ";
            bottom: 0;
            top: auto;
            left: auto;
            right: 0;
            height: 50%;
            border-right: 1px solid #fff;
        }

        #quadrant-2::before {
            position: absolute;
            content: " ";
            bottom: 0;
            top: auto;
            left: auto;
            right: 0;
            width: 50%;
            border-bottom: 1px solid #fff;
        }

        #quadrant-1 {
            border: 0;
        }

        #quadrant-1::before {
            position: absolute;
            content: " ";
            bottom: 0;
            top: auto;
            left: 0;
            right: auto;
            width: 50%;
            border-bottom: 1px solid #fff;
        }

        #quadrant-3 {
            border: 0;
        }

        #quadrant-3::after {
            position: absolute;
            content: " ";
            bottom: auto;
            top: 0;
            left: auto;
            right: 0;
            height: 50%;
            border-right: 1px solid #fff;
        }

        #quadrant-4 {
            border: 0;
        }
    </style>
</head>
<body class="container-fluid">

    <!-- Tasks -->
    <div class="row">
        <div id="quadrant-2" class="col-md-6 quadrant" data-quadrant="2">
            <div class="nano"><div class="row task-container nano-content"></div></div>
            @include('task.containerToolbar', ['quadrant' => 2])
        </div>
        <div id="quadrant-1" class="col-md-6 quadrant" data-quadrant="1">
            <div class="nano"><div class="row task-container nano-content"></div></div>
            @include('task.containerToolbar', ['quadrant' => 1])
        </div>
    </div>
    <div class="row">
        <div id="quadrant-3" class="col-md-6 quadrant" data-quadrant="3">
            <div class="nano"><div class="row task-container nano-content"></div></div>
            @include('task.containerToolbar', ['quadrant' => 3])
        </div>
        <div id="quadrant-4" class="col-md-6 quadrant" data-quadrant="4">
            <div class="nano"><div class="row task-container nano-content"></div></div>
            @include('task.containerToolbar', ['quadrant' => 4])
        </div>
    </div>

    <!-- Modals -->
    @include('task.addTaskModal')
    @if (Auth::guest())
        @include('user.loginModal')
        @include('user.signupModal')
    @endif

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nanoscroller/0.8.4/javascripts/jquery.nanoscroller.min.js"></script>
    @if (Auth::guest())
        @include('scripts.popupLoginModal')
    @else
        @include('scripts.main')
    @endif
</body>
</html>
