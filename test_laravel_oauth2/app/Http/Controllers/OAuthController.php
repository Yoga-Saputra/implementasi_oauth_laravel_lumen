<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class OAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $url = env('SERVER_URL') . '/oauth/token';

        $response = Http::post($url, [
            "grant_type" => env('GRANT_TYPE'),
            "client_id" => env('CLIENT_ID'),
            "client_secret" => env('CLIENT_SECRET'),
            "password" => env('PASSWORD'),
            "username" => env('USERNAME'),
            "scope" => "*",
        ]);

        if ($response->status() == 400 || $response->status() == 401) {
            return redirect()->route('authorized')->with('error_message', 'Authorize to server is failed');
        } else {
            $response = $response->json();
            $request->user()->token()->delete();
            $request->user()->token()->create([
                'access_token' => $response['access_token'],
                'expires_in' => $response['expires_in'],
                'refresh_token' => $response['refresh_token']
            ]);

            return redirect('/home')->with('success_message', 'Authorize to server is success');
        }
    }

    public function refresh(Request $request)
    {
        $response = Http::post(env('SERVER_URL') . '/oauth/token', [
            'grant_type' => env('GRANT_TYPE'),
            'refresh_token' => $request->user()->token->refresh_token,
            "client_id" => env('CLIENT_ID'),
            "client_secret" => env('CLIENT_SECRET'),
            'scope' => '*'
        ]);

        if ($response->status() !== 200) {
            $request->user()->token()->delete();

            return redirect()->route('authorized')
                ->withStatus('Authorization failed from OAuth server.');
        }

        $response = $response->json();

        $request->user()->token()->update([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect('/home');
    }
}
