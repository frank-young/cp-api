<?php
namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::all();
        return response()->json($infos);
    }

    public function create(Request $request)
    {
        $info = Info::create($request->all());
        return response()->json($info);
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
