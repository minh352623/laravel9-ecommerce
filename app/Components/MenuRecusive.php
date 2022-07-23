<?php

namespace App\Components;

use App\Models\Menu;

class MenuRecusive
{
    private $html;

    public function __construct()
    {

        $this->html = '';
    }

    public function menuRecusiveAdd($idSelected, $parent_id = 0, $subMark = '')
    {
        $data = Menu::where('parent_id', $parent_id)->get();
        if ($data->count() > 0) {
            foreach ($data as $dataItem) {
                if (!empty($idSelected) && $dataItem->id == $idSelected) {
                    $this->html .= '<option selected value="' . $dataItem->id . '" >' . $subMark . $dataItem->name . '</option>';
                } else {

                    $this->html .= '<option value="' . $dataItem->id . '" >' . $subMark . $dataItem->name . '</option>';
                }
                $this->menuRecusiveAdd($idSelected, $dataItem->id, $subMark . '--');
            }
        }
        return $this->html;
    }
}
