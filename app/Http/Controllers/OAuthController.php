<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OAuthController extends Controller
{

    public function github()
    {
        $state = md5(uniqid(rand(), TRUE));
        session(['github.state'=>$state]);
        return redirect('https://github.com/login/oauth/authorize?client_id='.config('github.clientID')
            .'&client_secret='.config('github.clientSecret')
            .'&state='.$state);
    }

    public function githubCallback(Request $request)
    {
        $state = $request->get('state');
        if ($state == session('github.state')) {
            //http client
            $client = new Client();
            $res = $client->post('https://github.com/login/oauth/access_token',[
                'headers' => [
                    'Accept'     => 'application/json',
                ],
                'form_params' => [
                    'client_id' =>config('github.clientID'),
                    'client_secret' => config('github.clientSecret'),
                    'scope' => 'user',
                    'code' => $request->get('code'),
                    'state' => $request->get('state'),
                ]
            ]);
            $jr = json_decode($res->getBody());
            if (isset($jr['error']))
            {
                \Log::error($res->getBody());
                return abort(500,'<a href="'.$jr['error_uri'].'">'.$jr['error_description'].'</a>');
            } else {
                $access_token = $jr['access_token'];
                $res = $client->post('',
                    [
                        'headers' => ['Authorization'=>'token '.$access_token],
                ]);
            }
        } else {
            return abort(403,'Invalid github state');
        };
    }
}
