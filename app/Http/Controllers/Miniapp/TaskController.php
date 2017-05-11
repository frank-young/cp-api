<?php
namespace App\Http\Controllers\Miniapp;

use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use App\Models\Session;
use App\Models\Taskmanager;
use App\Models\Taskterm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /*
     * 七牛云 uptoken
     */
    public function qiniuToken(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));

      $accessKey = 'BeGCarWqHHOEatmrX202EdWvT10YYW5JBYBxT-1D';
      $secretKey = 'F6hseEQ-Q9eFwgTzkWafCDTlNEK8qJkl0icILxB4';
      $bucketName = 'nana-cp-miniapp';
      $upManager = new UploadManager();
      $auth = new Auth($accessKey, $secretKey);
      $token = $auth->uploadToken($bucketName);

      $res = returnCode(true,'获取uptoken成功',$token);
      return response()->json($res);
    }

    /*
     * 用户获取任务
     */
    public function show(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $task = Taskmanager::find($request->input('id'))->firstOrFail();
      $res = returnCode(true,'获取任务成功', $task);
      return response()->json($res);
    }

    /*
     * 签到用户获取获取个人任务信息
     */
    public function list(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $task = Taskterm::where(['openid' => $openid])->firstOrFail();

      $res = returnCode(true,'获取个人任务信息成功', $task);
      return response()->json($res);
    }
}
