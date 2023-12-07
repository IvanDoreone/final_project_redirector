<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Hande;
use App\Models\Offers;
use Illuminate\Support\Facades\DB;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Hande $action)
    {

        return view('offers', $action->index());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //return response($request);
        if(($request->input('todo')) == 'deactivate') {
            DB::table('offers')
                  ->where('id', $request->input('id'))
                  ->update(['status' => 'stopped']);

                $data = ['id' => $request->input('id'), 'status' => 'stopped'];
                return response($data);
        }
        if(($request->input('todo')) == 'activate') {
            DB::table('offers')
                  ->where('id', $request->input('id'))
                  ->update(['status' => 'active']);

                $data = ['id' => $request->input('id'), 'status' => 'active'];
                return response($data);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Hande $action)
    {
        $action->valid_write($request);
        return redirect('offers');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Hande $action)
    {
        //dd($request->get('new_link_text'));
        $action->edit_link_text($request);
        return redirect('offers');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request['offer_id'];
        $data = Offers::where('id', '=', $id)->get();
        return view('offers', ['data' =>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hande $action)
    {
    $action->offer_edit($request);
    return redirect('offers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Hande $action)
    {
        $action->offer_delete($request);
        return redirect('offers');
    }
}
