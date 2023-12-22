<?php

namespace App\Http\Controllers\Service;

use App\Repositories\Interfaces\ReportsRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected ReportsRepositoryInterface $reportsRepository;

    public function __construct(ReportsRepositoryInterface $reportsRepository)
    {
        $this->reportsRepository = $reportsRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = $this->reportsRepository->get([], 40);
        return view('service.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = $this->reportsRepository->find($id);
        return view('service.reports.single', compact('report'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
