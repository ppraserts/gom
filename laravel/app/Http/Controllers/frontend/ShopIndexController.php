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
use Redirect,Session,Response;
use App\Config;
use App\BadWord;

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
        $user = auth()->guard('user')->user();

        $shop = Shop::with(['user'])->where('shop_name',$shop_name)->first();
        if ($shop == null) {
            return abort(404);
        }

        if ($shop != null && $shop->theme != null && $shop->theme != '') {
            $theme = trim($shop->theme);
        } else {
            $theme = "main";
        }
        $status_comment = '';
        if($shop->user_id == $user['id']){
            $status_comment = 1;
        }

        $products = ProductRequest::join('products','product_requests.products_id','=','products.id')
            ->where('users_id', $shop->user_id)
            ->where('iwantto', 'sale')
            ->select('product_requests.*', 'products.product_name_th')
            ->orderBy('sequence','ASC')
            ->orderBy('updated_at','DESC')
            ->limit(8)
            ->get();

//        return $products;

        $dateNow = date('Y-m-d');
        $promotions = Promotions::where('shop_id',$shop->id)
            ->where('is_active', 1)
            ->where('start_date','<=', $dateNow)
            ->where('end_date','>=', $dateNow)
            ->orderBy('sequence','asc')
            ->get();

        $comments = Comment::join('users', 'comments.user_id', '=', 'users.id')
            ->select(DB::raw('comments.*, users.users_firstname_th, users.users_lastname_th'))
            ->where('shop_id',$shop->id)
            ->orderBy('created_at','desc')
            ->paginate(25); //show list 15/page

        $config = Config::find(1);
        $badwords = BadWord::all();
        if (!empty($config) && !empty($badwords)) {
            foreach ($comments as $comment) {
                foreach ($badwords as $word) {
                    $comment->comment = str_ireplace($word->bad_word, $config->censor_word, $comment->comment);
                }
            }
        }


        return view('frontend.shopindex', compact('theme' , 'products','promotions','status_comment'))
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
        $user = auth()->guard('user')->user();
        if(!empty($request->input('rid')) and !empty($request->input('key'))){
            $pr_id = $request->input('rid');
            $key = $request->input('key');
            if(!empty($key)){
                $promotion = PormotionRecomment::where('key',$key)->where('id', $pr_id)->first();
                if(count($promotion) <= 0){
                    return view('errors.404');
                }
                $pormotion_recomment = PormotionRecomment::find($pr_id);
                $data['count_recommend'] = 1 + $pormotion_recomment->count_recommend;
                PormotionRecomment::where('id',$pr_id)->update($data);
            }else{
                return view('errors.404');
            }
        }

        $shop = Shop::where('shop_name', $shop)->get();
        $promotion = Promotions::find($id);
        if ($promotion!=null & $shop->count()>0)
        {
            return view('frontend.promotiondetail', compact('user'))->with('promotion',$promotion);
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
            $user = auth()->guard('user')->user();
            $string = $request->input('comment');

            $comment['score'] = $request->input('star');
            $comment['comment'] = $string;
            $comment['shop_id'] = $shop_id;
            $comment['created_at'] = date('Y-m-d H:i:s');
            $comment['status']= 1;
            $comment['user_id']= $user->id;
            Comment::insertGetId($comment);
            Session::flash('success','Comment successfully.');
            return redirect($shop_name.'#commentBox');
        }
        return abort(404);

    }
    public function updateCommentStatus(Request $request,$shop_name,$id)
    {
        if($request->ajax()){
            $id_input = $request->input('id');
            $status = $request->input('status');
            if($id_input == $id){
                $data['status']= $status;
                Comment::where('id',$id)->update($data);
                return Response::json(array('R'=>'Y'));
            }
            return Response::json(array('R'=>'N'));
        }
        return Response::view('errors.404');
    }
}
