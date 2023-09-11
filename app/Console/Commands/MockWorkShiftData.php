<?php

namespace App\Console\Commands;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\WorkShift\{WorkShiftEmployeeContract, WorkShiftContract, WorkShiftGoodsContract};
use App\Contracts\UserContract;
use App\Models\Goods\Goods;
use App\Models\Structure\Place;
use App\Models\WorkShift\{WorkShift, WorkShiftEmployee, WorkShiftGood};
use App\Repositories\Interfaces\{WorkShiftEmployeeRepositoryInterface, WorkShiftGoodsRepositoryInterface, UserRepositoryInterface};
use Illuminate\Console\Command;

class MockWorkShiftData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mock-work-shift-data {workShiftID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mock WorkShift Data. For testing purposes only!';

    protected WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository;
    protected WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository,
        WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct();
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
        $this->workShiftEmployeeRepository = $workShiftEmployeeRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $workShiftID = $this->argument('workShiftID');
        $workShift = WorkShift::find($workShiftID);
        $this->handleEmployees($workShift);
        $this->handleGoods($workShift);
    }

    public function handleEmployees($workShift) {
        $this->workShiftEmployees = $this->workShiftEmployeeRepository->getAll($workShift->{WorkShiftContract::FIELD_ID});
        if ($this->workShiftEmployees->count() === 0) {
            $users = $this->userRepository->getByCity($workShift->{WorkShiftContract::FIELD_CITY_ID});
            foreach ($users as $user) {
                $data = [
                    WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                    WorkShiftEmployeeContract::FIELD_USER_ID => $user->{UserContract::FIELD_ID},
                    WorkShiftEmployeeContract::FIELD_STATUS => 2,
                    WorkShiftEmployeeContract::FIELD_POSITION_ID => 2,
                    WorkShiftEmployeeContract::FIELD_START_TIME => '10:00',
                ];
                WorkShiftEmployee::create($data);
            }
        }
    }

    public function handleGoods(WorkShift $workShift) {
        $goodsTypes = GoodsContract::TYPE_LIST;
        foreach ($goodsTypes as $typeID => $typeName) {
            $goods = Goods::where(GoodsContract::FIELD_TYPE, $typeID)->get();
            if ($goods->count() === 0) {
                if ($typeID === 3) {
                    $places = Place::all();
                    foreach ($places as $place) {
                        $data = [
                            GoodsContract::FIELD_NAME => "ТМЦ №$i",
                            GoodsContract::FIELD_CATEGORY_ID => 1,
                            GoodsContract::FIELD_TYPE => $typeID,
                            GoodsContract::FIELD_PRIZE_AMOUNT => rand(100, 999),
                            GoodsContract::FIELD_PLACE_ID => $place->{PlaceContract::FIELD_ID},
                            GoodsContract::FIELD_ENTER_READINGS => true,
                            GoodsContract::FIELD_SERIAL_NUMBER => rand(10*6, 10*7),
                        ];
                        Goods::create($data);
                    }
                } else {
                    for ($i = 1; $i < 10; $i++) {
                        $data = [
                            GoodsContract::FIELD_NAME => "Товар №$i ($typeName)",
                            GoodsContract::FIELD_CATEGORY_ID => 1,
                            GoodsContract::FIELD_TYPE => $typeID,
                            GoodsContract::FIELD_PRIZE_AMOUNT => rand(100, 999),
                        ];
                        Goods::create($data);
                    }
                }
            }
        }

        if ($this->workShiftGoodsRepository->getAll($workShift->{WorkShiftContract::FIELD_ID}, 1)->count() === 0) {
            $generalSalesGoods = Goods::where(GoodsContract::FIELD_TYPE, 1)->get();
            foreach ($generalSalesGoods as $good) {
                $data = [
                    WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                    WorkShiftGoodsContract::FIELD_GOOD_ID => $good->{GoodsContract::FIELD_ID},
                    WorkShiftGoodsContract::FIELD_QTY => rand(10, 99),
                    WorkShiftGoodsContract::FIELD_PRICE => max($good->{GoodsContract::FIELD_PRIZE_AMOUNT} * 10, 100),
                ];
                WorkShiftGood::create($data);
            }
        }

        if ($this->workShiftGoodsRepository->getAll($workShift->{WorkShiftContract::FIELD_ID}, 2)->count() === 0) {
            $individualSalesGoods = Goods::where(GoodsContract::FIELD_TYPE, 2)->get();
            foreach ($individualSalesGoods as $good) {
                foreach ($this->workShiftEmployees as $employee) {
                    $data = [
                        WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                        WorkShiftGoodsContract::FIELD_GOOD_ID => $good->{GoodsContract::FIELD_ID},
                        WorkShiftGoodsContract::FIELD_QTY => rand(10, 99),
                        WorkShiftGoodsContract::FIELD_PRICE => max($good->{GoodsContract::FIELD_PRIZE_AMOUNT} * 10, 100),
                        WorkShiftGoodsContract::FIELD_EMPLOYEE_ID => $employee->{UserContract::FIELD_ID},
                    ];
                    WorkShiftGood::create($data);
                }
            }
        }
    }
}
