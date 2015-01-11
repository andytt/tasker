<div id="modal-add-task" class="modal">
    <form action="Url::to('/tasks')" method="POST">
        <div class="row">
            <div class="input-field col s12">
                <input id="task_title" type="text" name="title">
                <label for="task_title">Title</label>
            </div>
            <div class="input-field col s12">
                <input id="task_description" type="text" name="description">
                <label for="task_description">Description</label>
            </div>
            <div class="input-field col s12">
                <label for="task-date">Due Date</label>
                <br>
                <input type="text" class="datepicker" id="task-date" name="date">
            </div>
            <div class="input-field col s6">
                <p>
                    <input name="quadrant" type="radio" value="1" id="task-quadrant-1" />
                    <label for="task-quadrant-1">Important and emergency.</label>
                </p>
                <p>
                    <input name="quadrant" type="radio" value="3" id="task-quadrant-3" />
                    <label for="task-quadrant-3">Emergency but not important.</label>
                </p>
            </div>
            <div class="input-field col s6">
                <p>
                    <input name="quadrant" type="radio" value="2" id="task-quadrant-2"  />
                    <label for="task-quadrant-2">Important but not emergency.</label>
                </p>
                <p>
                    <input name="quadrant" type="radio" value="4" id="task-quadrant-4"/>
                    <label for="task-quadrant-4">Not emergency and not important.</label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <p><button type="submit" class="waves-effect waves-light btn">Add</button></p>
            </div>
        </div>
    </form>
</div>
