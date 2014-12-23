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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nanoscroller/0.8.4/javascripts/jquery.nanoscroller.min.js"></script>
    <script>
        (function ($, document, window) {
            'use strict';

            $(function () {
                /* Initialization */
                $(window).on('resize', (function initNanoScroller() {
                    var halfHeight = ($(window).outerHeight(true) - parseInt($('#quadrant-2').css('border-bottom-width'), 10)) / 2;
                    $('.quadrant').height(halfHeight);

                    $('.nano').nanoScroller({
                        iOSNativeScrolling: true,
                        preventPageScrolling: true
                    });

                    return initNanoScroller;
                })());
                $('.quadrant').droppable({
                    scope: 'task',
                    drop: function (e, ui) {
                        var taskId = ui.draggable.attr('data-task-id'),
                            quadrant = $(this).attr('data-quadrant');

                        $.ajax('/tasks/' + taskId, {
                            method: 'PUT',
                            data: {
                                quadrant: quadrant
                            }
                        }).then(function () {
                            loadTask(taskId);
                            ui.draggable.parent().hide('fast', function () {
                                $(this).remove();
                            });
                        }.bind(this));
                    }
                });
                loadTasks();

                /* Quadrant Events */
                $('.quadrant')
                .on('mouseover', function () {
                    /* Show toolbar of current quadrant */
                    $(this).find('.task-container-toolbar').show('fast');

                    /* Bind mouse events on each task */
                    $(this).find('.task')
                    .on('mouseover', function () {
                        $(this).draggable({
                            scope: 'task',
                            helper: 'clone',
                            revert: 'invalid',
                            appendTo: 'body',
                            create: function () {
                                $(this).css('width', $(this).outerWidth());
                            }
                        });

                        /* Show footer of current task */
                        $(this).find('.task-footer').show('fast');

                        /* Bind events on footer of current task */
                        $(this).find('.task-btn-complete').off('click').on('click', function () {
                            var taskId = $(this).attr('data-task-id');

                            $.ajax('/tasks/' + taskId, {
                                method: 'PUT',
                                data: {
                                    complete: true
                                }
                            }).then(function () {
                                $(this).closest('.task').parent().hide('fast', function () {
                                    $(this).remove();
                                });
                            }.bind(this));
                        });

                        /* Bind events on footer of current task */
                        $(this).find('.task-btn-destroy').off('click').on('click', function () {
                            var taskId = $(this).attr('data-task-id');

                            $.ajax('/tasks/' + taskId, {
                                method: 'DELETE'
                            }).then(function () {
                                $(this).closest('.task').parent().hide('fast', function () {
                                    $(this).remove();
                                });
                            }.bind(this));
                        });
                    })
                    .on('mouseleave', function () {
                        $(this).removeAttr('style');
                        if ($(this).draggable('instance') !== undefined) {
                            $(this).draggable('destroy');
                        }

                        /* Unbind events on footer of current task */
                        $(this).find('.task-btn-complete').off('click');

                        /* Unbind events on footer of current task */
                        $(this).find('.task-btn-destroy').off('click');

                        /* Hide footer of current task */
                        $(this).find('.task-footer').hide('fast');
                    });
                })
                .on('mouseleave', function () {
                    /* Unbind mouse events on each task */
                    $(this).find('.task').off('mouseover').off('mouseleave');

                    /* Hide toolbar of current quadrant */
                    $(this).find('.task-container-toolbar').hide('fast');
                });

                /* Modal Events */
                $('.modal-add-task')
                .on('show.bs.modal', function (e) {
                    var $modal = $(this),
                        $button = $(e.relatedTarget);

                    $modal.find('form').on('submit', function (e) {
                        e.preventDefault();

                        var task = {};

                        /* Collect task infos */
                        $(this).serializeArray().forEach(function (input) {
                            task[input.name] = input.value;
                        });

                        /* Collect task quadrant */
                        task['quadrant'] = parseInt($button.attr('data-quadrant'), 10);

                        /* Submit (AJAX) task */
                        $.post('/tasks', task, function (task) {
                            insertTask(task);
                            $modal.modal('hide');
                        }, 'JSON');
                    });
                })
                .on('hide.bs.modal', function (e) {
                    var $modal = $(this);

                    $modal.find('form').off('submit');
                });
            });

            function insertTask(task) {
                var $dest = $('#quadrant-' + task.quadrant).find('.task-container');

                $.get('/tasks/' + task.id, function (task) {
                    $dest.append(task);
                }, 'html');
            }

            function loadTasks() {
                for (var i = 1; i <= 4; i++) {
                    $.getJSON('/tasks/quadrant/' + i, function (tasks) {
                        tasks.forEach(function (task) {
                            insertTask(task);
                        });
                    });
                }
            }

            function loadTask(taskId) {
                $.getJSON('/tasks/' + taskId, function (task) {
                    insertTask(task);
                });
            }
        })(window.jQuery, document, window);
    </script>
</body>
</html>
