<?php

namespace App\Http\Controllers\frontend;

use App\BadWord;
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
use App\Shop;
use App\Config;
use App\Standard;
use Redirect, Session;

class ProductsViewController extends Controller
{
    public function __construct()
    {
//        $this->middleware('user');
    }

    private $rules = [
        'star' => 'required',
        'comment' => 'required',
    ];

    public function show($id)
    {
        $productRequest = ProductRequest::join('users', 'users.id', '=', 'product_requests.users_id')
            ->join('products', 'product_requests.products_id', '=', 'products.id')
            ->leftJoin('comments', 'product_requests.id', '=', 'comments.product_id')
            ->select(DB::raw('users.*, users.id AS user_id ,product_requests.*, products.product_name_th
                ,sum(comments.score)/count(comments.product_id) as avg_score'))
            ->where('product_requests.id', $id)
            ->first();
        if($productRequest->is_active == 0){
            return abort(404);
        }
        $user = auth()->guard('user')->user();

        $status_comment = '';
        if ($productRequest->user_id == $user['id']) {
            $status_comment = 1;
        }

        $standards = Standard::join('user_standard', 'user_standard.standard_id', '=', 'standards.id')
            ->where('user_standard.user_id', $productRequest->user_id)->get();

        $shop = Shop::where('user_id', $productRequest->user_id)->first();

        $comments = Comment::join('users', 'comments.user_id', '=', 'users.id')
            ->select(DB::raw('comments.*, users.users_firstname_th, users.users_lastname_th'))
            ->where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(25); //show list 25/page

        $config = Config::find(1);
        $badwords = BadWord::all();
        if (!empty($config) && !empty($badwords)) {
            foreach ($comments as $comment) {
                foreach ($badwords as $word) {
                    $comment->comment = str_ireplace($word->bad_word, $config->censor_word, $comment->comment);
                }
            }
        }
        return view('frontend.productview',
            compact('productRequest', 'user', 'comments', 'status_comment', 'shop','standards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request, $product_id, $product_key)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
        if ($validator->fails()) {
            return redirect('user/productview/' . $product_id . '#commentBox')->withErrors($validator)->withInput();
        }
        if ($request->input('star') >= 6) {
            return abort(404);
        }


        if (!empty($product_id) and md5($product_id) == $product_key) {
            $user = auth()->guard('user')->user();
            $string = $request->input('comment');

            $comment['score'] = $request->input('star');
            $comment['comment'] = $string;
            $comment['product_id'] = $product_id;
            $comment['created_at'] = date('Y-m-d H:i:s');
            $comment['status'] = 1;
            $comment['user_id'] = $user->id;
            Comment::insertGetId($comment);
            Session::flash('success', 'Comment successfully.');
            return redirect('user/productview/' . $product_id . '#commentBox');
        }
        return abort(404);

    }

    public function updateCommentStatus(Request $request, $id)
    {
        if ($request->ajax()) {
            $id_input = $request->input('id');
            $status = $request->input('status');
            if ($id_input == $id) {
                $data['status'] = $status;
                Comment::where('id', $id)->update($data);
                return Response::json(array('R' => 'Y'));
            }
            return Response::json(array('R' => 'N'));
        }
        return Response::view('errors.404');
    }
}
