<?php

namespace App\Http\Livewire\Place;

use App\Contracts\Structure\PlaceContract;
use App\Models\Structure\Place;
use App\Repositories\Interfaces\GoodsRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class PlaceGoods extends Component
{
    use WithPagination;

    protected GoodsRepositoryInterface $goodsRepository;

    public Place $place;

    public function render(GoodsRepositoryInterface $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
        $goods = $this->goodsRepository->getTMCByPlaceID($this->place->{PlaceContract::FIELD_ID}, 40);
        return view('livewire.place.place-goods', compact('goods'));
    }
}
