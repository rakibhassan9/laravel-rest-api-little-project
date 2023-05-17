<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    
    public function index(){
        
        $products = Product::all();
        // return $this->sendResponse($products->toArray(), 'Products Retrieved');
        return $this->sendResponse(ProductResource::collection($products), 'Product Retrived');

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error', $this->errors());
        }

        $product = Product::create($request->all());
        return $this->sendResponse(new ProductResource($product), 'Product Store Successfully');

    }


    public function show($id){

        $product = Product::find($id);
        if(is_null($product)){
            return $this->sendError('Product Not Found');
        }
        return $this->sendResponse(new ProductResource($product), 'Product Retrived');
    }

    public function update(Request $request, Product $product){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error', $this->errors());
        }

        $product->update($request->all());
        return $this->sendResponse(new ProductResource($product), 'Product Updated');
    }

    public function destroy(Product $product){
        $product->delete();
        return $this->sendResponse(new ProductResource($product), 'Product Deleted');
    }

}
