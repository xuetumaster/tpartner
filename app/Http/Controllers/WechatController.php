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
        $appid = config('wechat.appId');
        $redirect_url = urlencode(config('wechat.callbackUrl'));
        $state = md5(uniqid(rand(), TRUE));
        session(['wechat.state'=>$state]);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_url}&response_type=code&scope=SCOPE&state={$state }#wechat_redirect";
        return redirect($url);
    }

    public function oauthCallback(Request $request)
    {
        if ($request->get('state') == session('state') ) {

            $auth = new Auth(config('wechat.appid'), config('wechat.secret'));
            $ouser = $auth->user();
            if(!$ouser) {
                abort('微信授权错误 #13101');
            }
            $sa = SocialAccount::where('openid',$ouser->get('openid'))->where('platform','wechat')->first();
            if ($sa) {
                \Auth::loginUsingId($ouser->user_id);
            } else {
                \DB::transaction(function() use($ouser,$auth){
                    $user = User::create([
                        'name'=> $ouser->get('nickname',''),
                        'username'=>$ouser->get('platform').'_'.$ouser->get('openid',''),
                        'avatar'=>$ouser->get('headimgurl'),
                    ]);

                    SocialAccount::create([
                        'user_id'=>$user->id,
                        'access_token'=>$auth->access_token,
                        'refresh_token' => $auth->refresh_token,
                        'platform'=>'wechat',
                        'openid'=>$ouser->get('openid'),
                        'user_info'=>json_encode($ouser),
                        'union_id'=>$ouser->get('union_id',''),
                    ]);
                    \Auth::loginUsingId($user->id);
                });
            }

            return redirect(route('home'));

        } else {
            abort('403','服务器授权state不正确');
        }
    }
}
