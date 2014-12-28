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

        /* Global Helpers */
        $('.global-helper-container').children().hide();
        $('.btn-global-helper-expand').show();

        $('.global-helper-container').on('mouseenter', function () {
            $(this).find('button').show('fast').filter('.btn-global-helper-expand').hide('fast');

            $(this).find('.btn-global-helper-question').on('click', function (e) {
                e.preventDefault();
                window.introJs().setOptions({
                    showProgress: false,
                    showStepNumbers: false
                }).start();
            });
        }).on('mouseleave', function () {
            $(this).find('button').hide('fast').filter('.btn-global-helper-expand').show('fast');

            $(this).find('.btn-global-helper-question').off('click');
        });

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
