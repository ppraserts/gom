<?php

namespace App\Http\Controllers\backend;

use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Iwantto;

class ReportController extends Controller
{
  public function __construct()
  {
      $this->middleware('admin');
  }

  public function index(Request $request)
  {
    $resultsG1 = DB::select(
          DB::raw("SELECT users_province,COUNT(*) as countuser
                   FROM users
                   GROUP BY `users_province`
                   ORDER BY users_province asc"));

    $resultsG2 = DB::select(
         DB::raw("SELECT users_membertype, COUNT( * ) as countuser
                  FROM users
                  GROUP BY  `users_membertype`
                  ORDER BY users_membertype ASC"));

    $resultsG3 = DB::select(
         DB::raw("SELECT 'Sale' iwantto, COUNT( * ) as countuser
                  FROM users
                  WHERE iwanttosale <> '' and iwanttobuy = ''
                  UNION
                  SELECT 'Buy' iwantto, COUNT( * ) as countuser
                  FROM users
                  WHERE iwanttobuy <> '' and iwanttosale = ''
                  UNION
                  SELECT 'Sale and Buy' iwantto, COUNT( * ) as countuser
                  FROM users
                  WHERE iwanttobuy <> '' and iwanttosale <> ''"));

    $Iwanttoobj = new Iwantto();
    $itemssale = $Iwanttoobj->GetSearchIwantto('sale','', '', '', '', '', '');
    $itemsbuy = $Iwanttoobj->GetSearchIwantto('buy','', '', '', '', '', '');
      return view('backend.reportuser',compact('resultsG1'
                                                ,'resultsG2'
                                                ,'resultsG3'
                                                ,'itemssale'
                                                ,'itemsbuy'));
  }
}
