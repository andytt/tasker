<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasker</title>
    <link rel="stylesheet" href="/assets/vendor/materialize/dist/css/materialize.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.nanoscroller/0.8.4/css/nanoscroller.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/intro.js/1.0.0/introjs.min.css">
    <style>
        .fullpage-row {
            margin: 0;
        }

        .task-container {
            position: relative;
            padding: 10px;
        }

        .task {
            position: relative;
        }

        .task-footer {
            display: none;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(158, 158, 158, 0.6);
            width: 100%;
            height: 100%;
        }

        .task-footer > .row {
            position: absolute;
            top: auto;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: auto;
            margin: 0;
            text-align: center;
        }

        .task-footer > .row > a {
            opacity: .5;
        }

        .task-footer > .row > a:last-child {
            margin-right: 0;
        }

        .task-footer > .row > a:hover {
            opacity: 1;
        }

        #quadrant-1, #quadrant-2, #quadrant-3, #quadrant-4 {
            border: 0;
            outline: 0;
        }

        .nano > .nano-content:focus {
            outline: 0;
        }

        .global-helper-container {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
                    transform: translate(-50%, -50%);
            z-index: 1000;
        }

        .global-helper-backdrop {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            background-color: #424242;
            opacity: .5;
            z-index: 990;
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
<body class="grey lighten-1">

    <!-- Global Helper -->
    <div class="global-helper-container">
        <button class="js-btn-expand-global-helper btn-floating btn-large waves-effect waves-light blue"><i class="mdi-action-view-module"></i></button>

        <button class="js-btn-add-task btn-floating btn-large waves-effect waves-light blue"><i class="mdi-content-add"></i></button>
        <button class="js-btn-collapse-global-helper btn-floating btn-large waves-effect waves-light blue"><i class="mdi-content-clear"></i></button>
        <button class="js-btn-start-intro btn-floating btn-large waves-effect waves-light blue"><i class="mdi-action-help"></i></button>
    </div>

    <!-- Tasks -->
    <div class="row fullpage-row">
        <div id="quadrant-1" class="col m6 quadrant" data-quadrant="1" data-intro="Most important and most emergency tasks." data-step="1" data-position="bottom-middle-aligned">
            <div class="nano"><div class="row task-container nano-content"></div></div>
        </div>
        <div id="quadrant-2" class="col m6 quadrant" data-quadrant="2" data-intro="Most important but not emergency tasks." data-step="2" data-position="bottom-middle-aligned">
            <div class="nano"><div class="row task-container nano-content"></div></div>
        </div>
        <div id="quadrant-3" class="col m6 quadrant" data-quadrant="3" data-intro="Most emergency but not important tasks." data-step="3" data-position="top">
            <div class="nano"><div class="row task-container nano-content"></div></div>
        </div>
        <div id="quadrant-4" class="col m6 quadrant" data-quadrant="4" data-intro="Not important and not emergency tasks." data-step="4" data-position="top">
            <div class="nano"><div class="row task-container nano-content"></div></div>
        </div>
    </div>

    <!-- Modals -->
    @include('task.addTaskModal')

    <!-- Templates -->
    <script type="text/template" id="tpl-task">
        <div class="task col m4" data-task-id="<%- id %>" data-quadrant="<%- quadrant %>">
            <div class="card <%- colorClass %>" data-task-id="<%- id %>">
                <div class="card-content">
                    <p class="card-title"><span class="text-grey text-darken-4"><%- summary %></span></p>
                    <p class="text-grey text-darken-4"><%- description %></p>
                </div>
                <div class="task-footer">
                    <div class="row">
                        <a href="#" class="grey-text text-darken-4 js-task-delete"><i class="small mdi-action-delete"></i></a>
                        <a href="#" class="grey-text text-darken-4 js-task-delete"><i class="small mdi-action-done"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nanoscroller/0.8.4/javascripts/jquery.nanoscroller.min.js"></script>
    <script src="//cdn.jsdelivr.net/intro.js/1.0.0/intro.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>
    <script src="/assets/vendor/materialize/dist/js/materialize.js"></script>
    @include('scripts.main')
</body>
</html>
