<?php
namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Iwantto extends Model
{
    protected $table = "iwantto";
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
                        'users_id',
                        ];


      public function GetSaleMatchingWithBuy($userid)
      {
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
                                                      FROM `iwantto` a
                                                      join `iwantto` b on b.users_id=$userid
                                                          and b.iwantto = 'buy'
                                                              and a.productcategorys_id = b.productcategorys_id
                                                              and a.products_id = b.products_id
                                                              and a.`product_title` = b.product_title
                                                              and (a.`price` between b.`pricerange_start` and b.`pricerange_end`)
                                                              and (a.`volumn` between b.`volumnrange_start` and b.`volumnrange_end`)
                                                              and a.city = b.city
                                                              and a.province = b.province
                                                              and a.productstatus = 'open'
                                                      union
                                                      SELECT 'orange' as Colors ,a.*
                                                      FROM `iwantto` a
                                                      join `iwantto` b on b.users_id=$userid
                                                              and b.iwantto = 'buy'
                                                              and a.productcategorys_id = b.productcategorys_id
                                                              and a.products_id = b.products_id
                                                              and (a.`price` between b.`pricerange_start` and b.`pricerange_end`)
                                                              and  (a.`volumn` between b.`volumnrange_start` and b.`volumnrange_end`)
                                                              and a.province like CONCAT('%', b.province , '%')
                                                              and a.productstatus = 'open'
                                                      union
                                                      SELECT 'red' as Colors ,a.*
                                                      FROM `iwantto` a
                                                      join `iwantto` b on b.users_id=$userid
                                                              and b.iwantto = 'buy'
                                                              and a.productcategorys_id = b.productcategorys_id
                                                              and a.products_id = b.products_id
                                                              and (a.`price` between b.`pricerange_start` and b.`pricerange_end`)
                                                              and  (a.`volumn` between b.`volumnrange_start` and b.`volumnrange_end`)
                                                              and a.productstatus = 'open'
                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by matching.Colors")
                  );

                  return $results;
      }

      public function GetBuyMatchingWithSale($userid)
      {
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
                                                      FROM  iwantto buy
                                                      JOIN iwantto sale on
                                                            sale.users_id=$userid
                                                            and sale.iwantto = 'sale'
                                                            and buy.productcategorys_id = sale.productcategorys_id
                                                            and buy.products_id = sale.products_id
                                                            and buy.`product_title` = sale.product_title
                                                            and buy.pricerange_start <= sale.price and buy.pricerange_end>=sale.price
                                                            and buy.volumnrange_start <= sale.volumn and buy.volumnrange_end>=sale.volumn
                                                            and buy.city = sale.city
                                                            and buy.province = sale.province
                                                      union
                                                    SELECT
                                                      'orange' as Colors, buy.*
                                                      FROM  iwantto buy
                                                      JOIN iwantto sale on
                                                            sale.users_id=$userid
                                                            and sale.iwantto = 'sale'
                                                            and buy.productcategorys_id = sale.productcategorys_id
                                                            and buy.products_id = sale.products_id
                                                            and buy.pricerange_start <= sale.price and buy.pricerange_end>=sale.price
                                                            and buy.volumnrange_start <= sale.volumn and buy.volumnrange_end>=sale.volumn
                                                            and buy.province like CONCAT('%', sale.province , '%')
                                                      union
                                                    SELECT
                                                      'red' as Colors, buy.*
                                                      FROM  iwantto buy
                                                      JOIN iwantto sale on
                                                            sale.users_id=$userid
                                                            and sale.iwantto = 'sale'
                                                            and buy.productcategorys_id = sale.productcategorys_id
                                                            and buy.products_id = sale.products_id
                                                            and buy.pricerange_start <= sale.price and buy.pricerange_end>=sale.price
                                                            and buy.volumnrange_start <= sale.volumn and buy.volumnrange_end>=sale.volumn
                                          ) as matching
                                          join users u on matching.users_id = u.id
                                          group by matching.id
                                          order by matching.Colors")
                  );

                  return $results;
      }

      public function GetSearchIwantto($iwantto, $category, $search, $qrcode)
      {
        $sqlcondition = "";
        $sqlcondition .= " and a.productstatus = 'open' ";
        if($category != "")
          $sqlcondition .= " and  a.`productcategorys_id` = $category";

        if($qrcode != "")
          $sqlcondition .= " and  u.`users_qrcode` <> '' ";

        if(is_numeric($search))
        {
          $sqlcondition .= " and (a.`price` between $search and $search)";
          $sqlcondition .= " and (a.`volumn` between $search and $search)";
        }
        else {
          $sqlcondition .= " and a.productstatus = 'open'";
          $sqlcondition .= " and (CONCAT(a.`product_title`
                                          , a.city
                                          , a.province
                                          , u.users_firstname_th
                                          , u.users_lastname_th
                                          , u.users_firstname_en
                                          , u.users_lastname_en)  like '%$search%' )";
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
                            FROM `iwantto` a
                            join users u on a.`users_id` =u.id
                            where a.`iwantto` = '$iwantto'
                            $sqlcondition
              "));

          return $results;
      }

}
?>
