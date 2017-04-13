<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Wxuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Wxencrypt\WXBizDataCrypt;

class WxuserController extends Controller
{
    private $appId = 'wx1c426b7c3311c97d';
    private $appSecret = '3fc1637131d8f9941e85597daeb55e48';

    public function login(Request $request)
    {
      $wx_session = $this->jscode2session($request->code);
      $key_session = $this->create_guid();

      // $request->session()->put($key_session, $wx_session->openid.$wx_session->session_key);
      // session([$key_session=>$wx_session->openid.$wx_session->session_key]);
      // session(['key' => 'value']);

      $data = [
        "errcode" => 10000,
        "success" => true,
        "bizContent" => $wx_session->session_key
      ];

      return response()->json($data);

    }

    public function getuserinfo(Request $request)
    {
      $session_key = $request->key;
      $userinfo = json_decode($request->userinfo);
      $pc = new WXBizDataCrypt($this->appId, $session_key);
      $errCode = $pc->decryptData($userinfo->encryptedData, $userinfo->iv, $data);
      // echo $userinfo->iv;
      $resdata = [
        "errcode" => 10000,
        "success" => true,
        "bizContent" => $data
      ];

      return response()->json($resdata);
    }

    /*
     * 向微信服务器发送请求，获取openid, session_key
     */
    public function jscode2session($code)
    {
      $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$this->appId
      .'&secret='.$this->appSecret
      .'&js_code='.$code
      .'&grant_type=authorization_code';

      $json = json_decode(file_get_contents($url));
      return  $json;
    }

    /*
     * 生成第三方session, 并且存储
     */
    // public function 3rd_session($code)
    // {
    //
    // }

    /*
     * 生成uuid
     */
    public function create_guid($namespace = '') {
      static $guid = '';
      $uid = uniqid("", true);
      $data = $namespace;
      $data .= $_SERVER['REQUEST_TIME'];
      $data .= $_SERVER['HTTP_USER_AGENT'];
      // $data .= $_SERVER['LOCAL_ADDR'];
      // $data .= $_SERVER['LOCAL_PORT'];
      $data .= $_SERVER['REMOTE_ADDR'];
      $data .= $_SERVER['REMOTE_PORT'];
      $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
      $guid = '{' .
              substr($hash,  0,  8) .
              '-' .
              substr($hash,  8,  4) .
              '-' .
              substr($hash, 12,  4) .
              '-' .
              substr($hash, 16,  4) .
              '-' .
              substr($hash, 20, 12) .
              '}';
      return $guid;
    }
}


// 微信解密部分，利用命名空间一直出现错误，暂时放在了这里。  心塞 --- 搞了3个多小时都不行。
class WXBizDataCrypt
{
  private $appid;
	private $sessionKey;

	/**
	 * 构造函数
	 * @param $sessionKey string 用户在小程序登录后获取的会话密钥
	 * @param $appid string 小程序的appid
	 */
	public function WXBizDataCrypt( $appid, $sessionKey)
	{
		$this->sessionKey = $sessionKey;
		$this->appid = $appid;
	}

	/**
	 * 检验数据的真实性，并且获取解密后的明文.
	 * @param $encryptedData string 加密的用户数据
	 * @param $iv string 与用户数据一同返回的初始向量
	 * @param $data string 解密后的原文
     *
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function decryptData( $encryptedData, $iv, &$data )
	{
		if (strlen($this->sessionKey) != 24) {
			return ErrorCode::$IllegalAesKey;
		}
		$aesKey=base64_decode($this->sessionKey);


		if (strlen($iv) != 24) {
			return ErrorCode::$IllegalIv;
		}
		$aesIV=base64_decode($iv);

		$aesCipher=base64_decode($encryptedData);

		$pc = new Prpcrypt($aesKey);
		$result = $pc->decrypt($aesCipher,$aesIV);

		if ($result[0] != 0) {
			return $result[0];
		}

        $dataObj=json_decode( $result[1] );
        if( $dataObj  == NULL )
        {
            return ErrorCode::$IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $this->appid )
        {
            return ErrorCode::$IllegalBuffer;
        }
		$data = $result[1];
		return ErrorCode::$OK;
	}
}

class PKCS7Encoder
{
	public static $block_size = 16;

	/**
	 * 对需要加密的明文进行填充补位
	 * @param $text 需要进行填充补位操作的明文
	 * @return 补齐明文字符串
	 */
	function encode( $text )
	{
		$block_size = PKCS7Encoder::$block_size;
		$text_length = strlen( $text );
		//计算需要填充的位数
		$amount_to_pad = PKCS7Encoder::$block_size - ( $text_length % PKCS7Encoder::$block_size );
		if ( $amount_to_pad == 0 ) {
			$amount_to_pad = PKCS7Encoder::block_size;
		}
		//获得补位所用的字符
		$pad_chr = chr( $amount_to_pad );
		$tmp = "";
		for ( $index = 0; $index < $amount_to_pad; $index++ ) {
			$tmp .= $pad_chr;
		}
		return $text . $tmp;
	}

	/**
	 * 对解密后的明文进行补位删除
	 * @param decrypted 解密后的明文
	 * @return 删除填充补位后的明文
	 */
	function decode($text)
	{

		$pad = ord(substr($text, -1));
		if ($pad < 1 || $pad > 32) {
			$pad = 0;
		}
		return substr($text, 0, (strlen($text) - $pad));
	}

}

class Prpcrypt
{
	public $key;

	function Prpcrypt( $k )
	{
		$this->key = $k;
	}

	/**
	 * 对密文进行解密
	 * @param string $aesCipher 需要解密的密文
     * @param string $aesIV 解密的初始向量
	 * @return string 解密得到的明文
	 */
	public function decrypt( $aesCipher, $aesIV )
	{

		try {

			$module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

			mcrypt_generic_init($module, $this->key, $aesIV);

			//解密
			$decrypted = mdecrypt_generic($module, $aesCipher);
			mcrypt_generic_deinit($module);
			mcrypt_module_close($module);
		} catch (Exception $e) {
			return array(ErrorCode::$IllegalBuffer, null);
		}


		try {
			//去除补位字符
			$pkc_encoder = new PKCS7Encoder;
			$result = $pkc_encoder->decode($decrypted);

		} catch (Exception $e) {
			//print $e;
			return array(ErrorCode::$IllegalBuffer, null);
		}
		return array(0, $result);
	}
}

class ErrorCode
{
	public static $OK = 0;
	public static $IllegalAesKey = -41001;
	public static $IllegalIv = -41002;
	public static $IllegalBuffer = -41003;
	public static $DecodeBase64Error = -41004;
}
