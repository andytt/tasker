<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.nanoscroller/0.8.4/css/nanoscroller.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/intro.js/1.0.0/introjs.min.css">
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
            left: 0;
            right: 0;
            background-color: #F0ED8C;
            border-top: 0;
            width: 100%;
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

        .global-helper-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background-color: #000;
            padding: 5px;
            border-radius: 100px;
        }

        .global-helper-container .btn-global-helper-expand {

        }

        .global-helper-container .btn-global-helper-compress {
            display: none;
        }

        .global-helper-container .btn {
            background-color: #fff;
            color: #000;
            border-radius: 100px;
        }

        .global-helper-container .btn:hover {
            color: #000;
        }

        .global-helper-container .btn:focus {
            outline: none;
        }

        .introjs-helperLayer {
            background-color: rgba(255, 255, 255, .5);
        }

        .introjs-tooltipbuttons {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            background-color: transparent;
        }

        .introjs-button {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
                touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
               -moz-user-select: none;
                -ms-user-select: none;
                    user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .introjs-button:hover {
            color: #333;
            text-decoration: none;
        }

        .introjs-button:focus {
            color: #333;
            text-decoration: none;
            background-color: transparent !important;
            background-image: none !important;
            outline: thin dotted;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        .introjs-button:active {
            color: #333;
            text-decoration: none;
            background-image: none;
            outline: 0;
            -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
                    box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
        }

        .introjs-skipbutton, .introjs-prevbutton, .introjs-nextbutton {
            background-color: transparent;
        }

        .introjs-disabled, .introjs-disabled:hover, .introjs-disabled:focus {
            pointer-events: none;
            cursor: not-allowed;
            filter: alpha(opacity=65);
            -webkit-box-shadow: none;
                    box-shadow: none;
            opacity: .65;
        }
    </style>
</head>
<body class="container-fluid">

    <!-- Global Helper -->
    <div class="global-helper-container">
        <button class="btn btn-global-helper-expand"><i class="fa fa-expand"></i></button>
        <button class="btn btn-global-helper-compress"><i class="fa fa-compress"></i></button>

        <button class="btn btn-global-helper-question"><i class="fa fa-question-circle"></i></button>
    </div>

    <!-- Tasks -->
    <div class="row">
        <div id="quadrant-2" class="col-md-6 quadrant" data-quadrant="2" data-intro="Most important and most emergency tasks." data-step="1" data-position="bottom-middle-aligned">
            <div class="nano"><div class="row task-container nano-content"></div></div>
            @include('task.containerToolbar', ['quadrant' => 2])
        </div>
        <div id="quadrant-1" class="col-md-6 quadrant" data-quadrant="1" data-intro="Most important but not emergency tasks." data-step="2" data-position="bottom-middle-aligned">
            <div class="nano"><div class="row task-container nano-content"></div></div>
            @include('task.containerToolbar', ['quadrant' => 1])
        </div>
    </div>
    <div class="row">
        <div id="quadrant-3" class="col-md-6 quadrant" data-quadrant="3" data-intro="Most emergency but not important tasks." data-step="3" data-position="top">
            <div class="nano"><div class="row task-container nano-content"></div></div>
            @include('task.containerToolbar', ['quadrant' => 3])
        </div>
        <div id="quadrant-4" class="col-md-6 quadrant" data-quadrant="4" data-intro="Not important and not emergency tasks." data-step="4" data-position="top">
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
    <script src="//cdn.jsdelivr.net/intro.js/1.0.0/intro.min.js"></script>
    @if (Auth::guest())
        @include('scripts.popupLoginModal')
    @else
        @include('scripts.main')
    @endif
</body>
</html>
