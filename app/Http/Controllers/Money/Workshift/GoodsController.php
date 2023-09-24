<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\GoodsRepositoryInterface;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    protected GoodsRepositoryInterface $goodsRepository;

    public function __construct(GoodsRepositoryInterface $goodsRepository) {
        $this->goodsRepository = $goodsRepository;
    }

    public function index(Request $request) {
        $request->validate([
            'type' => 'required|numeric',
        ]);

        $goods = $this->goodsRepository->getByType($request->get('type'));

        return response()->json($goods);
    }
}
