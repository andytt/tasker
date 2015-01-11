<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;

class TasksController extends BaseController
{
    protected $calendarService;

    public function __construct()
    {
        $this->beforeFilter('googleOAuth');
    }

    public function index()
    {
        if (Request::wantsJson()) {
            $calendarEntries = new Collection($this->getCalendarService()->events->listEvents(Session::get('calendarId'))->getItems());
            $tasks = new Collection;

            $calendarEntries->each(function ($calendarEntry) use ($tasks) {
                $tasks->push($this->calendarEntryToTask($calendarEntry));
            });

            return Response::json($tasks, 200);
        }

        return View::make('task.index');
    }

    public function store()
    {
        if (!Request::ajax()) return Redirect::to('/');

        $title = Input::get('title', null);
        $description = Input::get('description', null);
        $quadrant = Input::get('quadrant', null);
        $date = ($date = Input::get('date', null)) ? Carbon::parse($date) : Carbon::now();

        $nowDateString = $date->toDateString();

        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDate($nowDateString);

        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDate($nowDateString);

        $event = new Google_Service_Calendar_Event();
        empty($title) ?: $event->setSummary($title);
        empty($description) ?: $event->setDescription($description);
        $event->setColorId($this->getColorIdByQuadrant($quadrant));
        $event->setStart($start);
        $event->setEnd($end);

        $createdEvent = $this->getCalendarService()->events->insert(Session::get('calendarId'), $event);

        $newTask = $this->calendarEntryToTask($createdEvent);

        return Response::json($newTask, 201);
    }

    public function show($taskId)
    {
        $calendarEntry = $this->getCalendarService()->events->get(Session::get('calendarId'), $taskId);
        $task = $this->calendarEntryToTask($calendarEntry);

        return Response::json($task, 200);
    }

    public function update($taskId)
    {
        $quadrant = Input::get('quadrant', null);

        if (!empty($quadrant)) {
            $calendarEntry = $this->getCalendarService()->events->get(Session::get('calendarId'), $taskId);
            $calendarEntry->setColorId($this->getColorIdByQuadrant($quadrant));

            $this->getCalendarService()->events->patch(Session::get('calendarId'), $taskId, $calendarEntry);
        }

        return Response::json(null, 200);
    }

    public function destroy($taskId)
    {
        $this->getCalendarService()->events->delete(Session::get('calendarId'), $taskId);

        return Response::json(null, 204);
    }

    protected function getCalendarService()
    {
        if ($this->calendarService instanceof Google_Service_Calendar) return $this->calendarService;

        $client = new Google_Client();
        $client->setClientId($_ENV['google_client_id']);
        $client->setClientSecret($_ENV['google_client_secret']);
        $client->setRedirectUri(URL::to('/oauth/google'));
        $client->addScope('https://www.googleapis.com/auth/calendar');
        $client->setAccessToken(Session::get('token'));

        $this->calendarService = new Google_Service_Calendar($client);

        return $this->calendarService;
    }

    protected function getColorIdByQuadrant($quadrant)
    {
        switch ($quadrant) {
            case 1:
                return '11';
            case 2:
                return '10';
            case 3:
                return '9';
            case 4:
                return '8';
            default:
                return '8';
        }
    }

    protected function getQuadrantByColorId($colorId)
    {
        switch ($colorId) {
            case '11':
                return 1;
            case '10':
                return 2;
            case '9':
                return 3;
            case '8':
                return 4;
            default:
                return 4;
        }
    }

    protected function calendarEntryToTask($calendarEntry)
    {
        return [
            'id' => $calendarEntry->getId(),
            'summary' => $calendarEntry->getSummary(),
            'description' => $calendarEntry->getDescription(),
            'quadrant' => $this->getQuadrantByColorId($calendarEntry->getColorId())
        ];
    }
}
