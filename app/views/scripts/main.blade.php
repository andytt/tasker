<script>
(function ($, document, window) {
    'use strict';

    $(function () {
        /* Initialization */
        windowOnResizeHandler();
        loadTasks();
        initGlobalHelpers();
        initDatepicker($('.datepicker'));
        initTaskDroppable();
        listenOnAddTaskBtn();
        $(window).on('resize', windowOnResizeHandler);
        $(document)
        .on('mouseenter', '.task', taskOnEnterHandler)
        .on('mouseleave', '.task', taskOnLeaveHandler);

        /* Global Helpers */
        var globalHelperContainer = $('.global-helper-container');

        $('.js-btn-expand-global-helper').on('click', function (e) {
            e.preventDefault();

            globalHelperContainer.children().show();
            globalHelperContainer.find('.js-btn-expand-global-helper').hide();

            $('<div class="global-helper-backdrop"/>').insertAfter(globalHelperContainer).on('click', function (e) {
                e.preventDefault();
                $(this).remove();

                globalHelperContainer.children().hide();
                globalHelperContainer.find('.js-btn-expand-global-helper').show();
            });
        });

        $('.js-btn-collapse-global-helper').on('click', function (e) {
            e.preventDefault();

            globalHelperContainer.children().hide();
            globalHelperContainer.find('.js-btn-expand-global-helper').show();

            $('.global-helper-backdrop').remove();
        });

        $('.js-btn-start-intro').on('click', function (e) {
            e.preventDefault();

            window.introJs().setOptions({
                showProgress: false,
                showStepNumbers: false
            }).start();
        });
    });

    /* Methods */
    function insertTask(task) {
        var $dest = $('#quadrant-' + task.quadrant).find('.task-container'),
            tpl = _.template($('#tpl-task').html());

        task['colorClass'] = 'red';

        if (2 == task.quadrant) { task['colorClass'] = 'green'; }
        else if (3 == task.quadrant) { task['colorClass'] = 'white'; }
        else if (4 == task.quadrant) { task['colorClass'] = 'grey'; }


        $dest.append(tpl(task));
    }

    function loadTasks() {
        $.getJSON('/tasks', function (tasks) {
            _.forEach(tasks, function (task) {
                insertTask(task);
            });
        });
    }

    function loadTask(taskId) {
        $.getJSON('/tasks/' + taskId, function (task) {
            insertTask(task);
        });
    }

    function listenOnAddTaskBtn()
    {
        $('.js-btn-add-task').off('click').on('click', function (e) {
            var modalAddTask = $('#modal-add-task');
            modalAddTask.openModal();

            modalAddTask.find('form').off('submit').on('submit', function (e) {
                e.preventDefault();

                var task = {};

                /* Collect task infos */
                $(this).serializeArray().forEach(function (input) {
                    task[input.name] = input.value;
                });

                /* Submit (AJAX) task */
                createTask(task).then(function (task) {
                    insertTask(task);
                    modalAddTask.closeModal();
                });
            });
        });
    }

    function taskOnEnterHandler(e) {
        e.preventDefault();

        var $thisTask = $(this);

        $thisTask.find('.task-footer').show('fast');

        /* Init draggable */
        $thisTask.draggable({
            scope: 'task',
            helper: 'clone',
            revert: 'invalid',
            appendTo: 'body',
            create: function (e, ui) {
                $(this).css('min-width', '200px');
            },
            start: function () {
                $('<div class="global-helper-backdrop"/>').insertAfter($(this));
                $('.global-helper-container').hide();
            },
            stop: function () {
                $('.global-helper-backdrop').remove();
                $('.global-helper-container').show();
            }
        });

        $thisTask.find('.js-task-delete').off('click').on('click', function (e) {
            e.preventDefault();

            var taskId = $thisTask.attr('data-task-id');

            $.ajax('/tasks/' + taskId, {
                method: 'DELETE'
            }).then(function () {
                $thisTask.hide('fast', function () {
                    $thisTask.remove();
                });
            });
        });
    }

    function taskOnLeaveHandler(e) {
        e.preventDefault();

        var $thisTask = $(this);

        $thisTask.find('.task-footer').hide('fast');

        /* Remove style that create when task dragged */
        $thisTask.removeAttr('style');

        /* Unbind draggable */
        if (($thisTask).draggable('instance') !== undefined) {
            $thisTask.draggable('destroy');
        }
    }

    function createTask(task) {
        return $.post('/tasks', task);
    }

    function initDatepicker($target) {
        $target.pickadate({
            container: 'body',
            format: 'yyyy-mm-dd'
        });
    }

    function windowOnResizeHandler() {
        var halfHeight = ($(window).outerHeight(true)) / 2;

        $('.quadrant').height(halfHeight);

        $('.nano').nanoScroller({
            iOSNativeScrolling: true,
            preventPageScrolling: true
        });
    }

    function initTaskDroppable() {
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
                    ui.draggable.hide('fast', function () {
                        $(this).remove();
                    });
                }.bind(this));
            }
        });
    }

    function initGlobalHelpers() {
        var globalHelperContainer = $('.global-helper-container');
        globalHelperContainer.children().hide();
        globalHelperContainer.find('.js-btn-expand-global-helper').show();
    }
})(window.jQuery, document, window);
</script>
