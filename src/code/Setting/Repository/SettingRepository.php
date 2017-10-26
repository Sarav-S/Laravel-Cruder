<?php 

namespace Code\Setting\Repository;

use Code\Core\Repository\BaseRepository;
use Code\Setting\Model\Setting;

class SettingRepository extends BaseRepository
{

	public function assignModel()
	{
		return Setting::class;
	}

    public function setFallBack()
    {
        return route('admin.settings.get');
    }

     public function module()
    {
        return "Settings";
    }

	/**
     * Saves settings.
     * 
     * @return null
     */
    public function save($request = null) {

        collect($request->except(['_token', '_method', 'logo', 'favicon']))
            ->each(function($value, $key) {
                $setting = Setting::where('slug', $key)->first();
                ($setting) ? $this->updateSetting($setting, ($value ?? '')) : null;
            });

        collect(array_filter($request->only('logo', 'favicon')))
            ->each(function($value, $key) {
                $setting = Setting::where('slug', $key)->first();
                if ($setting) {
                    $setting->value = $request->file($key)->store('uploads/settings/'.$setting->id);
                    $setting->save();
                }
            });

        
        success('Settings has been updated successfully');

        return redirect($this->getFallBack());
    }

    /**
     * Updates individual setting.
     * 
     * @param Setting $setting
     * @param string  $value
     * @return null
     */
    public function updateSetting(Setting $setting, string $value) {
        $setting->value = $value;
        $setting->save();
    }
}