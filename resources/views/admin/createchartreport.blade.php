@extends('admin.layout.master')

@section('style')

@endsection

@section('content')


<div class="container">




<div class="card">
<div class="card-header"><h4>Select First Option.</h4></div>
<div class="card-body">

<form method='POST' ebctype="multipart/form-data" action="{{route('admin.requestedchart')}}">
@csrf
<div class="form-group col-md-6">
 <label>Select Option to create Chart.</label>
 <select id='optionone' name='mainoption' onchange="check()" class="form-control demo" aria-label="Default select example" >
   <option selected>Select Option</option>
   <option value="1">Single Month</option>
   <option value="2">Compair Two Month</option>
   <option value="3">Single year</option>
   <option value="4">Compair Two Year</option>
   <option value="5">All Years Spend chart</option>
   <option value="6">Current Month Spend chart</option>
   <option value="7">Current  Year Spend chart</option>
 </select>
 </div>
</br>
<div id='optiontwo' class="form-group col-md-12 mt-3" style="display: none;">
<div  id='block1'>
 <label>Select Option Two.</label>
 <input type='month' class="form-control demo">
</div>
 </div>

<div id='optiontree' class="form-group col-md-12 mt-3" style="display: none;">
<div id='block2'>
 <label>Report Create by.</label>
 <select id='optionfour' name="optionfour"  class="form-control demo" aria-label="Default select example" >
   <option selected>select a Option</option>
   <option value="11">Category</option>
   <option value="12">Sub Category</option>
 </select>
 </div>
 </div>
 <button type="submit" class="btn btn-success m-3">Submit</button>
</form>                             


</div>
</div>

{{--
 <div class="card col-md-6 mt-3">
        <div class="card-header"><h4>Select Two year to compare Chart of Spend by month</h4></div>
        <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="{{route('admin.chartjstwoyear')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                <label>Select Option to create Chart.</label>
                                <select class="form-control demo" aria-label="Default select example" >
                                  <option selected>Single Month</option>
                                  <option value="1">Single Year</option>
                                  <option value="2">Compair Two Month</option>
                                  <option value="3">Compair Two Year</option>
                                </select>
                                </div>
                                <div class="form-group col-md-6">
                                <label>Select Date.</label>
                                <input type="date" name="date1" class="form-control demo">
                                </div>
                                <div class="form-group col-md-6">
                                <label>Chart Created By.</label>
                                <select class="form-control demo" aria-label="Default select example">
                                  <option selected>By Category</option>
                                  <option value="1">By Subcategory</option>
                                </select>
                                </div>
                             </div>
                                
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    
                    </form>
        </div>
  </div>
  
  <div class="card col-md-6 mt-3">
    <div class="card-header"><h4>Select Two year to compare Chart of Spend by month</h4></div>
    <div class="card-body">
    <form method="post" enctype="multipart/form-data" action="{{route('admin.chartjstwoyear')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                               
                                    <label for="hue-demo">Date 1</label>
                                    @if($errors->has('date1'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('date1') }}
                                   </div>
                                @endif
                                    <input type="month"  min="2016-01" max="2021-12" name="date1" id="hue-demo" class="form-control demo" data-control="hue" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hue-demo">Date 2</label>
                                    @if($errors->has('date'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('date2') }}
                                   </div>
                                @endif
                                    <input type="month"  min="2016-01" max="2021-12" name="date2" id="hue-demo" class="form-control demo" data-control="hue" >
                                </div>
                             </div>
                                
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    
                    </form>
    </div>
  </div>
  
  
  <div class="card col-md-6 mt-3">
    <div class="card-header"><h4>Select Two month to compare Chart of Spend by category</h4></div>
    <div class="card-body">
    <form method="post" enctype="multipart/form-data" action="{{route('admin.chartjstwomonth')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                               
                                    <label for="hue-demo">Date 1</label>
                                    @if($errors->has('date1'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('date1') }}
                                   </div>
                                @endif
                                    <input type="month" min="2016-01" max="2021-12"  name="date1" id="hue-demo" class="form-control demo" data-control="hue" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hue-demo">Date 2</label>
                                    @if($errors->has('date'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('date2') }}
                                   </div>
                                @endif
                                    <input type="month"  min="2016-01" max="2021-12" name="date2" id="hue-demo" class="form-control demo" data-control="hue" >
                                </div>
                             </div>
                                
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    
                    </form>
    </div>
  </div>
--}}





</div>





@endsection

@section('script')
<script>
function cleanblock(){
  var element1 = document.getElementById('block1');
  element1.innerHTML = '';
  var element2 = document.getElementById('block2');
  element2.innerHTML = '';
}
function loadblock2(){
  var element2 =document.getElementById('block2');
    var label2 = [`<label>Select Two Year</label>`];
  var inputs2 = [
        `<div class='row'><select id='optionfour' name="optionfour"  class="form-control demo" aria-label="Default select example" ><option selected>select a Option</option><option value="11">Category</option><option value="12">Sub Category</option></select></div>`
    ];
    element2.innerHTML += label2 +`<br>` +inputs2;

}
function singlemonth(){
  cleanblock();
  var element1 = document.getElementById('block1');
  var label = [`<label>Select Month</label>`];
  var inputs = [
        `<input type='month' id='month1' class='form-control demo' name='month1'>`
    ];
    element1.innerHTML += label +`<br>` +inputs;
    loadblock2();


}
function compmonth(){
  cleanblock();
  var element1 = document.getElementById('block1');
  var label = [`<label>Select Two Month</label>`];
  var inputs = [
        `<div class='row'><div class="form-group col-md-5 mt-3"><input type='month'min="2016-01" max="2021-12" id='month1' class='form-control demo' name='month1'></div> <div class="form-group col-md-6 mt-3"> <input type='month' min="2016-01" max="2021-12" id='month2' class='form-control demo' name='month2'></div></div>`
    ];
    element1.innerHTML += label +`<br>` +inputs;
    loadblock2();

}
function singleyear(){
  cleanblock();
  var element1 = document.getElementById('block1');
  var label = [ `<label>Select A Year</label>`];
  var inputs = [
        `<input type="month" id="datepicker" class='form-control demo' name='year1'>`
    ];
    element1.innerHTML += label +`<br>` +inputs;
    loadblock2();
}

function compyear(){
  cleanblock();
  var element1 = document.getElementById('block1');
  var label = [`<label>Select Two Year</label>`];
  var inputs = [
        `<div class='row'><div class="form-group col-md-5 mt-3"><input type='month' id='year1' class='form-control demo' name='year1'></div> <div class="form-group col-md-6 mt-3"> <input type='month' id='year2' class='form-control demo' name='year2'></div></div>`
    ];
    element1.innerHTML += label +`<br>` +inputs;
    loadblock2();
}
function secendblock(){
  document.getElementById('optiontwo').style.display = "block";
  document.getElementById('optiontree').style.display = "block";
}
function secendblockv2(){
  document.getElementById('optiontree').style.display = "block";
  loadblock2();
}
function addmonthoption(){
  $("#optionfour option").remove()
var select = document.getElementById("optionfour");
 select.options[select.options.length] = new Option('select Option', '');
 select.options[select.options.length] = new Option('By Category', '222');
 select.options[select.options.length] = new Option('By Sub-category', '333');
}
function  addyearoption(){
  $("#optionfour option").remove()
var select = document.getElementById("optionfour");
 select.options[select.options.length] = new Option('select Option', '');
 select.options[select.options.length] = new Option('By Category', '222');
 select.options[select.options.length] = new Option('By Sub-category', '333');
 select.options[select.options.length] = new Option('By Month', '444');
}
function check(){
var val = document.getElementById('optionone').value;
switch(val)  
{  
case  '1':
  singlemonth();
  secendblock();
  addmonthoption();
break;  
case '2':
  compmonth();
  secendblock(); 
  addmonthoption();
break;
case '3':
  singleyear();
  secendblock(); 
  addyearoption();
break;
case '4':
  compyear();
  secendblock(); 
  addyearoption(); 
break;
case '5':
  cleanblock();
break;
case '6':
  cleanblock();
  secendblockv2();
  addmonthoption();
break;
case '7':
  cleanblock();
  secendblockv2();
  addyearoption();
break;
default:
console.log('Nothing'); 
break;  
} 

}

</script>
@endsection