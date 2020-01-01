<?php

namespace App\Http\Controllers;

use App\StoreReward;
use Illuminate\Http\Request;
use DataTables;

class StoreRewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        if ($request->ajax()) {
        $data = StoreReward::latest();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" id="EditReward" data-id="'. $row->id .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" id="DeleteStore" data-id="'. $row->id .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
        
        return view('admin.store_reward.store_reward');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoreReward  $storeReward
     * @return \Illuminate\Http\Response
     */
    public function show(StoreReward $storeReward)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoreReward  $storeReward
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreReward $storeReward)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoreReward  $storeReward
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreReward $storeReward)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoreReward  $storeReward
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreReward $storeReward)
    {
        //
    }
}
