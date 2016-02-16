<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function echoStr(Request $request)
    {
        $signature = $request->get("signature");
        $timestamp = $request->get("timestamp");
        $nonce = $request->get("nonce");

        $token = config('wechat.token');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return $request->get('echostr');
        }else{
            return '';
        }
    }

    public function oauth()
    {
        $appid = config('wechat.AppId');
        $redirect_url = urlencode('http://tpartner.xuetu.io/wechat/redirectTo');
        $state = md5(uniqid(rand(), TRUE));
        session(['wechat.state'=>$state]);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_url}&response_type=code&scope=SCOPE&state={$state }#wechat_redirect";
        return redirect($url);
    }

    public function oauthCallback(Request $request)
    {
        if ($request->get('state') == session('state') ) {

        } else {
            abort('403','服务器授权state不正确');
        }
    }
}
