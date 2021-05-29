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

class ChartController extends Controller
{   public function requested(Request $request){
    $mainoptionvalue = $request->mainoption;
    switch($mainoptionvalue){
        case 1:
        $validator = Validator::make($request->all(),[
            'month1'=>'required',
            'optionfour'=>'required'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            if($request->optionfour == '333'){
                $data['month']=$request->month1;
                return redirect()->route('admin.chartjsmonth')->with('data', $data);
            }elseif($request->optionfour == '222'){
                $data['month']=$request->month1;
                return redirect()->route('admin.chartjsmonthbycategory')->with('data', $data);
            }else{

            }
             }
        break;
        case 2:
            $validator = validator::make($request->all(),[
                'month1' => 'required',
                'month2' => 'required',
                'optionfour' => 'required'
            ]);
            if($validator->fails()){
                return back()->withErrors($validator);
            }else{
                if($request->optionfour == '333'){
                    $data['month1'] =$request->month1;
                    $data['month2'] =$request->month2;
                    return redirect()->route('admin.chartjstwomonthbysubcategory')->with('data',$data);
                }else{
                    $data['month1'] =$request->month1;
                    $data['month2'] =$request->month2;
                    return redirect()->route('admin.chartjstwomonthbycategory')->with('data',$data);
                }
            }
        break;
        case 3:
            $validator = validator::make($request->all(),[
                'year1' => 'required',
                'optionfour' => 'required'
            ]);
            if($validator->fails()){
                return back()->withErrors($validator);
            }else{
                if($request->optionfour == '333'){
                    $data['year1'] =$request->year1;
                    return redirect()->route('admin.chartjsyearbysubcategory')->with('data',$data);
                }elseif($request->optionfour == '222'){
                    $data['year1'] =$request->year1;
                    return redirect()->route('admin.chartjsyearbycategory')->with('data',$data);
                }else{
                    $data['year1'] =$request->year1;
                    return redirect()->route('admin.chartjsyearbymonth')->with('data',$data);
                }
            }
        break;
        case 4:
            $validator = validator::make($request->all(),[
                'year1' => 'required',
                'year2' => 'required',
                'optionfour' => 'required'
            ]);
            if($validator->fails()){
                return back()->withErrors($validator);
            }else{
                if($request->optionfour == '333'){
                    $data['year1'] =$request->year1;
                    $data['year2'] =$request->year2;
                    return redirect()->route('admin.chartjstwoyearbysubcategory')->with('data',$data);
                }elseif($request->optionfour == '222'){
                    $data['year1'] =$request->year1;
                    $data['year2'] =$request->year2;
                    return redirect()->route('admin.chartjstwoyearbycategory')->with('data',$data);
                }else{
                    $data['year1'] =$request->year1;
                    $data['year2'] =$request->year2;
                    return redirect()->route('admin.chartjstwoyearbymonth')->with('data',$data);
                }
            }
        break;
        case 5:
            dd('5');
        break;
        case 6:
            $validator = Validator::make($request->all(),[
                'optionfour'=>'required'
            ]);
            $date = Carbon::now()->toDateTimeString();
            if($validator->fails()){
                return back()->withErrors($validator);
            }else{
                if($request->optionfour == '333'){
                    $data['month']=$date;
                    return redirect()->route('admin.chartjsmonth')->with('data', $data);
                }elseif($request->optionfour == '222'){
                    $data['month']=$date;
                    return redirect()->route('admin.chartjsmonthbycategory')->with('data', $data);
                }else{
    
                }
                 }
        break;
        case 7:
            $validator = validator::make($request->all(),[
                'optionfour' => 'required'
            ]);
            $date = Carbon::now()->toDateTimeString();
            if($validator->fails()){
                return back()->withErrors($validator);
            }else{
                if($request->optionfour == '333'){
                    $data['year1'] =$date;
                    return redirect()->route('admin.chartjsyearbysubcategory')->with('data',$data);
                }elseif($request->optionfour == '222'){
                    $data['year1'] =$date;
                    return redirect()->route('admin.chartjsyearbycategory')->with('data',$data);
                }else{
                    $data['year1'] =$date;
                    return redirect()->route('admin.chartjsyearbymonth')->with('data',$data);
                }
            }
        break;
        default:
        dd('500');
    }

    }
    public function chartrequest(){
        return view('admin.createchartreport');
    }
    public function chartjsmonth(){
        $data2 = Spend::select(DB::raw('MAX(created_at) as max_date'))->get()->toArray();
        $data1 = Spend::select(DB::raw('MIN(created_at) as min_date'))->get()->toArray();
        dd($data1,$data2);
        $dirs = session('data');
        $currentdate = $dirs['month'];
        $tim =strtotime($currentdate);
        $c_month = date('m',$tim);
        $c_year= date('Y',$tim);
        $data= Sub_category::with('spends')->get();
        $datacategorys= Sub_category::with(['spends' => function($query) use ($c_year,$c_month) {
            $query->whereMonth('spends.created_at', $c_month)
            ->whereYear('spends.created_at', $c_year);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datacategorys as $key => $subcategory){
              $totalamount=0;

                foreach($subcategory['spends'] as $value){
                    $totalamount += $value['amount'];
                }
                $subcategory['total_amount']= $totalamount;
                array_push($subcategory,$subcategory['total_amount']);
                $datacategorys[$key]['total_amount'] =$subcategory['total_amount'] ;
                $totalamount =0;  
          }
          $month = $dirs['month'];
          $data = collect($datacategorys);
          $name = $data->pluck('name',);
          $value = $data->pluck('total_amount');
          return view('admin.chartjs')
          ->with('value',json_encode($value,JSON_NUMERIC_CHECK))->with('month',$month)->with('name',json_encode($name,JSON_NUMERIC_CHECK));
    }
    public function chartjsmonthbycategory(){
        $dirs = session('data');
        $currentdate = $dirs['month'];
        $tim =strtotime($currentdate);
        $c_month = date('m',$tim);
        $c_year= date('Y',$tim);
        $datacategorys= Category::with(['spends' => function($query) use ($c_year,$c_month) {
            $query->whereMonth('spends.created_at', $c_month)
            ->whereYear('spends.created_at', $c_year);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datacategorys as $key => $category){
              $totalamount=0;
                foreach($category['spends'] as $value){
                    $totalamount += $value['amount'];
                }
                $category['total_amount']= $totalamount;
                array_push($category,$category['total_amount']);
                $datacategorys[$key]['total_amount'] =$category['total_amount'] ;
                $totalamount =0;  
          }
          $month = $dirs['month'];
          $data = collect($datacategorys);
          $name = $data->pluck('name',);
          $value = $data->pluck('total_amount');
          return view('admin.chartjs')
          ->with('value',json_encode($value,JSON_NUMERIC_CHECK))->with('month',$month)->with('name',json_encode($name,JSON_NUMERIC_CHECK));
    }
    public function chartjstwomonthbycategory(){
        $dirs = session('data');
        $currentdate1 = $dirs['month1'];
        $currentdate2 = $dirs['month2'];
        $tim1 =strtotime($currentdate1);
        $c_month1 = date('m',$tim1);
        $c_year1= date('Y',$tim1);
        $tim2 =strtotime($currentdate2);
        $c_month2 = date('m',$tim2);
        $c_year2= date('Y',$tim2);
        $datacategorys1= Category::with(['spends' => function($query) use ($c_year1,$c_month1) {
            $query->whereYear('spends.created_at', $c_year1)
            ->whereMonth('spends.created_at', $c_month1);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datacategorys1 as $key => $category){
              $totalamount=0;
                foreach($category['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $category['total_amount']= $totalamount;
                array_push($category,$category['total_amount']);
                $datacategorys1[$key]['total_amount'] =$category['total_amount'] ;
                $totalamount =0;     
          }
            $datacategorys2= Category::with(['spends' => function($query) use ($c_year2,$c_month2) {
            $query->whereYear('spends.created_at', $c_year2)
            ->whereMonth('spends.created_at', $c_month2);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datacategorys2 as $key => $category){
              $totalamount=0;
                foreach($category['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $category['total_amount']= $totalamount;
                array_push($category,$category['total_amount']);
                $datacategorys2[$key]['total_amount'] =$category['total_amount'] ;
                $totalamount =0;     
          }
          $month1 = $dirs['month1'];
          $month2 = $dirs['month2'];
          $data1 = collect($datacategorys1);
          $name1 = $data1->pluck('name',);
          $value1 = $data1->pluck('total_amount');
          $data2 = collect($datacategorys2);
          $name2 = $data2->pluck('name',);
          $value2 = $data2->pluck('total_amount');
          return view('admin.chartjscomp')
          ->with('value1',json_encode($value1,JSON_NUMERIC_CHECK))->with('month1',$month1)->with('name1',json_encode($name1,JSON_NUMERIC_CHECK))
          ->with('value2',json_encode($value2,JSON_NUMERIC_CHECK))->with('month2',$month2)->with('name2',json_encode($name2,JSON_NUMERIC_CHECK));
    }
    public function chartjstwomonthbysubcategory(){
        $dirs = session('data');
        $currentdate1 = $dirs['month1'];
        $currentdate2 = $dirs['month2'];
        $tim1 =strtotime($currentdate1);
        $c_month1 = date('m',$tim1);
        $c_year1= date('Y',$tim1);
        $tim2 =strtotime($currentdate2);
        $c_month2 = date('m',$tim2);
        $c_year2= date('Y',$tim2);
        $datasubcategorys1= Sub_category::with(['spends' => function($query) use ($c_year1,$c_month1) {
            $query->whereYear('spends.created_at', $c_year1)
            ->whereMonth('spends.created_at', $c_month1);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datasubcategorys1 as $key => $subcategory){
              $totalamount=0;
                foreach($subcategory['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $subcategory['total_amount']= $totalamount;
                array_push($subcategory,$subcategory['total_amount']);
                $datasubcategorys1[$key]['total_amount'] =$subcategory['total_amount'] ;
                $totalamount =0;     
          }
            $datasubcategorys2= Category::with(['spends' => function($query) use ($c_year2,$c_month2) {
            $query->whereYear('spends.created_at', $c_year2)
            ->whereMonth('spends.created_at', $c_month2);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datasubcategorys2 as $key => $subcategory){
              $totalamount=0;
                foreach($subcategory['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $subcategory['total_amount']= $totalamount;
                array_push($subcategory,$subcategory['total_amount']);
                $datasubcategorys2[$key]['total_amount'] =$subcategory['total_amount'] ;
                $totalamount =0;     
          }
          $month1 = $dirs['month1'];
          $month2 = $dirs['month2'];
          $data1 = collect($datasubcategorys1);
          $name1 = $data1->pluck('name',);
          $value1 = $data1->pluck('total_amount');
          $data2 = collect($datasubcategorys2);
          $name2 = $data2->pluck('name',);
          $value2 = $data2->pluck('total_amount');
          return view('admin.chartjscomp')
          ->with('value1',json_encode($value1,JSON_NUMERIC_CHECK))->with('month1',$month1)->with('name1',json_encode($name1,JSON_NUMERIC_CHECK))
          ->with('value2',json_encode($value2,JSON_NUMERIC_CHECK))->with('month2',$month2)->with('name2',json_encode($name2,JSON_NUMERIC_CHECK));
    }
    public function chartjsyearbysubcategory(){
        $dirs = session('data');
        $currentdate = $dirs['year1'];
        $tim =strtotime($currentdate);
        $c_year= date('Y',$tim);
        $datasubcategorys= Sub_category::with(['spends' => function($query) use ($c_year) {
            $query->whereYear('spends.created_at', $c_year);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datasubcategorys as $key => $subcategory){
              $totalamount=0;
                foreach($subcategory['spends'] as $value){
                    $totalamount += $value['amount'];
                }
                $subcategory['total_amount']= $totalamount;
                array_push($subcategory,$subcategory['total_amount']);
                $datasubcategorys[$key]['total_amount'] =$subcategory['total_amount'] ;
                $totalamount = 0;  
          }
          $month = $dirs['year1'];
          $data = collect($datasubcategorys);
          $name = $data->pluck('name',);
          $value = $data->pluck('total_amount');
          return view('admin.chartjs')
          ->with('value',json_encode($value,JSON_NUMERIC_CHECK))->with('month',$month)->with('name',json_encode($name,JSON_NUMERIC_CHECK));
    }
    public function chartjsyearbymonth(){
        $dirs = session('data');
        $currentdate = $dirs['year1'];
        $tim =strtotime($currentdate);
        $c_year= date('Y',$tim);
        $datacategorys= Spend::whereRaw('YEAR(created_at) = ?',$c_year)
        ->get()->toArray();
        $monthv=['1'=>'0','2'=>'0','3'=>'0','4'=>'0','5'=>'0','6'=>'0','7'=>'0','8'=>'0','9'=>'0','10'=>'0','11'=>'0','12'=>'0'];
        
        foreach($datacategorys as $category){
            $datam =Carbon::parse($category['created_at'])->format('m');
            $datam=(int)$datam;
            $monthv[$datam] += $category['amount'];
        }

          $month = $dirs['year1'];
          $value = array_values($monthv);
          return view('admin.chartjsbymonth')
          ->with('value',json_encode($value,JSON_NUMERIC_CHECK))->with('month',$month);



        //           $users = User::select('id', 'created_at')
        // ->get()
        // ->groupBy(function($date) {
        //     //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
        //     return Carbon::parse($date->created_at)->format('m'); // grouping by months
        // });
        
        // $usermcount = [];
        // $userArr = [];
        
        // foreach ($users as $key => $value) {
        //     $usermcount[(int)$key] = count($value);
        // }
        
        // for($i = 1; $i <= 12; $i++){
        //     if(!empty($usermcount[$i])){
        //         $userArr[$i] = $usermcount[$i];    
        //     }else{
        //         $userArr[$i] = 0;    
        //     }
        // }
        


    }
    public function chartjstwoyearbycategory(){
        $dirs = session('data');
        $currentdate1 = $dirs['year1'];
        $currentdate2 = $dirs['year2'];
        $tim1 =strtotime($currentdate1);
        $c_year1= date('Y',$tim1);
        $tim2 =strtotime($currentdate2);
        $c_year2= date('Y',$tim2);
        $datacategorys1= Category::with(['spends' => function($query) use ($c_year1){
            $query->whereYear('spends.created_at', $c_year1);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datacategorys1 as $key => $category){
              $totalamount=0;
                foreach($category['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $category['total_amount']= $totalamount;
                array_push($category,$category['total_amount']);
                $datacategorys1[$key]['total_amount'] =$category['total_amount'] ;
                $totalamount =0;     
          }
            $datacategorys2= Category::with(['spends' => function($query) use ($c_year2) {
            $query->whereYear('spends.created_at', $c_year2);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datacategorys2 as $key => $category){
              $totalamount=0;
                foreach($category['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $category['total_amount']= $totalamount;
                array_push($category,$category['total_amount']);
                $datacategorys2[$key]['total_amount'] =$category['total_amount'] ;
                $totalamount =0;     
          }
          $year1 = $dirs['year1'];
          $year2 = $dirs['year2'];
          $data1 = collect($datacategorys1);
          $name1 = $data1->pluck('name',);
          $value1 = $data1->pluck('total_amount');
          $data2 = collect($datacategorys2);
          $name2 = $data2->pluck('name',);
          $value2 = $data2->pluck('total_amount');
          $namevalue ='Category';
          return view('admin.chartjscompyear')->with('namevalue',$namevalue)
          ->with('value1',json_encode($value1,JSON_NUMERIC_CHECK))->with('year1',$year1)->with('name1',json_encode($name1,JSON_NUMERIC_CHECK))
          ->with('value2',json_encode($value2,JSON_NUMERIC_CHECK))->with('year2',$year2)->with('name2',json_encode($name2,JSON_NUMERIC_CHECK));
    }
    public function chartjstwoyearbysubcategory(){
        $dirs = session('data');
        $currentdate1 = $dirs['year1'];
        $currentdate2 = $dirs['year2'];
        $tim1 =strtotime($currentdate1);
        $c_year1= date('Y',$tim1);
        $tim2 =strtotime($currentdate2);
        $c_year2= date('Y',$tim2);
        $datasubcategorys1= Sub_category::with(['spends' => function($query) use ($c_year1) {
            $query->whereYear('spends.created_at', $c_year1);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datasubcategorys1 as $key => $subcategory){
              $totalamount=0;
                foreach($subcategory['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $subcategory['total_amount']= $totalamount;
                array_push($subcategory,$subcategory['total_amount']);
                $datasubcategorys1[$key]['total_amount'] =$subcategory['total_amount'] ;
                $totalamount =0;     
             }
            $datasubcategorys2= Category::with(['spends' => function($query) use ($c_year2) {
            $query->whereYear('spends.created_at', $c_year2);
          }])->get()->toArray();
          $chartlist = [];
          foreach($datasubcategorys2 as $key => $subcategory){
              $totalamount=0;
                foreach($subcategory['spends'] as $value){
                    $totalamount += $value['amount'];     
                }
                $subcategory['total_amount']= $totalamount;
                array_push($subcategory,$subcategory['total_amount']);
                $datasubcategorys2[$key]['total_amount'] =$subcategory['total_amount'] ;
                $totalamount =0;     
          }
          $year1 = $dirs['year1'];
          $year2 = $dirs['year2'];
          $data1 = collect($datasubcategorys1);
          $name1 = $data1->pluck('name',);
          $value1 = $data1->pluck('total_amount');
          $data2 = collect($datasubcategorys2);
          $name2 = $data2->pluck('name',);
          $value2 = $data2->pluck('total_amount');
          $namevalue ='Sub-category';
          return view('admin.chartjscompyear')->with('namevalue',$namevalue)
          ->with('value1',json_encode($value1,JSON_NUMERIC_CHECK))->with('year1',$year1)->with('name1',json_encode($name1,JSON_NUMERIC_CHECK))
          ->with('value2',json_encode($value2,JSON_NUMERIC_CHECK))->with('year2',$year2)->with('name2',json_encode($name2,JSON_NUMERIC_CHECK));
    }
    public function chartjstwoyearbymonth(){
        $dirs = session('data');
        $currentdate1 = $dirs['year1'];
        $currentdate2 = $dirs['year2'];
        $tim1 =strtotime($currentdate1);
        $tim2 =strtotime($currentdate2);
        $c_year1= date('Y',$tim1);
        $c_year2= date('Y',$tim2);
        $datacategorys1= Spend::whereRaw('YEAR(created_at) = ?',$c_year1)
        ->get()->toArray();
        $monthv1=['1'=>'0','2'=>'0','3'=>'0','4'=>'0','5'=>'0','6'=>'0','7'=>'0','8'=>'0','9'=>'0','10'=>'0','11'=>'0','12'=>'0'];
        
        foreach($datacategorys1 as $category){
            $datam =Carbon::parse($category['created_at'])->format('m');
            $datam=(int)$datam;
            $monthv1[$datam] += $category['amount'];
        }
        $datacategorys2= Spend::whereRaw('YEAR(created_at) = ?',$c_year2)
        ->get()->toArray();
        $monthv2=['1'=>'0','2'=>'0','3'=>'0','4'=>'0','5'=>'0','6'=>'0','7'=>'0','8'=>'0','9'=>'0','10'=>'0','11'=>'0','12'=>'0'];
        
        foreach($datacategorys2 as $category){
            $datam =Carbon::parse($category['created_at'])->format('m');
            $datam=(int)$datam;
            $monthv2[$datam] += $category['amount'];
        }

          $year1 = $dirs['year1'];
          $year2 = $dirs['year2'];
          $value1= array_values($monthv1);
          $value2 = array_values($monthv2);
          $namevalue ='Month';
          return view('admin.yearcompbymonth')->with('namevalue',$namevalue)
          ->with('value1',json_encode($value1,JSON_NUMERIC_CHECK))->with('value2',json_encode($value2,JSON_NUMERIC_CHECK))->with('year1',$year1)->with('year2',$year2);
    }
    public function chartjsbycurrentmonth(){
        $currentdate = '2019-09-09';
        $tim =strtotime($currentdate);
        $c_month = date('m',$tim);
        $c_year= date('Y',$tim);
        $datacategorys= Category::with(['spends' => function($query) {
            $query->whereYear('spends.created_at', '2019');
          }])->get()->toArray();
          $chartlist = [];
          foreach($datacategorys as $key => $category){
              $totalamount=0;
             

                foreach($category['spends'] as $value){
                    $totalamount += $value['amount'];
                  
                }
                $category['total_amount']= $totalamount;
                array_push($category,$category['total_amount']);
                $datacategorys[$key]['total_amount'] =$category['total_amount'] ;
                $totalamount =0;
            
               
                
             
          }
          $data = collect($datacategorys);

          $name = $data->pluck('name',);
          $value = $data->pluck('total_amount');
          return view('admin.chartjs')
          ->with('value',json_encode($value,JSON_NUMERIC_CHECK))->with('name',json_encode($name,JSON_NUMERIC_CHECK));
          exit;
          return view('admin.spend',$data);
   
        $data = DB::table('spends')
        ->join('sub_categories','sub_categories.sub_category_id','=','spends.sub_category')
        ->join('categories','categories.category_id','=','sub_categories.category')
        ->select('spends.*','sub_categories.*','categories.name')
        ->select(DB::raw("SUM(amount) as count"))
        ->orderBy("category")
        ->whereRaw('YEAR(spends.created_at) = ?',$c_year)
        ->whereRaw('MONTH(spends.created_at) = ?', $c_month)
        ->groupBy(DB::raw("(category)",'desc'))
        ->get()->toArray();
        dd($data);
        $data = array_column($data, 'count');
        
      $data['categorys'] = Category::with('spends')->get();
      return view('admin.spend',$data);
      exit;
        $currentdate = '2016-09-09';
        $tim =strtotime($currentdate);
        $c_month = date('m',$tim);
        $c_year= date('Y',$tim);
   
        $amounts = Spend::select(DB::raw("SUM(amount) as count"))
        ->orderBy("sub_category")
        ->whereRaw('YEAR(created_at) = ?',$c_year)
        ->whereRaw('MONTH(created_at) = ?', $c_month)
        ->groupBy(DB::raw("(sub_category)"))
        ->get()->toArray();
        dd($amounts);
         $sub_categoryname=Sub_category::select('name')->orderBy("sub_category_id")->get()->toArray();
         $sub_categoryname = array_column($sub_categoryname, 'name');
         return view('admin.chartjs')
         ->with('amounts',json_encode($amounts,JSON_NUMERIC_CHECK))->with('sub_categoryname',json_encode($sub_categoryname,JSON_NUMERIC_CHECK));

    
    }
    public function chartjsbycurrentyear(){
        $currentdate = '2016-09-09';
        $tim =strtotime($currentdate);
        $c_year= date('Y',$tim);
   
        $amounts = Spend::select(DB::raw("SUM(amount) as count"))
        ->orderBy("sub_category")
        ->whereRaw('YEAR(created_at) = ?',$c_year)
        ->groupBy(DB::raw("(sub_category)"))
        ->get()->toArray();
         $amounts = array_column($amounts, 'count');
         $sub_categoryname=Sub_category::select('name')->orderBy("sub_category_id")->get()->toArray();
         $sub_categoryname = array_column($sub_categoryname, 'name');
         return view('admin.chartjs')
         ->with('amounts',json_encode($amounts,JSON_NUMERIC_CHECK))->with('sub_categoryname',json_encode($sub_categoryname,JSON_NUMERIC_CHECK));

    
    }
    public function chartjsbycurrentyearbymonth(){
        $currentdate = '2017-09-09';
        $tim =strtotime($currentdate);
        $c_year= date('Y',$tim);
   
        $amounts = Spend::select(DB::raw("SUM(amount) as count"))
        ->whereRaw('YEAR(created_at) = ?',$c_year)
        ->orderBy('created_at')
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->get()->toArray();
        $data1 = collect($amounts);
        $array = $data1->pluck('count');
         return view('admin.chartjsbymonth')
         ->with('array',json_encode($array,JSON_NUMERIC_CHECK));

    
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
         dd(date('m',$tim1),date('m',$tim2));
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
     dd($amounts,$amounts2);
     $sub_categoryname=Sub_category::select('name')->orderBy("sub_category_id")->get()->toArray();
     $sub_categoryname = array_column($sub_categoryname, 'name');
     
     
     return view('admin.chartjs')
             ->with('amounts',json_encode($amounts,JSON_NUMERIC_CHECK))->with('sub_categoryname',json_encode($sub_categoryname,JSON_NUMERIC_CHECK));
    }
    public function singlemonth(){

    }
    public function singleyear(){

    }
    public function towmonthcomp(){}
    public function chartjstwoyear(Rrequest $request){
        
        $tim1 =strtotime($$request->date1);
        $c_year1= date('Y',$tim1);
        $tim2 =strtotime($$request->date2);
        $c_year2= date('Y',$tim2);
        $amounts1 = Spend::select(DB::raw("SUM(amount) as count"))
        ->whereRaw('YEAR(created_at) = ?',$c_year1)
        ->orderBy('created_at')
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->get()->toArray();
        $amounts2 = Spend::select(DB::raw("SUM(amount) as count"))
        ->whereRaw('YEAR(created_at) = ?',$c_year2)
        ->orderBy('created_at')
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->get()->toArray();
        $year1 = $request->date1;
        $year2 = $request->date2;
        $data1 = collect($amounts1);
        $data2 = collect($amounts2);
        $array1 = $data1->pluck('count');
        $array2 = $data2->pluck('count');
         return view('admin.yearcompbymonth')
         ->with('year1',$year1)
         ->with('year2',$year2)
         ->with('array1',json_encode($array1,JSON_NUMERIC_CHECK))
         ->with('array2',json_encode($array2,JSON_NUMERIC_CHECK));
    }
    public function growthyear(){

    }

}
