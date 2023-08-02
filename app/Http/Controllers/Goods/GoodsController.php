<?php

namespace App\Http\Controllers\Goods;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Goods\GoodsPlaceHistoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Goods\CreateGoodsRequest;
use App\Http\Requests\Goods\UpdateGoodsRequest;
use App\Models\Goods\Goods;
use App\Models\Goods\GoodsPlaceHistory;
use App\Repositories\Interfaces\GoodsCategoryRepositoryInterface;
use App\Repositories\Interfaces\GoodsRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    protected GoodsRepositoryInterface $goodsRepository;
    protected GoodsCategoryRepositoryInterface $goodsCategoryRepository;
    protected PlaceRepositoryInterface $placeRepository;

    public function __construct(GoodsRepositoryInterface $goodsRepository, GoodsCategoryRepositoryInterface $goodsCategoryRepository, PlaceRepositoryInterface $placeRepository)
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsCategoryRepository = $goodsCategoryRepository;
        $this->placeRepository = $placeRepository;
    }

    public function index()
    {
        $categories = $this->goodsCategoryRepository->getAll();
        return view('goods.goods')->with(['categories' => $categories]);
    }

    public function create()
    {
        $categories = $this->goodsCategoryRepository->getAll();
        $places = $this->placeRepository->getAll();
        return view('goods.good')->with(['categories' => $categories, 'places' => $places]);
    }

    public function store(CreateGoodsRequest $request)
    {
        try {
            $data = $request->validated();
            $data[GoodsContract::FIELD_MORE_THAN_ONE] = (isset($data[GoodsContract::FIELD_MORE_THAN_ONE]) && !empty($data[GoodsContract::FIELD_MORE_THAN_ONE])) ? 1 : null;
            $data[GoodsContract::FIELD_ENTER_READINGS] = (isset($data[GoodsContract::FIELD_ENTER_READINGS]) && !empty($data[GoodsContract::FIELD_ENTER_READINGS])) ? 1 : null;
            $goods = Goods::create($data);
            return redirect()->to(route('admin.goods.edit', ['id' => $goods->{ GoodsContract::FIELD_ID }]))->with('message', 'Товар успешно добавлен!');
        } catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }

    public function edit($id)
    {
        $goods = Goods::findOrFail($id);
        $categories = $this->goodsCategoryRepository->getAll();
        $places = $this->placeRepository->getAll();
        $history = GoodsPlaceHistory::where(GoodsPlaceHistoryContract::FIELD_GOODS_ID, '=', $id)->get();
        return view('goods.good')->with(['goods' => $goods, 'categories' => $categories, 'places' => $places, 'history' => $history]);
    }

    public function update(UpdateGoodsRequest $request, $id)
    {
        try {
            $goods = Goods::findOrFail($id);
            $addHistory = false;
            $data = $request->validated();
            if($data[GoodsContract::FIELD_PLACE_ID] != $goods->{ GoodsContract::FIELD_PLACE_ID })
                $addHistory = true;
            $data[GoodsContract::FIELD_MORE_THAN_ONE] = (isset($data[GoodsContract::FIELD_MORE_THAN_ONE]) && !empty($data[GoodsContract::FIELD_MORE_THAN_ONE])) ? 1 : null;
            $data[GoodsContract::FIELD_ENTER_READINGS] = (isset($data[GoodsContract::FIELD_ENTER_READINGS]) && !empty($data[GoodsContract::FIELD_ENTER_READINGS])) ? 1 : null;
            $goods->update($data);
            if($addHistory)
                $goods->addHistory();
            return redirect()->to(route('admin.goods.edit', ['id' => $goods->{ GoodsContract::FIELD_ID }]))->with('message', 'Товар успешно изменен!');
        }catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }
}
