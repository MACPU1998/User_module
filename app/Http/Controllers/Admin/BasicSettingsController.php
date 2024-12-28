<?php

namespace App\Http\Controllers\Admin;

use App\DataTableBuilders\SettingsDataTableBuilder;
use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\MainSettingsRequest;
use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BasicSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SettingsDataTableBuilder $settingsDataTableBuilder)
    {
        $settingsDataTableBuilder->query()->where("show_in_list",true);
        return view("admin.settings.basic_settings.index",compact("settingsDataTableBuilder"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function mainSettings()
    {
        $mainSetting = [
            "program_title" => getSetting('program_title'),
            "phone" => getSetting('phone'),
            "email" => getSetting('email'),
            "rules" => getSetting('rules_content'),
        ];
        return view("admin.settings.main_settings.edit",compact("mainSetting"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateMainSettings(MainSettingsRequest $request)
    {
        $settingsData = $request->validated();
        updateSettings($settingsData);
        Cache::forget('settings_results');
        return redirect(route("admin.settings.main_settings.index"))->with("message",__("message.update_successfull"));
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
        $basic_setting = Setting::find($id);
        return view("admin.settings.basic_settings.edit",compact("basic_setting"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $basic_setting = Setting::find($id);
            $basic_setting->value = $request->value;
            $basic_setting->save();
            return redirect(route("admin.settings.basic_settings.index"))->with("message",__("message.update_successfull"));
        } catch (\Throwable $th) {
            return back()->with("error",errorMessage($th));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
