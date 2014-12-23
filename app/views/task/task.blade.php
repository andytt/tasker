<div class="col-md-4">
    <div class="panel task" data-task-id="{{ $task->getKey() }}">
        <div class="panel-heading task-heading">
            <div class="panel-title task-title">{{{ $task->title }}}</div>
        </div>
        <div class="panel-body task-description">{{{ $task->description }}}</div>
        <div class="text-center task-footer">
            <div class="btn-group" role="group">
                <button type="button" class="btn task-btn task-btn-complete" data-task-id="{{ $task->getKey() }}">
                    <i class="fa fa-check"></i>
                </button>
                <button type="button" class="btn task-btn task-btn-destroy" data-task-id="{{ $task->getKey() }}">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</div>
