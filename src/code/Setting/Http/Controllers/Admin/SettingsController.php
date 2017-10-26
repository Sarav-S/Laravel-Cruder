<?php

namespace Code\Setting\Http\Controllers\Admin;

use Code\Core\Http\Controllers\AdminCoreController;
use Code\Core\Http\Controllers\Controller;
use Code\Setting\Repository\SettingRepository;

class SettingsController extends Controller {

    public function __construct(SettingRepository $repository) {

        $this->repository = $repository;
    }
    
    /**
     * Gets the settings form page
     *
     * @return \Illuminate\View\View
     */
    public function getSettings() {

        $settings = $this->repository->all();

        $settings = collect($settings)->sortBy('heading')->groupBy('heading');

        return view('admin.settings.form', compact('settings'));
    }

    /**
     * Processes the settings form request
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function postSettings()  {

        $this->validate(request(), $this->buildRules());

        $this->repository->save(request());

        return back();
    }

   

    /**
     * Builds rules for validation
     *
     * @return  array  The rules.
     */
    private function buildRules() :array {

        $settings = $this->repository->all();

        return collect($settings)->filter(function($value) {
            return $value->required;
        })->mapWithKeys(function($value) {
            if (in_array($value->slug, ['logo', 'favicon'])) {
                return [$value->slug => 'image'];
            }
            return [$value->slug => 'required'];
        })->toArray();
    }
}
