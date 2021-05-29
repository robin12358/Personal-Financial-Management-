<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Spend;
use Carbon\Carbon;
class AdminController extends Controller
{
   public function index(){
       return view('admin.home');
   }
   public function category(){
       $data['categorys'] = Category::all();
    return view('admin.category',$data);
   }
   public function categorystore(Request $request){
    $validator = Validator::make($request->all(),[
        'name'=>'required',
    ]);
    if($validator->fails()){
        return back()->withErrors($validator);
    }else{  
        $category = new Category();
        $category->name=$request->input('name');
        $category->save();
        return redirect ('/admin/category');
    }

   }
   public function categorydel($id){
    $hav_cate = Category::where('category_id' , $id)->get();
    if($hav_cate == null){
        return redirect ('/admin/category');
    }else{
        Category::where('category_id' , $id)->delete();
        return redirect ('/admin/category');
    }
    
   }
   public function subcategory(){
       $data['subcategorys']= Sub_category::all();
       $data['categorys']=Category::all();
       return view('admin.subcategory',$data);
    }
   public function subcategorystore(Request $request){
     $validator = Validator::make($request->all(),[
         'name'=>'required',
         'category'=>'required',
     ]);
     if($validator->fails()){
         return back()->withErrors($validator);
     }else{  
         $subcategory = new Sub_category();
         $subcategory->name=$request->input('name');
         $subcategory->category=$request->input('category');
         $subcategory->save();
         return redirect ('/admin/subcategory');
     }
 
    }
   public function subcategorydel($id){
     $hav_subcate = Sub_category::where('sub_category_id' , $id)->get();
     if($hav_subcate == null){
         return redirect ('/admin/subcategory');
     }else{
        Sub_category::where('sub_category_id' , $id)->delete();
         return redirect ('/admin/subcategory');
     }
     
    }
   public function spend(){
       $data['categorys']= Category::all();
       $data['subcategorys']= Sub_category::all()->toArray();
    return view('admin.spend',$data);
   }
   public function spendstore(Request $request){
    $validator = Validator::make($request->all(),[
        'description'=>'required',
        'category'=>'required',
        'subcategory'=>'required',
        'amounts'=>'required',
    ]);
    if($validator->fails()){
        return back()->withErrors($validator);
    }else{  
        $spend = new Spend();
        $spend->description=$request->input('description');
        $spend->sub_category=$request->input('subcategory');
        $spend->amount=$request->input('amounts');
        $spend->save();
        return redirect ('/admin/spend');
   }
    }
   public function chartjs(){
   $input= '2020-1-4';
    $tim  = strtotime($input);
    $day   = date('d',$tim);
    $month = date('m',$tim);
    $year  = date('Y',$tim);
    $p_today =carbon::today()->toDateString();
    $p_month=carbon::today()->subMonth()->toDateString();
    $tim1  = strtotime($p_today);
    $tim2  = strtotime($p_month);
//     $sub_category = Sub_category::pluck('name')->toArray();
    
//     $sub_amounts = Spend::select(DB::raw("SUM(amount) as count"))
//     ->orderBy("sub_category")
//     ->groupBy(DB::raw("sub_category"))
//     ->get()->toArray();
//     $sub_amounts = array_column($sub_amounts, 'count');
//     print_r($sub_amounts);

$currentMonth2 = 6;
$currentMonth = carbon::today()->month;
    $amounts = Spend::select(DB::raw("SUM(amount) as count"))
    ->orderBy("sub_category")
    ->whereRaw('MONTH(created_at) = ?',1)
    ->whereRaw('YEAR(created_at) = ?',2021)
    ->groupBy(DB::raw("(sub_category)"))
    ->get()->toArray();
$amounts = array_column($amounts, 'count');


    $amounts2 = Spend::select(DB::raw("SUM(amount) as count"))
    ->orderBy("sub_category")
    ->whereRaw('MONTH(created_at) = ?',[$currentMonth2])
    ->groupBy(DB::raw("(sub_category)"))
    ->get()->toArray();
$amounts2 = array_column($amounts2, 'count');
$sub_categoryname=Sub_category::select('name')->orderBy("sub_category_id")->get()->toArray();
$sub_categoryname = array_column($sub_categoryname, 'name');


return view('admin.chartjs')
        ->with('amounts',json_encode($amounts,JSON_NUMERIC_CHECK))->with('sub_categoryname',json_encode($sub_categoryname,JSON_NUMERIC_CHECK));
   }
}
