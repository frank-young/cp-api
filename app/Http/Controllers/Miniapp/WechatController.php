<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Infoterm;
use App\Models\Matchterm;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function response(Request $request)
    {
      $token = 'nanatoken';
      $encodingAESKey = 'uamWMjYGTm8ZS9AKgBFEWnOj65nYEiF3OeOpDEYU2tE';
      return response()->json($res);
    }

    public function create(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {

    }
}
