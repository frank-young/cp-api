<?php
namespace App\Http\Controllers\Miniapp;

use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
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
}
