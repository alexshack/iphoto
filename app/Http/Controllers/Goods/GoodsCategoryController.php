<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use App\Http\Requests\Goods\CreateGoodsCategoryRequest;
use App\Models\Goods\GoodsCategory;
use Illuminate\Http\Request;

class GoodsCategoryController extends Controller
{
    public function store(CreateGoodsCategoryRequest $request)
    {
        try {
            GoodsCategory::insert($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }
}
