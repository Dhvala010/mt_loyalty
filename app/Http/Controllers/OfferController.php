<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddEditStoreOfferRequest;

use App\StoreOffer,
    App\Store;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon;

class OfferController extends Controller
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
            $data = StoreOffer::with('store')->has('store');
            if($user->hasRole('merchant'))
                $data = $data->whereIn('store_id', function($query) use($user_id) {
                    $query->select('id')->from('stores')->where("user_id",$user_id);
                });

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
		return view('admin.offer.index');
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
    public function store(AddEditStoreOfferRequest $request)
    {
        $input = $request->all();
        $input['offer_valid'] = Carbon\Carbon::parse($request->offer_valid)->format('Y-m-d');
        $offer = new StoreOffer();
        $offer->fill($input);
        $offer->save();
        return response()->json([ 'status' => 1 ,  'success'=>'Record added successfully' , 'data' =>$offer ]);
    }

    public function getstore(){
        if(Auth::user()->hasRole('merchant')){
            $store = Store::where('user_id',Auth::user()->id)->get();
        }else{
            $store = Store::get();
        }

        $html = '<option value="">-- Select Store --</option>';
        foreach($store as $store){
            $html .= '<option value="'.$store->id.'">'.$store->title.'</option>';
        }
        return response()->json([ 'status' => 1 ,  'success'=>'Record added successfully' , 'data' =>$html ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StoreOffer $offer)
    {
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $offer ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreOffer $offer)
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
    public function update(AddEditStoreOfferRequest $request,StoreOffer $offer)
    {
        $input = $request->all();
        $input['offer_valid'] = Carbon\Carbon::parse($request->offer_valid)->format('Y-m-d');
        $offer->fill($input);
        $offer->save();
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $offer ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreOffer $offer)
    {
        $offer->delete();
        return response()->json([ 'status' => 1 ,  'success'=>'success' ]);
    }


    public function GetDataById(Request $request){
        $Id = $request->id;
        $category = StoreOffer::with('store')->where('id',$Id)->first();
        return response()->json([ 'status' => 1 ,  'success'=>'success' , 'data' => $category ]);
    }
}
