<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\SettingsRepositoryInterface;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected SettingsRepositoryInterface $settingsRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = $this->settingsRepository->all();
        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = $this->settingsRepository->find($id);
        if (!$setting) {
            abort(404);
        }
        return view('settings.edit', compact('setting'));
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
