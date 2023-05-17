<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;

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
        if($this->$validator->fails()){
            return $this->sendError('Validation Error', $this->errors());
        }

        $product = Product::create($request->all());
        return $this->sendResponse(new ProductResource($product), 'Product Store Successfully');

    }

}
