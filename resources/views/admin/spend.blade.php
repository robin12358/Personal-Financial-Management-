@extends('admin.layout.master')

@section('style')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="card col-md-12 mb-3">
            <div class="card-header">
            <h2>Add Category</h2>
            </div>
            <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="{{route('admin.spendstore')}}">
                            @csrf
                                <div class="form-group">
                               
                                    <label for="hue-demo">Description</label>
                                    @if($errors->has('description'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('description') }}
                                   </div>
                                @endif
                                    <textarea id="hue-demo" class="form-control demo"  name="description" data-control="hue" ></textarea>
                                </div>
                                <div class="form-group">
                               
                                    <label for="hue-demo">Select Category</label>
                                    @if($errors->has('category'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('category') }}
                                   </div>
                                @endif
                                <select name="category" id="category" class="form-control demo" aria-label="Default select example" onchange="check()">
                                  <option selected>Select Category</option>
                                @foreach($categorys as $category)
                                  <option value="{{$category->category_id}}">{{$category->name}}</option>
                                 @endforeach
                                </select>
                                </div>
                                <div class="form-group">
                               
                                    <label for="hue-demo">Select Sub-category</label>
                                    @if($errors->has('subcategory'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('subcategory') }}
                                   </div>
                                @endif
                                <div id='block1'>
                                <select id='subcategory' name="subcategory" class="form-control demo" aria-label="Default select example" >
                                  <option selected>Select Category first</option>
                                </select>
                                </div>
                                </div>
                                <div class="form-group">
                               
                                    <label for="hue-demo">Put your spend amount</label>
                                    @if($errors->has('amounts'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('amounts') }}
                                   </div>
                                @endif
                                    <input type="number" name="amounts" id="hue-demo" class="form-control demo" data-control="hue" >
                                </div>
                                
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    
                    </form>
            </div>
        </div>
    </div>
    <div class="row col-md-10 col-md-offset-2 custyle mt-3">
    <table class="table table-striped custab">
  

    </table>
    </div>
</div>
@endsection

@section('script')
<script>
function check(){
    var subs =<?php echo json_encode($subcategorys); ?>;
    var category = document.getElementById('category');
    var element1 = document.getElementById('subcategory');
    element1.innerHTML = '';
    subs.forEach(function(sub){
        if(sub['category'] == category.value){
    element1.innerHTML += "<option value="+sub['sub_category_id']+">"+sub['name']+"</option>";
        }
      
    });
}
</script>
@endsection