<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Http\Requests\Money\CreateSalesTypeRequest;
use App\Http\Requests\Money\UpdateSalesTypeRequest;
use App\Models\Money\SalesType;
use App\Repositories\Interfaces\SalesTypeRepositoryInterface;
use Illuminate\Http\Request;

class SalesTypeController extends Controller
{
    private SalesTypeRepositoryInterface $salesTypeRepository;

    public function __construct(SalesTypeRepositoryInterface $salesTypeRepository)
    {
        $this->salesTypeRepository = $salesTypeRepository;
    }

    public function index()
    {
        $list = $this->salesTypeRepository->getAll();
        return view('money.sales-types')->with(['list' => $list]);
    }

    public function store(CreateSalesTypeRequest $request)
    {
        try {
            SalesType::create($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function update(UpdateSalesTypeRequest $request, $id)
    {
        try {
            SalesType::findOrFail($id)->update($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }
}
