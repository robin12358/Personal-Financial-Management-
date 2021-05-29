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
                    <form method="post" enctype="multipart/form-data" action="{{route('admin.subcategory.store')}}">
                            @csrf
                                <div class="form-group">
                               
                                    <label for="hue-demo">Name</label>
                                    @if($errors->has('name'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('name') }}
                                   </div>
                                @endif
                                    <input type="text" name="name" id="hue-demo" class="form-control demo" data-control="hue" >
                                </div>
                                <div class="form-group">
                               
                                    <label for="hue-demo">Category</label>
                                    @if($errors->has('category'))
                                    <div class="invalid-feedback text-danger">
                                 {{ $errors->first('category') }}
                                   </div>
                                @endif
                                    <select  class="select2 form-control custom-select border-secondary" name="category">
                                    <option value="">Select Category</option>
                                    @foreach($categorys as $category)
                                    <option value="{{$category->category_id}}">{{$category->name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    
                    </form>
            </div>
        </div>
    </div>
    <div class="row col-md-10 col-md-offset-2 custyle mt-3">
    <table class="table table-striped custab">
    <thead>
    
        <tr>
            <th>SL</th>
            <th class="text-center" >Title</th>
            <th class="text-center" >Category</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    @if(empty($subcategorys))
    <tr>
    <td>
    <span>There are no data in this table.</span>
    </td>
    </tr>
    @else
    @php $sl=1; @endphp
    @foreach($subcategorys as $subcategory)
            <tr>
                <td>{{$sl++}}</td>
                <td class="text-center">{{$subcategory->name}}</td>
                <td class="text-center">{{$subcategory->categorys->name}}</td>
                <td class="text-center">
                <a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                 <a href="{{route('admin.subcategory.delete',$subcategory->sub_category_id)}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Delete</a>
                </td>
            </tr>
            @endforeach
           @endif
    </table>
    </div>
</div>
@endsection

@section('script')
@endsection