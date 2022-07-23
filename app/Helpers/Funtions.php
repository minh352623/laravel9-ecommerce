<?php

function isRole($dataArr, $moduleName, $role = 'view')
{
    if (!empty($dataArr[$moduleName])) {
        $roleArr = $dataArr[$moduleName];
        if (!empty($roleArr) && in_array($role, $roleArr)) {
            return true;
        }
    }
    return false;
}


function getSetting($config_key)
{
    $setting = App\Models\Settings::where('config_key', $config_key)->first();
    if (!empty($setting)) {

        return $setting->config_value;
    }
    return null;
}


function getMenu()
{
    return App\Models\Menu::all();
}
