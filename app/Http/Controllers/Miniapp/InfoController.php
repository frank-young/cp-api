<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Info;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::all();
        return response()->json($infos);
    }

    public function create(Request $request)
    {
        // $this->validate($request, [
        //     // 'name' => 'required|max:255',
        //     // 'phone' => 'require|max:11',
        //     // 'sex' => 'require|max:255',
        //     // 'birthday' => 'require|max:10',
        //     // 'constellation' => 'require|max:255',
        //     // 'province' => 'require|max:255',
        //     // 'city' => 'require|max:255',
        //     // 'wechat_id' => 'require|max:255',
        //     // 'school' => 'require|max:255',
        //     // 'area_matching' => 'require|max:255',
        //     // 'age_matching' => 'require|max:255'
        // ]);
        // $info = new Info;
        // $info = $request->all();
        // echo $request->input('name');
        // $info->save();
        // var_dump($info);
        Info::create($request->all());
        $res = returnCode(true,'成功','success');
        return response()->json($res);
    }

    public function update(Request $request, $id)
    {
        $info = Info::find($id);
        $info->name = $request->input('name');
        $info->age = $request->input('age');
        $info->info = $request->input('info');
        $info->save();

        return response()->json($info);
    }

    public function delete($id)
    {
        $info = Info::find($id);
        $info->delete();

        return response()->json('删除成功');
    }
}
