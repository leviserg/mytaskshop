@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
        <div class="col-md-10">
             @foreach($data as $product)
            <div class="card">
                <div class="card-header">{{$product->id}} <b class="ml-2"> Product Type : {{$product->type}}</b></div>
                <div class="card-body">
                    <div class="col-md-12">
                        <form enctype="multipart/form-data" action="/{{$product->id}}" method="POST" class="form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 clear-fix"></div>
                                    <div class="col-md-9">
                                        <img src="{{$product->img}}" class="pull-right img-responsive" width="auto" height="auto"/>
                                        <label for="product_image" class="ml-2"> Select Image </label>
                                    <input type="file" name="product_image" id="product_image" value="{{$product->img}}"/>
                                        <span id="uploaded_img">{{$product->img}}</span><br/>
                                    </div>
                                    <div class="col-md-1 clear-fix"></div>                                   
                                </div>
                                    <input name="curtype" style="display: none" value="{{$product->typeid}}">
                                    <input name="curid" style="display: none" value="{{$product->id}}">
                                <label for="productName" class="control-label">Name</label>
                                    <input type="text" name="productName" id="prodNameId" class="form-control mb-2" value="{{$product->pname}}">
                                <label for="productPrice" class="control-label">Price</label>
                                    <input type="number" name="productPrice" id="prodPriceId" class="form-control mb-2" value="{{$product->price}}">
                                <label for="productType" class="control-label">Type</label>
                                    <select name="producType" id="productTypeId" class="form-control  mb-2">
                                        <option value="0">Select type..</option>
                                            @foreach($types as $type)
                                                @if($type->id === $product->typeid)
                                                    <option value="{{$type->id}}" selected="selected">{{$type->type}}</option>
                                                @else
                                                    <option value="{{$type->id}}">{{$type->type}}</option>
                                                @endif  
                                            @endforeach
                                    </select>
                                <label for="productParam1" class="control-label">Feature 1</label>
                                    <select name="productParam1" id="productParam1Id" class="form-control  mb-2">
                                        <option value="0">Select feature...</option>
                                            @foreach($params[0] as $param1)
                                                @if($param1->param === $product->c1param)
                                                    <option value="{{$param1->cid}}" selected="selected">{{$param1->param}}</option>
                                                @else
                                                    <option value="{{$param1->cid}}">{{$param1->param}}</option>
                                                @endif  
                                            @endforeach
                                    </select>
                                <label for="productParam2" class="control-label">Feature 2</label>
                                    <select name="productParam2" id="productParam2Id" class="form-control  mb-2">
                                        <option value="0">Select feature...</option>
                                            @foreach($params[1] as $param2)
                                                @if($param2->param === $product->c2param)
                                                    <option value="{{$param2->cid}}" selected="selected">{{$param2->param}}</option>
                                                @else
                                                    <option value="{{$param2->cid}}">{{$param2->param}}</option>
                                                @endif  
                                            @endforeach
                                    </select>
                                <label for="productParam3" class="control-label">Feature 3</label>
                                    <select name="productParam3" id="productParam3Id" class="form-control  mb-2">
                                        <option value="0">Select feature...</option>
                                            @foreach($params[2] as $param3)
                                                @if($param3->param === $product->c3param)
                                                    <option value="{{$param3->cid}}" selected="selected">{{$param3->param}}</option>
                                                @else
                                                    <option value="{{$param3->cid}}">{{$param3->param}}</option>
                                                @endif  
                                            @endforeach
                                    </select>
                                <div class="mt-4 row">                       
                                    <div class="col-md-6">
                                        <a href="/" class="btn btn-success mr-2" style="width:30%">Back</a>
                                        <button type="submit" class="btn btn-info ml-2" style="width:30%">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>        
@endsection
@push('scripts')
    <script>
        $("select[name='producType']").bind("change",function(){
            var url = "/buf/" + this.value;
            var sel = {id:this.value};
            var action = function(data){
                data = JSON.parse(data);
                
                $("select[name='productParam1']").empty();
                $("select[name='productParam2']").empty();
                $("select[name='productParam3']").empty();
                
                for(var id in data){

                    $("select[name='productParam"+(Number(id)+1)+"']").append($("<option value='0' selected='selected'>Select feature...</option>"));

                    for(var i in data[id]){
                        $("select[name='productParam"+(Number(id)+1)+"']").append($("<option value='"+data[id][i].cid+"'>" + data[id][i].param + "</option>"));
                    }
                }

                };
                $.get(url,sel,action);// call ajax get method
        });
    </script>
@endpush