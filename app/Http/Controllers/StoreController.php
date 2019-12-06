<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Store;
use App\User;
use DataTables;
use Validator;
use Auth;
use Hash;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Store::latest();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
						$btn = '<a href="javascript:void(0)" id="EditStore" data-id="'. $row->id .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="DeleteStore" data-id="'. $row->id .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
						return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
		    return view('admin.store.index');
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
    public function store(StoreRequest $request)
    {
        $input = $request->all();
        $file = $request->file('image') ?? '';
        if(!empty($file)){
          $imagename = ImageUpload($file);
          $input['image'] = $imagename;
        }
          $Store = new Store();
          $Store->fill($input);
          $Store->save();
          return response()->json([ 'status' => 1 ,  'success'=>'Record added successfully' , 'data' =>$Store ]);
    }
    public function getmerchant(){
        $merchants = User::where('role',3)->get();
        $html = '<option value="">-- Select Merchant --</option>';
        foreach($merchants as $merchant){
            $html .= '<option value="'.$merchant->id.'">'.$merchant->first_name.'</option>';
        }
        return response()->json([ 'status' => 1 ,  'success'=>'Record added successfully' , 'data' =>$html ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $store ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        return $store;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Store $store)
    {
        $input = $request->all();
        $store->fill($input);
        $store->save();
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $store ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Store::where('id', $id)->delete();
        return response()->json([ 'status' => 1 ,  'success'=>'success' ]);
    }


    public function GetDataById(Request $request){
        $Id = $request->id;
        $category = Store::where('id',$Id)->first();
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $category ]);
      }
}
