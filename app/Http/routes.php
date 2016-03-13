<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/wechat', 'WechatController@echoStr');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('wechat/oauth',['as'=>'wechat.oauth','uses'=>'WechatController@oauth']);
    Route::get('wechat/oauth/callback',['as'=>'wechat.callback','uses'=>'WechatController@oauthCallback']);

    Route::get('oauth/github',['as' => 'oauth.github' ,'uses' => 'OAuthController@github']);
    Route::get('oauth/github/callback', ['as' => 'oauth.github.callback', 'uses' => 'OAuthController@githubCallback']);

    Route::group(['middleware' => ['auth']], function() {
        Route::get('apply/partner', ['as' => 'apply.partner', 'uses' => 'UserController@applyPartner']);
        Route::get('apply/member', ['as' => 'apply.member', 'uses' => 'UserController@applyMember']);
    });
});
