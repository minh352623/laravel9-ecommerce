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


function getStatusBill($status)
{
    $message = '';
    switch ($status) {
        case 0:
            $message = 'Waiting';
            break;
        case 1:
            $message = 'Delivery';
            break;
        case 2:
            $message = 'Delivered';
            break;
        default:
            $message = "Error";
            break;
    }

    return $message;
}
function getStatusBillVn($status)
{
    $message = '';
    switch ($status) {
        case 0:
            $message = 'Đang chờ duyệt';
            break;
        case 1:
            $message = 'Đang giao';
            break;
        case 2:
            $message = 'Đã giao';
            break;
        default:
            $message = "Lỗi";
            break;
    }

    return $message;
}

function getStatusContact($status)
{
    $message = '';
    switch ($status) {
        case 0:
            $message = 'Chưa duyệt';
            break;
        case 1:
            $message = 'Đã duyệt';
            break;

        default:
            $message = "Error";
            break;
    }

    return $message;
}
