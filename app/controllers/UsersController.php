<?php

use Illuminate\Support\Collection;

class UsersController extends Controller
{
    public function googleOAuth()
    {
        $client = new Google_Client();
        $client->setClientId($_ENV['google_client_id']);
        $client->setClientSecret($_ENV['google_client_secret']);
        $client->setRedirectUri(URL::to('/oauth/google'));
        $client->addScope('https://www.googleapis.com/auth/calendar');

        if ($code = Input::get('code', null)) {
            $token = $client->authenticate($code);
            $client->setAccessToken($token);

            $service = new Google_Service_Calendar($client);
            $calendarList = $service->calendarList->listCalendarList();

            $calendarListEntries = new Collection($calendarList->getItems());
            $taskerCalendarListEntries = $calendarListEntries->groupBy('summary')->get('Tasker', null);

            if (empty($taskerCalendarListEntries)) {
                $calendar = new Google_Service_Calendar_Calendar();
                $calendar->setSummary('Tasker');

                $taskerCalendarListEntry = $service->calendars->insert($calendar);
            } else {
                $taskerCalendarListEntry = $taskerCalendarListEntries[0];
            }

            Session::put('calendarId', $taskerCalendarListEntry->getId());
            Session::put('token', $token);

            return Redirect::to('/');
        } else {
            $service = new Google_Service_Calendar($client);
            $authUrl = $client->createAuthUrl();

            return Redirect::to($authUrl);
        }
    }
}
