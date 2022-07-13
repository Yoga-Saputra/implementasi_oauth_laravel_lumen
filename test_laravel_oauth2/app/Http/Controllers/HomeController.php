<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = [];
        if (auth()->user()->token) {

            if (auth()->user()->token->hasExpired()) {
                return redirect('/oauth/refresh');
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . auth()->user()->token->access_token
            ])->get(env('SERVER_URL') .'/api/posts');

            // no have access
            if ($response->status() === 404 || $response->status() == 500) {
                return redirect()->route('authorized')->with('error_message', 'Authorize to server is failed');
            }


            if ($response->status() === 200) {
                $posts = $response->json()['data'];
            }
        }

        return view('home', [
            'posts' => $posts
        ]);
    }

    public function unauthorized()
    {
        return view('unauthorized');
    }

    public function users()
    {
        $users = [];

        if (auth()->user()->token) {
            if (auth()->user()->token->hasExpired()) {
                return redirect('/oauth/refresh');
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . auth()->user()->token->access_token
            ])->get(env('SERVER_URL') .'/api/users');
            // no have access
            if ($response->status() === 404 || $response->status() == 500) {
                return redirect()->route('authorized')->with('error_message', 'Authorize to server is failed');
            }

            if ($response->status() === 200) {
                $users = $response->json()['data'];
            }
        }

        return view('user', [
            'users' => $users
        ]);
    }
}
