<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
Use DB;
use App\Type;
use App\C1;
use App\C2;
use App\C3;
use App\Product;
use Yajra\Datatables\Datatables;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function newrec()
    {
        $types = DB::table('types')->select('*')->get();
        return view('newproduct', compact('types'));
    }

    public function getsingle($id)
    {
        $data = Product::join('types', 'products.typeid', '=', 'types.id')
        ->join('c1s', function($join){
            $join->on('products.c1param', '=', 'c1s.cid')->on('products.typeid', '=', 'c1s.typeid');
        })
        ->join('c2s', function($join){
            $join->on('products.c2param', '=', 'c2s.cid')->on('products.typeid', '=', 'c2s.typeid');
        })
        ->join('c3s', function($join){
            $join->on('products.c3param', '=', 'c3s.cid')->on('products.typeid', '=', 'c3s.typeid');
        })
        ->select([
            'products.id as id',
            'products.pname as pname',
            'products.price as price',
            'products.typeid as typeid',
            'types.type as type',
            'c1s.param as c1param',
            'c2s.param as c2param',
            'c3s.param as c3param',
            'products.img as img'
        ])->where('products.id','=',$id)->get();

        $types = DB::table('types')->select('*')->get();
        $curtypeid = $data[0]->typeid;

        $params1 = DB::table('c1s')->select('cid','param')
            ->where('typeid', '=', $curtypeid)
            ->get();
        $params2 = DB::table('c2s')->select('cid','param')
            ->where('typeid', '=', $curtypeid)
            ->get();
        $params3 = DB::table('c3s')->select('cid','param')
            ->where('typeid', '=', $curtypeid)
            ->get();
        $params = [$params1,$params2,$params3];
       
        return view('single', compact('data', 'params', 'types'));
    }

    public function store(Request $request){

        if ($request->hasFile('product_image')) {

            $this->validate($request, [
                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:640',
            ]);
    
            $fileName = '';
            $image = $request->file('product_image');
            $name = 'art'.$request->curid.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $fileName = '/images/'.$name;
            $image->move($destinationPath, $name);

            Product::where('id', '=', $request->curid)
            ->update([
                'pname'     => $request->productName,
                'price'     => $request->productPrice,
                'typeid'    => $request->producType,
                'c1param'   => $request->productParam1,
                'c2param'   => $request->productParam2,
                'c3param'   => $request->productParam3,
                'img' => $fileName
            ]);
        }
        else
        {
            Product::where('id', '=', $request->curid)
            ->update([
                'pname'     => $request->productName,
                'price'     => $request->productPrice,
                'typeid'    => $request->producType,
                'c1param'   => $request->productParam1,
                'c2param'   => $request->productParam2,
                'c3param'   => $request->productParam3
            ]);
        }
        return redirect('/');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getdata()
    {
        $data = Product::join('types', 'products.typeid', '=', 'types.id')
        ->join('c1s', function($join){
            $join->on('products.c1param', '=', 'c1s.cid')->on('products.typeid', '=', 'c1s.typeid');
        })
        ->join('c2s', function($join){
            $join->on('products.c2param', '=', 'c2s.cid')->on('products.typeid', '=', 'c2s.typeid');
        })
        ->join('c3s', function($join){
            $join->on('products.c3param', '=', 'c3s.cid')->on('products.typeid', '=', 'c3s.typeid');
        })
        ->select([
            'products.id as id',
            'products.pname as pname',
            'products.price as price',
            'types.type',
            'c1s.param as c1param',
            'c2s.param as c2param',
            'c3s.param as c3param',
            'products.img as img'
        ]);
        return Datatables::of($data)->make(true);
    }

    public function getParams($id)
    {
        $params1 = DB::table('c1s')->select('cid','param')
            ->where('typeid', '=', $id)
            ->get();
        $params2 = DB::table('c2s')->select('cid','param')
            ->where('typeid', '=', $id)
            ->get();
        $params3 = DB::table('c3s')->select('cid','param')
            ->where('typeid', '=', $id)
            ->get();
        $params = [$params1,$params2,$params3];
        return json_encode($params);
    }

    public function insert(Request $request){

        $newproduct = new \App\Product;
        $newproduct->pname = $request->productName;
        $newproduct->price = $request->productPrice;
        $newproduct->typeid = $request->producType;
        $newproduct->c1param = $request->productParam1;
        $newproduct->c2param = $request->productParam2;
        $newproduct->c3param = $request->productParam3;

        if ($request->hasFile('product_image')) {
            $nextrec = Product::count() + 1;
            $fileName = '';
            $this->validate($request, [
                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:640',
            ]);
            $image = $request->file('product_image');
            $name = 'art'.$nextrec.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $fileName = '/images/'.$name;
            $image->move($destinationPath, $name);
            $newproduct->img = $fileName;
        }

        $newproduct->save();

        return redirect('/');
    }
}
