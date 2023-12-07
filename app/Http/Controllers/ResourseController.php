<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Hande;
use App\Models\NewsModel;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ResourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

$status = 'authorized';
        //dd('index');
        return view('news', ['status' => $status]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //dd('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $id= $request->input('id');
    //dd($request->all());
    $id= $request->id;
    //dd($request->all());
    $find = DB::table('users')
    ->select('*')
    ->where('id', $id)->get()->toArray();
    //echo($find);

    if(($request->input('todo')) == 'stop') {
        DB::table('users')
                ->where('id',$request->input('id'))
                ->update([
                    'status' => 'not_authorized',
                ]);

                $data = ['id' => $request->input('id'), 'status' => 'not_authorized'];
                return response($data);
    }
    if(($request->input('todo')) == 'start') {
        DB::table('users')
                ->where('id',$request->input('id'))
                ->update([
                    'status' => 'authorized',
                ]);
                $data = ['id' => $request->input('id'), 'status' => 'authorized'];
                return response($data);
    }

    //return response($request->input('todo'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $name, Hande $action)
    {
        return view('new_one', ['data'=>$action->show($name)]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request['news_id'];
        $data = NewsModel::where('id', '=', $id)->get();
        return view('edit_new', ['data' =>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hande $action)
    {
    $action->edit($request);
    return redirect('news');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Hande $action)
    {
        $action->crud_test_delete($request);
        return redirect('/news');
    }
}
