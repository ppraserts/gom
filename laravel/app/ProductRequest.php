<?php
namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    protected $table = "product_requests";
    public $fillable = ['iwantto',
        'product_title',
        'product_description',
        'guarantee',
        'price',
        'is_showprice',
        'volumn',
        'product1_file',
        'product2_file',
        'product3_file',
        'productstatus',
        'pricerange_start',
        'pricerange_end',
        'volumnrange_start',
        'volumnrange_end',
        'units',
        'city',
        'province',
        'productcategorys_id',
        'products_id',
        'grade',
        'is_packing',
        'packing_size',
        'province_source',
        'province_selling',
        'start_selling_date',
        'end_selling_date',
        'selling_period',
        'selling_type'
    ];


    public function GetSaleMatchingWithBuy($userid, $orderby)
    {
        $orderbycondition = "";
        if ($orderby == "province")
            $orderbycondition = ",matching.province";
        else if ($orderby == "unit")
            $orderbycondition = ",matching.units";
        else if ($orderby == "price")
            $orderbycondition = ",matching.pricerange_start";

        $results = DB::select(
            DB::raw("SELECT matching.*
                                          ,u.users_firstname_th
                                          ,u.users_lastname_th
                                          ,u.users_firstname_en
                                          ,u.users_lastname_en
                                          ,u.users_dateofbirth
                                          ,u.users_gender
                                          ,u.users_addressname
                                          ,u.users_street
                                          ,u.users_district
                                          ,u.users_city
                                          ,u.users_province
                                          ,u.users_postcode
                                          ,u.users_mobilephone
                                          ,u.users_phone
                                          ,u.users_fax
                                          ,u.users_imageprofile
                                          ,u.users_latitude
                                          ,u.users_longitude
                                          ,u.users_contactperson
                                          ,u.users_membertype
                                          ,u.iwanttosale
                                          ,u.iwanttobuy
                                          ,u.users_idcard
                                          ,u.is_active
                                          ,u.email
                                          ,u.users_qrcode
                                          ,u.users_taxcode
                                          ,u.users_company_th
                                          ,u.users_company_en
                                          FROM
                                          (
                                                    SELECT 'green' as Colors ,a.*
                                                      FROM `product_requests` a
                                                      join `product_requests` b on b.users_id=$userid
                                                          and b.iwantto = 'buy'
                                                          AND a.iwantto =  'sale'
                                                              and a.productcategorys_id = b.productcategorys_id
                                                              and a.products_id = b.products_id

                                                              and (a.`price` between b.`pricerange_start` and b.`pricerange_end`)

                                                              and a.productstatus = 'open'
                                                      union
                                                      SELECT 'red' as Colors ,a.*
                                                      FROM `product_requests` a
                                                      join `product_requests` b on b.users_id=$userid
                                                              and b.iwantto = 'buy'
                                                              AND a.iwantto =  'sale'
                                                              and a.productcategorys_id = b.productcategorys_id
                                                              and a.products_id = b.products_id

                                                              and  (a.`volumn` between b.`volumnrange_start` and b.`volumnrange_end`)
                                                              and a.province like CONCAT('%', b.province , '%')
                                                              and a.productstatus = 'open'
                                                      union
                                                      SELECT 'white' as Colors ,a.*
                                                      FROM `product_requests` a
                                                      join `product_requests` b on b.users_id=$userid
                                                              and b.iwantto = 'buy'
                                                              AND a.iwantto =  'sale'
                                                              and a.productcategorys_id = b.productcategorys_id
                                                              and a.products_id = b.products_id

                                                              and a.productstatus = 'open'
                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by matching.Colors " . $orderbycondition)
        );

        return $results;
    }

    public function GetBuyMatchingWithSale($userid, $orderby)
    {
        $orderbycondition = "";
        if ($orderby == "province")
            $orderbycondition = ",matching.province";
        else if ($orderby == "unit")
            $orderbycondition = ",matching.units";
        else if ($orderby == "price")
            $orderbycondition = ",matching.price";

        $results = DB::select(
            DB::raw("SELECT matching.*
                                          ,u.users_firstname_th
                                          ,u.users_lastname_th
                                          ,u.users_firstname_en
                                          ,u.users_lastname_en
                                          ,u.users_dateofbirth
                                          ,u.users_gender
                                          ,u.users_addressname
                                          ,u.users_street
                                          ,u.users_district
                                          ,u.users_city
                                          ,u.users_province
                                          ,u.users_postcode
                                          ,u.users_mobilephone
                                          ,u.users_phone
                                          ,u.users_fax
                                          ,u.users_imageprofile
                                          ,u.users_latitude
                                          ,u.users_longitude
                                          ,u.users_contactperson
                                          ,u.users_membertype
                                          ,u.iwanttosale
                                          ,u.iwanttobuy
                                          ,u.users_idcard
                                          ,u.is_active
                                          ,u.email
                                          ,u.users_qrcode
                                          ,u.users_taxcode
                                          ,u.users_company_th
                                          ,u.users_company_en
                                          FROM
                                          (
                                                    SELECT
                                                      'green' as Colors, buy.*
                                                      FROM product_requests buy
                                                      JOIN product_requests sale on
                                                            sale.users_id=$userid
                                                            and sale.iwantto = 'sale'
                                                            AND buy.iwantto =  'buy'
                                                            and buy.productcategorys_id = sale.productcategorys_id
                                                            and buy.products_id = sale.products_id

                                                            and buy.pricerange_start <= sale.price and buy.pricerange_end>=sale.price

                                                      union
                                                    SELECT
                                                      'red' as Colors, buy.*
                                                      FROM product_requests buy
                                                      JOIN product_requests sale on
                                                            sale.users_id=$userid
                                                            and sale.iwantto = 'sale'
                                                            AND buy.iwantto =  'buy'
                                                            and buy.productcategorys_id = sale.productcategorys_id
                                                            and buy.products_id = sale.products_id

                                                            and buy.volumnrange_start <= sale.volumn and buy.volumnrange_end>=sale.volumn
                                                            and buy.province like CONCAT('%', sale.province , '%')
                                                      union
                                                    SELECT
                                                      'red' as Colors, buy.*
                                                      FROM  product_requests buy
                                                      JOIN  product_requests sale on
                                                            sale.users_id=$userid
                                                            and sale.iwantto = 'sale'
                                                            AND buy.iwantto =  'buy'
                                                            and buy.productcategorys_id = sale.productcategorys_id
                                                            and buy.products_id = sale.products_id

                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by matching.Colors " . $orderbycondition)
        );

        return $results;
    }

    public function GetSearchProductRequests($iwantto, $category, $search, $qrcode, $province, $price, $volumn)
    {

        $sqlSearchByShopName ='';
        $notwhere_product_name = true;
        if (!empty($search)) {
            $searchShops = DB::table('shops')->where('shop_name', 'like', '%'.$search.'%' )->get();
            if(count($searchShops) > 0){
                $sqlSearchByShopName = " and s.shop_name = '".$search."'";
                $notwhere_product_name = false;
            }

        }

        $sqlcondition = "";
        $sqlcondition .= " and a.productstatus = 'open' ";
        if ($category != "")
            $sqlcondition .= " and  a.`productcategorys_id` = $category";

        if ($qrcode != "")
            $sqlcondition .= " and  u.`users_qrcode` <> '' ";

        if (is_numeric($search)) {
            $sqlcondition .= " and (a.`price` between $search and $search)";
            $sqlcondition .= " and (a.`volumn` between $search and $search)";
        } else {
            if($notwhere_product_name == true) {
                $sqlcondition .= " and a.productstatus = 'open'";
                $sqlcondition .= " and (CONCAT(a.`product_title`
                                          , a.city
                                          , a.province
                                          , u.users_firstname_th
                                          , u.users_lastname_th
                                          , u.users_firstname_en
                                          , u.users_lastname_en
                                          , b.product_name_th
                                          , b.product_name_en)  like '%$search%' )";
            }
        }

        if ($province != "") {
            $sqlcondition .= " and a.productstatus = 'open'";
            $sqlcondition .= " and (CONCAT(a.`product_title`
                                          , a.city
                                          , a.province
                                          , u.users_firstname_th
                                          , u.users_lastname_th
                                          , u.users_firstname_en
                                          , u.users_lastname_en
                                          , b.product_name_th
                                          , b.product_name_en)  like '%$search%' )";
        }

        if (is_numeric($price)) {
            $sqlcondition .= " and (a.`price` between $price and $price)";
        }

        if (is_numeric($volumn)) {
            $sqlcondition .= " and (a.`volumn` between $volumn and $volumn)";
        }



        $results = DB::select(
            DB::raw("SELECT a.*
                            ,u.users_firstname_th
                            ,u.users_lastname_th
                            ,u.users_firstname_en
                            ,u.users_lastname_en
                            ,u.users_dateofbirth
                            ,u.users_gender
                            ,u.users_addressname
                            ,u.users_street
                            ,u.users_district
                            ,u.users_city
                            ,u.users_province
                            ,u.users_postcode
                            ,u.users_mobilephone
                            ,u.users_phone
                            ,u.users_fax
                            ,u.users_imageprofile
                            ,u.users_latitude
                            ,u.users_longitude
                            ,u.users_contactperson
                            ,u.users_membertype
                            ,u.iwanttosale
                            ,u.iwanttobuy
                            ,u.users_idcard
                            ,u.is_active
                            ,u.email
                            ,u.users_qrcode
                            ,u.users_taxcode
                            ,u.users_company_th
                            ,u.users_company_en
                            FROM `product_requests` a
                            join users u on a.`users_id` =u.id
                            join products b on a.products_id = b.id
                            join shops s on u.id = s.user_id
                            where a.`iwantto` = '$iwantto'
                            $sqlcondition $sqlSearchByShopName
              "));

        return $results;
    }

    public function orderItem(){
        return $this->hasMany('App\OrderItem','product_request_id');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

}

?>
