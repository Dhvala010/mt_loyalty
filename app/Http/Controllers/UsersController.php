<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Validator;
use Auth;
use Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role','<>','1');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
						$btn = '<a href="javascript:void(0)" id="EditUser" data-id="'. $row->id .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="DeleteUser" data-id="'. $row->id .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
						return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
		return view('admin.users.index');
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
			'first_name' => 'required',
			'last_name' => 'required',
		];
		if(!empty($request->id)){
			$validation['email'] = 'required|email|unique:users,email,'.$request->id;

		}else{
			$validation['email'] = 'required|email|unique:users,email';
			$validation['password'] = 'min:6|same:password_confirmation';
		}
		if(isset($input["image"]) && !empty($input["image"])) {
			$file = $input["image"];
			$file = $request->file('image');
		}
		if(!empty($file) && !is_string($file)) {
			$validation['image'] = 'mimes:jpeg,jpg,png,gif';
		}
		// dd($request->all());
		$validator = Validator::make($input ,$validation);
		if($validator->fails()){
			return response()->json([ 'status' => 0 , 'errors'=>$validator->errors()->all()]);
		}
		$profile_img= $input["image"] ?? '';
		if(!empty($profile_img)){
			$imagename = ImageUpload($profile_img);
			$input['image'] = $imagename;
		}

		if(!empty($request->id)){

			$User = User::find($input['id']);
			$User->fill($input);
			$User->save();

			return response()->json([ 'status' => 1 ,  'success'=>'Record Edited successfully']);
		}
		else{
			// dd($request);
			$User = new User();
			$User->fill($input);
			$User->save();

			return response()->json([ 'status' => 1 ,  'success'=>'Record added successfully']);
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
        $User = User::where('id', $id)->delete();
		return response()->json([ 'status' => 1 ,  'success'=>'success' ]);
    }

    public function ChangePassword(){
		return view('admin.users.change_password');
	}

	public function ChangePasswords(Request $request){

		$request_data = $request->All();
		$validator = $this->admin_credential_rules($request_data);
		if($validator->fails())
		{

			return redirect()->back()->withErrors($validator->getMessageBag()->toArray());

		  return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
		}
		else
		{
		  $current_password = Auth::User()->password;
		  if(Hash::check($request_data['current_password'], $current_password))
		  {
			$user_id = Auth::User()->id;
			$obj_user = User::find($user_id);
			$obj_user->password = Hash::make($request_data['password']);;
			$obj_user->save();
			return redirect()->back()->withSuccess('Password change successfully');
		  }
		  else
		  {
			$error = array('current_password' => 'Please enter correct current password');
			return redirect()->back()->withErrors('Please enter correct current password');
		  }
		}

	}
}
