<?php

namespace App\Http\Controllers\frontend;

use File;
use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\frontend\User;
use App\ProductRequest;
use App\ProductCategory;
use App\Comment;
use Redirect,Session;
class ProductsViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    private $rules = [
        'star' => 'required',
        'comment' => 'required',
    ];

    public function show($id)
    {

        $productRequest = ProductRequest::join('users', 'users.id', '=','product_requests.users_id')
            ->select('users.*', 'users.id AS user_id' ,'product_requests.*')
            ->where('product_requests.id', $id)
            ->first();

        $user = auth()->guard('user')->user();
        $comments = Comment::where('product_id',$id)->orderBy('created_at','desc')->paginate(25); //show list 15/page
        return view('frontend.productview', compact('productRequest', 'user','comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request,$product_id,$product_key)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
        if ($validator->fails()) {
            return redirect('user/productview/'.$product_id.'#commentBox')->withErrors($validator)->withInput();
        }
        if($request->input('star') >= 6){
            return abort(404);
        }

        if(!empty($product_id) and md5($product_id) == $product_key) {
            $comment['score'] = $request->input('star');
            $comment['comment'] = $request->input('comment');
            $comment['product_id'] = $product_id;
            $comment['created_at'] = date('Y-m-d H:i:s');
            Comment::insertGetId($comment);
            Session::flash('success', 'Comment successfully.');
            return redirect('user/productview/' . $product_id . '#commentBox');
        }
        return abort(404);

    }
}
