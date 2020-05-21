<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddEditStoreCouponRequest;

use App\StoreCoupon;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use  Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $user_id = $user->id;
            $data = StoreCoupon::with('store')->has('store');
            if($user->hasRole('merchant'))
                $data = $data->whereIn('store_id', function($query) use($user_id) {
                    $query->select('id')->from('stores')->where("user_id",$user_id);
                });

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
						$btn = '<a href="javascript:void(0)" id="EditCoupon" data-id="'. $row->id .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="DeleteCoupon" data-id="'. $row->id .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
						return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
		return view('admin.coupon.index');
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

    public function store(AddEditStoreCouponRequest $request)
    {
        $input = $request->all();
        $input['offer_valid'] = Carbon\Carbon::parse($request->offer_valid)->format('Y-m-d');
        $offer = new StoreCoupon();
        $offer->fill($input);
        $offer->save();
        return response()->json([ 'status' => 1 ,  'success'=>'Record added successfully' , 'data' =>$offer ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StoreCoupon $StoreCoupon,$id)
    {
        $coupon = $StoreCoupon->find($id);
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $coupon ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreCoupon $offer)
    {
        return $offer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddEditStoreCouponRequest $request,StoreCoupon $StoreCoupon)
    {
        $input = $request->all();
        $input['offer_valid'] = Carbon\Carbon::parse($request->offer_valid)->format('Y-m-d');
        $StoreCoupon = $StoreCoupon->find($request->id);
        $StoreCoupon->fill($input);
        $StoreCoupon->save();
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $StoreCoupon ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreCoupon $StoreCoupon,$id)
    {
        $StoreCoupon->where("id",$id)->delete();
        return response()->json([ 'status' => 1 ,  'success'=>'success' ]);
    }


    public function GetDataById(Request $request){
        $Id = $request->id;
        $category = StoreCoupon::with('store')->where('id',$Id)->first();
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $category ]);
    }
}
