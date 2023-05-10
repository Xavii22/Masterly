<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function getUsers()
    {
        $client = new Client();
        $response = $client->get('http://127.0.0.1:8080');
        $users = json_decode($response->getBody());
        return view('users', compact('users'));
    }
}
