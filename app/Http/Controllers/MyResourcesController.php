<?php

namespace App\Http\Controllers;

use App\Actions\HandeMyResources;
use Illuminate\Http\Request;
use App\Models\Donors;

class MyResourcesController extends Controller
{
    public function index(HandeMyResources $action)
    {
        return view('my_resources', $action->index());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, HandeMyResources $action)
    {
        $action->valid_write($request);
        return redirect('my_resources');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, HandeMyResources $action)
    {
        $action->edit_resource($request);
        return redirect('my_resources');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, HandeMyResources $action)
    {
        $action->resource_delete($request);
        return redirect('my_resources');
    }
}
