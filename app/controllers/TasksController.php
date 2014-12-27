<?php

class TasksController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('auth', [
            'except' => ['index']
        ]);
    }

    public function index()
    {
        return View::make('task.index');
    }

    public function store()
    {
        if (!Request::ajax()) return Redirect::to('/');

        $title = Input::get('title', null);
        $description = Input::get('description', null);
        $quadrant = Input::get('quadrant', null);
        $user_id = Auth::user()->getKey();

        $task = Task::create(compact('title', 'description', 'quadrant', 'user_id'));

        return Response::json($task, 201);
    }

    public function show($taskId)
    {
        $task = Task::find($taskId);

        if ($task->user_id !== Auth::user()->getKey()) {
            if (Request::wantsJson()) {
                return Response::json(null, 403);
            } else {
                return View::make('task.index');
            }
        }

        if (Request::wantsJson()) {
            return Response::json($task, 200);
        }

        return View::make('task.task')->with(compact('task'));
    }

    public function update($taskId)
    {
        $task = Task::find($taskId);

        if ($task->user_id !== Auth::user()->getKey()) {
            if (Request::wantsJson()) {
                return Response::json(null, 403);
            } else {
                return View::make('task.index');
            }
        }

        $complete = Input::get('complete', null);

        if ($complete) {
            $task->delete();

            return Response::json(null, 204);
        }

        $quadrant = Input::get('quadrant', null);

        if ($quadrant) {
            $task->update(compact('quadrant'));
        }

        return Response::json(null, 200);
    }

    public function destroy($taskId)
    {
        $task = Task::find($taskId);

        if ($task->user_id !== Auth::user()->getKey()) {
            if (Request::wantsJson()) {
                return Response::json(null, 403);
            } else {
                return View::make('task.index');
            }
        }

        $task->forceDelete();

        return Response::json(null, 204);
    }

    public function indexByQuadrant($quadrant)
    {
        $tasks = Task::where('quadrant', $quadrant)->where('user_id', Auth::user()->getKey())->get();

        return Response::json($tasks, 200);
    }
}
