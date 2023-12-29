<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Structure\CreatePlaceCalcRequest;
use App\Http\Requests\Structure\UpdatePlaceCalcRequest;
use App\Models\Structure\PlaceCalc;
use Illuminate\Http\Request;

class PlaceCalcController extends Controller
{
    public function store(CreatePlaceCalcRequest $request)
    {
        try {
            PlaceCalc::create($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function update(UpdatePlaceCalcRequest $request, $id)
    {
        try {
            PlaceCalc::findOrFail($id)->update($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function destroy($id)
    {
        try {
            $place = PlaceCalc::findOrFail($id);
            $place->delete();
            return back()->with('message', 'Начисление удалено!');
        } catch (\Exception $e) {
            return back()->withErrors(['errors' => [
                'error' => $e->getMessage()
            ]]);
        }
    }
}
