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
                    <form method="post" enctype="multipart/form-data" action="{{route('admin.category.store')}}">
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
            <th class="text-center">Action</th>
        </tr>
    </thead>
    @if(empty($categorys))
    <tr>
    <td>
    <span>There are no data in this table.</span>
    </td>
    </tr>
    @else
    @php $sl=1; @endphp
    @foreach($categorys as $category)
            <tr>
                <td>{{$sl++}}</td>
                <td class="text-center">{{$category->name}}</td>
                <td class="text-center">
                 <a href="{{route('admin.category.delete',$category->category_id)}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Delete</a>
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