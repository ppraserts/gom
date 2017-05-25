<?php

namespace App\Http\Controllers\frontend;

use App\Promotions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Shop;
use App\Comment;
use App\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\PormotionRecomment;
use Redirect,Session;

class ShopIndexController extends Controller
{
    private $rules = [
        'star' => 'required',
        'comment' => 'required',
    ];
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
            ->orderBy('sequence','ASC')
            ->orderBy('updated_at','DESC')
            ->limit(8);
        $products = $query->get();

        $dateNow = date('Y-m-d');
        $promotions = Promotions::where('shop_id',$shop->id)
            ->where('is_active', 1)
            ->where('start_date','<=', $dateNow)
            ->where('end_date','>=', $dateNow)
            ->orderBy('sequence','desc')
            ->get();

        $comments = Comment::where('shop_id',$shop->id)->orderBy('created_at','desc')->paginate(25); //show list 15/page

        return view('frontend.shopindex', compact('theme' , 'products','promotions'))
            ->with('comments', $comments)
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

    public function promotion(Request $request,$shop,$id){
        if(!empty($request->input('rid')) and !empty($request->input('key'))){
            $pr_id = $request->input('rid');
            $key = $request->input('key');
            if($key == md5($pr_id)){
                $pormotion_recomment = PormotionRecomment::find($pr_id);
                $data['count_recommend'] = 1 + $pormotion_recomment->count_recommend;
                PormotionRecomment::where('id',$pr_id)->update($data);
            }else{
                return view('errors.404');
            }
        }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request,$shop_name,$shop_id,$shop_key)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
        if ($validator->fails()) {
            return redirect($shop_name.'#commentBox')->withErrors($validator)->withInput();
        }
        if($request->input('star') >= 6){
            return abort(404);
        }

        if(!empty($shop_id) and md5($shop_id) == $shop_key){
            $comment['score'] = $request->input('star');
            $comment['comment'] = $request->input('comment');
            $comment['shop_id'] = $shop_id;
            $comment['created_at'] = date('Y-m-d H:i:s');
            Comment::insertGetId($comment);
            Session::flash('success','Comment successfully.');
            return redirect($shop_name.'#commentBox');
        }
        return abort(404);

    }
}
