@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Feature 1</th>
                    <th>Feature 2</th>
                    <th>Feature 3</th>
                    <th>ImgUrl</th>
                    <th>Edit</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('main.getdata') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'pname', name: 'pname' },
                    { data: 'price', name: 'price' },
                    { data: 'type', name: 'types.type' },
                    { data: 'c1param', name: 'c1s.param' },
                    { data: 'c2param', name: 'c2s.param' },
                    { data: 'c3param', name: 'c3s.param' },
                    {
                        "data":{
                            "img":"img",
                        },
                        "render": function(data, type, row, meta){
                            if(type === 'display'){
                                data = '<img src=' + data.img + ' class="img-thumbnail" width="35" height="35"></img>';
                            }
                            return data;
                        }
                    },
                    {
                        "data":{
                            "id":"id"
                        },
                        "render": function(data, type, row, meta){
                            if(type === 'display'){
                                data = '<a class="btn btn-primary" href="/'+ data.id +'">Edit</a>';
                            }
                            return data;
                        }
                    } 
                ],
                aoColumnDefs:[
                    {
                        "searchable": false,
                        "aTargets": [0,7,8] 
                    },
                    {
                        "orderable":false,
                        "aTargets":[7,8]
                    }                 
                ]                
            });
        });
    </script>
@endpush