<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
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
    public function store(Request $request)
    {
        $input = $request->all();
        $validation = [];
        $validation = [
          'description' => 'required',
          'phone_number' => 'required',
          'email' => 'required',
          'facebook_url' => 'required',
          'location_address' => 'required',
        ];
        if(!empty($request->id)){
          $validation['title'] = 'required|unique:stores,title,'.$request->id;
        }else{
          $validation['title'] = 'required|unique:stores,title';
        }
        if(isset($input["image"]) && !empty($input["image"])) {
          $file = $request->file('image') ?? '';
          $validation['image'] = 'mimes:jpeg,jpg,png,gif';
        }

        $validator = Validator::make($input ,$validation);
        if($validator->fails()){
          return response()->json([ 'status' => 0 , 'errors'=>$validator->errors()->all()]);
        }

        if(!empty($file)){
          $imagename = ImageUpload($file);
          $input['image'] = $imagename;
        }

        if(!empty($request->id)){
          $Store = Store::find($input['id']);
          $Store->fill($input);
          $Store->save();
          return response()->json([ 'status' => 1 ,  'success'=>'Record Edited successfully']);
        }
        else{
          $Store = new Store();
          $Store->fill($input);
          $Store->save();
          return response()->json([ 'status' => 1 ,  'success'=>'Record added successfully' , 'data' =>$User ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
