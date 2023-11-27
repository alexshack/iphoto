<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use App\Http\Requests\Goods\CreateGoodsCategoryRequest;
use App\Models\Goods\GoodsCategory;
use App\Repositories\GoodsCategoryRepository;
use Illuminate\Http\Request;

class GoodsCategoryController extends Controller
{
    protected GoodsCategoryRepository $goodsCategoryRepository;

    public function __construct(GoodsCategoryRepository $goodsCategoryRepository)
    {
        $this->goodsCategoryRepository = $goodsCategoryRepository;
    }

    public function index(Request $request)
    {
        return view('goods.categories.index');
    }

    public function create()
    {
        return view('goods.categories.create');
    }

    public function edit(Request $request, $id)
    {
        $category = GoodsCategory::findOrFail($id);
        return view('goods.categories.edit', compact('category'));
    }

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
