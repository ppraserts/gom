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

    public function matchWithBuy($userid, $whereColumn, $orderby = 'price', $order = 'ASC')
    {
        $orderbycondition = "";
        if ($orderby == "province")
            $orderbycondition = "matching.province";
        else if ($orderby == "quantity")
            $orderbycondition = "matching.units";
        else if ($orderby == "price")
            $orderbycondition = "matching.price";

        $conditionStr = "";
        foreach ($whereColumn as $column) {
            if ($column == "price") {
                $conditionStr .= " and (a.`price` between b.`pricerange_start` and b.`pricerange_end`)";
            } else if ($column == "province") {
                $conditionStr .= " and a.province like CONCAT('%', b.province , '%')";
            } else if ($column == "quantity") {
                $conditionStr .= " and b.volumnrange_start >= a.min_order";
            }
        }
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
                                          ,u.requset_email_system
                                          FROM
                                          (
                                                    SELECT a.*, p.product_name_th, q.id as quotation_id, q.is_reply
                                                      FROM `product_requests` a
                                                      join `product_requests` b on b.users_id=$userid
                                                          and b.iwantto = 'buy'
                                                          AND a.iwantto =  'sale'
                                                          and a.productcategorys_id = b.productcategorys_id
                                                          and a.products_id = b.products_id
                                                          and a.productstatus = 'open'
                                                          and a.users_id != $userid
                                                          $conditionStr
                                                      JOIN `products` p on a.products_id = p.id
                                                      LEFT JOIN quotation q ON a.id = q.product_request_id
                                                          and q.user_id = $userid
                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by $orderbycondition $order")
        );

        return $results;

    }

    /*public function GetSaleMatchingWithBuy($userid, $orderby)
    {
        $orderbycondition = "";
        if ($orderby == "province")
            $orderbycondition = ",matching.province";
        else if ($orderby == "quantity")
            $orderbycondition = ",matching.units";
        else if ($orderby == "price")
            $orderbycondition = ",matching.pricerange_start";
        else if ($orderby == "product_standard")
            $orderbycondition = ",matching.pricerange_start";
        else if ($orderby == "product_category")
            $orderbycondition = ",matching.productcategorys_id";

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
                                          ,u.requset_email_system
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
                                                              and b.volumnrange_start >= a.min_order
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
                                                              and b.volumnrange_start >= a.min_order
                                                      union
                                                      SELECT 'white' as Colors ,a.*
                                                      FROM `product_requests` a
                                                      join `product_requests` b on b.users_id=$userid
                                                              and b.iwantto = 'buy'
                                                              AND a.iwantto =  'sale'
                                                              and a.productcategorys_id = b.productcategorys_id
                                                              and a.products_id = b.products_id
                                                              and a.productstatus = 'open'
                                                              and b.volumnrange_start >= a.min_order
                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by matching.Colors " . $orderbycondition)
        );

        return $results;
    }*/

    public function matchingWithSale($userid, $whereColumn, $orderby = 'price', $order = 'ASC')
    {
        $orderbycondition = "";
        if ($orderby == "province")
            $orderbycondition = "matching.province";
        else if ($orderby == "quantity")
            $orderbycondition = "matching.units";
        else if ($orderby == "price")
            $orderbycondition = "matching.price";

        $conditionStr = "";
        foreach ($whereColumn as $column) {
            if ($column == "price") {
                $conditionStr .= " and (sale.`price` between buy.`pricerange_start` and buy.`pricerange_end`)";
            } else if ($column == "province") {
                $conditionStr .= " and sale.province like CONCAT('%', buy.province , '%')";
            } else if ($column == "quantity") {
                $conditionStr .= " and buy.volumnrange_start >= sale.min_order";
            }
        }

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
                                          ,u.requset_email_system
                                          FROM
                                          (
                                                    SELECT buy.*, p.product_name_th
                                                      FROM product_requests buy
                                                      JOIN product_requests sale on
                                                            sale.users_id=$userid
                                                            and sale.iwantto = 'sale'
                                                            AND buy.iwantto =  'buy'
                                                            and buy.productcategorys_id = sale.productcategorys_id
                                                            and buy.products_id = sale.products_id
                                                            and buy.pricerange_start <= sale.price 
                                                            and buy.pricerange_end>=sale.price
                                                            and buy.volumnrange_start >= sale.min_order
                                                            and buy.users_id != $userid
                                                    JOIN `products` p on buy.products_id = p.id
                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by $orderbycondition $order")
        );

        return $results;
    }

    /*public function GetBuyMatchingWithSale($userid, $orderby)
    {
        $orderbycondition = "";
        if ($orderby == "province")
            $orderbycondition = ",matching.province";
        else if ($orderby == "quantity")
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
                                          ,u.requset_email_system
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
                                                            and buy.pricerange_start <= sale.price
                                                            and buy.pricerange_end>=sale.price
                                                            and buy.volumnrange_start >= sale.min_order
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
                                                            and buy.volumnrange_start >= sale.min_order
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
                                                            and buy.volumnrange_start >= sale.min_order

                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by matching.Colors " . $orderbycondition)
        );

        return $results;
    }*/

    public function GetSearchProductRequests($iwantto, $category, $search, $qrcode, $province, $price, $volumn,$markets = '')
    {

        $sqlSearchByShopName = '';
        $notwhere_product_name = true;
        if (!empty($search)) {
            $searchShops = DB::table('shops')->where('shop_name', 'like', '%' . $search . '%')->get();
            if (count($searchShops) > 0) {
                $sqlSearchByShopName = " and s.shop_name = '" . $search . "'";
                $notwhere_product_name = false;
            }

        }

        $sqlcondition = "";
        $sqlcondition .= " and a.productstatus != 'close' ";
//        $sqlcondition .= " and a.productstatus = 'open' ";
        if ($category != "")
            $sqlcondition .= " and  a.`productcategorys_id` = $category";

        if ($qrcode != "")
            $sqlcondition .= " and  u.`users_qrcode` <> '' ";

        if (is_numeric($search)) {
            $sqlcondition .= " and (a.`price` between $search and $search)";
            $sqlcondition .= " and (a.`volumn` between $search and $search)";
        } else {
            //$sqlcondition .= " and a.productstatus = 'open'";
            if ($notwhere_product_name == true) {
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

        $join_market = "";
        if (is_array($markets)) {
            $join_market = " join product_request_market m on a.id = m.product_request_id";
            $markets = implode("','",$markets);
            $sqlcondition .= " and m.market_id IN ('".$markets."')";
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


        if ($notwhere_product_name == true) {
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
                            ,sum(c.score) as sum_score
                            ,count(c.score) as count_score
                            ,sum(c.score)/count(c.score) as avg_score
                     
                            FROM `product_requests` a
                            join users u on a.`users_id` =u.id
                            join products b on a.products_id = b.id
                            $join_market
                            LEFT JOIN comments c on a.id = c.product_id
                            where a.`iwantto` = '$iwantto'
                            $sqlcondition 
                            GROUP BY a.id
                            order by avg_score desc, a.sequence asc, a.updated_at desc
              "));
        } else {
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
                            ,sum(c.score) as sum_score
                            ,count(c.score) as count_score
                            ,sum(c.score)/count(c.score) as avg_score
                            
                            FROM `product_requests` a
                            join users u on a.`users_id` =u.id
                            join products b on a.products_id = b.id
                            join shops s on u.id = s.user_id
                            $join_market
                            LEFT JOIN comments c on a.id = c.product_id
                            where a.`iwantto` = '$iwantto'
                            $sqlcondition $sqlSearchByShopName 
                            GROUP BY a.id
                            order by avg_score desc, a.sequence asc, a.updated_at desc
              "));
        }

        return $results;
    }

    public function orderItem()
    {
        return $this->hasMany('App\OrderItem', 'product_request_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function standards()
    {
        return $this->belongsToMany('App\Standard');
    }

}

?>
