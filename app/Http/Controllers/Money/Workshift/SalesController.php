<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\WorkShift\WorkShiftGoodEmployeeContract;
use App\Helpers\WorkShiftHelper;
use App\Models\WorkShift\WorkShiftGood;
use App\Models\WorkShift\WorkShiftGoodEmployee;
use App\Repositories\Interfaces\GoodsRepositoryInterface;
use App\Repositories\Interfaces\SalesTypeRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    private GoodsRepositoryInterface $goodsRepository;
    private SalesTypeRepositoryInterface $salesTypeRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;

    public function __construct(GoodsRepositoryInterface $goodsRepository,
        SalesTypeRepositoryInterface $salesTypeRepository,
        WorkShiftRepositoryInterface $workShiftRepo,
        WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
        $this->salesTypeRepository = $salesTypeRepository;
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
        $this->workShiftRepo = $workShiftRepo;
    }

    public function getSalesTypes() {
        $types = $this->salesTypeRepository->getAll();
        return response()->json($types);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $goods = $this->workShiftGoodsRepository->getAll($request->get('workshiftID'), $request->get('type'));
        return response()->json($goods);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = WorkShiftGoodsContract::RULES;
        $good = $this->goodsRepository->find($request->get('good_id'));
        if ($good && in_array($good->{GoodsContract::FIELD_TYPE}, [4, 5])) {
            unset($rules[WorkShiftGoodsContract::FIELD_PRICE]);
        }

        if ($good && $good->{GoodsContract::FIELD_TYPE} === 2) {
            $rules[WorkShiftGoodsContract::FIELD_EMPLOYEE_ID] = 'required';
        }

        $validated = $request->validate($rules, [], WorkShiftGoodsContract::ATTRIBUTES);

        $workShiftGood = WorkShiftGood::create($validated);

        if ($good->{GoodsContract::FIELD_TYPE} === 1) {
            foreach ($request->get('employees') as $employee) {
                $employeeID = null;
                if (is_array($employee)) {
                    $employeeID = $employee['id'];
                } elseif (is_numeric($employee)) {
                    $employeeID = $employee;
                }

                $data = [
                    WorkShiftGoodEmployeeContract::FIELD_EMPLOYEE_ID => $employeeID,
                    WorkShiftGoodEmployeeContract::FIELD_WORK_SHIFT_GOOD_ID => $workShiftGood->{WorkShiftGoodsContract::FIELD_ID},
                ];
                WorkShiftGoodEmployee::create($data);
            }
        }

        $workShift = $this->workShiftRepo->find($request->get('workshift_id'));

        return response()->json([
            'agenda' => WorkShiftHelper::recalculateStats($workShift),
            'data' => $good,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $good = $this->workShiftGoodsRepository->find($id);
        return response()->json($good);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(WorkShiftGoodsContract::RULES, [], WorkShiftGoodsContract::ATTRIBUTES);
        $good = $this->workShiftGoodsRepository->find($id);

        if ($good) {
            foreach ($validated as $key => $value) {
                $good->{$key} = $value;
            }
            $good->save();

            $workShift = $this->workShiftRepo->find($request->get('workshift_id'));
            return response()->json([
                'agenda' => WorkShiftHelper::recalculateStats($workShift),
                'id' => $good->id,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $good = $this->workShiftGoodsRepository->find($id);
        if ($good) {
            $good->delete();
            return response()->json([]);
        }
    }
}
