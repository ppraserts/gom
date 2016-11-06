<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use DB;
use App\FaqCategory;
use App\Faq;

class FaqController extends Controller
{
      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
      }

      public function index(Request $request)
      {
          $faqcategoryItems = FaqCategory::orderBy('sequence','ASC')
                      ->get();

          $faqItems = Faq::orderBy('sequence','ASC')
                      ->get();
          return view('faq',compact('faqcategoryItems','faqItems'));
      }
  }
