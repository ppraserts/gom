<?php

namespace App\Http\Controllers\frontend;

use File;
use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductRequest;

class MatchingController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index(Request $request)
    {
        $userItem = auth()->guard('user')->user();
        $productRequest = new ProductRequest();

        $orderby = $request->input('orderby') != null ? $request->input('orderby') : "price";

        $toggleorder = $request->input('toggleorder') != null ? $request->input('toggleorder') : "desc";
        if ($toggleorder == "desc") {
            $order = "asc";
        } else {
            $order = "desc";
        }

        /** set filter condition */
        $conditions = array();
        $filterprice = $request->input('filterprice') != null ? $request->input('filterprice') : false;
        if ($filterprice) {
            array_push($conditions, "price");
        }
        $filterquantity = $request->input('filterquantity') != null ? $request->input('filterquantity') : false;
        if ($filterquantity) {
            array_push($conditions, "quantity");
        }
        $filterprovince = $request->input('filterprovince') != null ? $request->input('filterprovince') : false;
        if ($filterprovince) {
            array_push($conditions, "province");
        }

        /** set order */
        $price_order = "asc";
        $quantity_order = "asc";
        $province_order = "asc";
        if ($orderby == "price") {
            $price_order = $order;
        } else if ($orderby == "quantity") {
            $quantity_order = $order;
        } else if ($orderby == "province") {
            $province_order = $order;
        }

        /** if old oderby disable */
        if ($orderby == "") {
            if ($filterprice) {
                $orderby = "price";
            } else if ($filterquantity) {
                $orderby = "quantity";
            } else if ($filterprovince) {
                $orderby = "province";
            } else {
                $orderby = "price";
            }
        }
        $itemsbuy = null;
        if ($userItem->iwanttobuy == 'buy') {
            $itemsbuy = $productRequest->matchWithBuy($userItem->id, $conditions, $orderby, $order);  //match with i want buy(myUser_id == user_id)
        }
        $itemssale = null;
        if ($userItem->iwanttosale == 'sale') {
            $itemssale = $productRequest->matchingWithSale($userItem->id, $conditions, $orderby, $order); //match with i want sale(myUser_id == user_id)
        }

        return view('frontend.matching', compact('itemsbuy', 'itemssale', 'userItem', 'price_order', 'quantity_order', 'province_order', 'orderby', 'conditions', 'filterprice', 'filterprovince', 'filterquantity'));
    }
}
