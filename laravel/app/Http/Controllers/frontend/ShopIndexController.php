<?php

namespace App\Http\Controllers\frontend;

use App\Promotions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Shop;
use App\ProductRequest;
use Illuminate\Support\Facades\DB;

class ShopIndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($shop_name)
    {
        $shop = Shop::with(['user'])->where('shop_name',$shop_name)->first();
        if ($shop == null) {
            return abort(404);
        }

        if ($shop != null && $shop->theme != null && $shop->theme != '') {
            $theme = trim($shop->theme);
        } else {
            $theme = "main";
        }

        $query = DB::table('product_requests')
            ->where('users_id', $shop->user_id)
            ->where('iwantto', 'sale')
            ->select('*')
            ->orderBy('created_at','DESC')
            ->orderBy('updated_at', 'DESC')
            ->limit(8);

        $dateNow = date('Y-m-d');
        $promotions = Promotions::where('shop_id',$shop->id)
            ->where('is_active', 1)
            ->where('start_date','<=', $dateNow)
            ->where('end_date','>=', $dateNow)
            ->orderBy('sequence','desc')
            ->get();
//       echo json_encode($promotions); exit();

        $products = $query->get();
        return view('frontend.shopindex', compact('theme' , 'products','promotions'))
            ->with('shop', $shop);
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
        //
    }

    public function promotion($shop,$id){
        $shop = Shop::where('shop_name', $shop)->get();

        $promotion = Promotions::find($id);
//        var_dump($promotion);
        if ($promotion!=null & $shop->count()>0)
        {
            return view('frontend.promotiondetail')->with('promotion',$promotion);
        }else{
            return abort(404);
        }
    }
}
