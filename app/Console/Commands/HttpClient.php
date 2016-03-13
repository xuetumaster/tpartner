<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class HttpClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'http:client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $res = $client->post('https://github.com/login/oauth/access_token',[
            'headers' => [
                'Accept'     => 'application/json',
            ],
            'form_params' => [
                'client_id' =>config('github.clientID'),
                'client_secret' => config('github.clientSecret'),
                'code' => 'a3c9f4b099f9ece70b23',
                'state'=> '62dd237440217b4ff55c93d5841faaa6',
            ]
        ]);
        $jr = json_decode($res->getBody());
        if (!isset($jr['error']))
        {
            $access_token = $jr['access_token'];
            $res = $client->post('https://api.github.com/user',
                [
                    'headers' => ['Authorization'=>'token '.$access_token],
                ]);
            $jr = $res->getBody();
            dd($jr);
        }
    }
}
