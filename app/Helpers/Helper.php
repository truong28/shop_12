<?php

namespace App\Helpers;

class Helper
{
    public static function menu($menus, $parent_id = 0, $char = ''){
        $html = '';

        foreach ($menus as $key => $menu){
            if($menu->parent_id == $parent_id){
                $html .= '
                <tr>
                <td>'.$menu->id.'</td>
                <td>'.$char.$menu->name.'</td>
                <td>'.$menu->active.'</td>
                <td>'.$menu->updated_at.'</td>
                <td>
                    <a class="btn btn-primary" href="admin/menu/edit/'.$menu->id.'">
                    <i class="fas fa-edit"></i>
                    </a>

                    <a href="#" class="btn btn-danger " 
                    onclick="removeRow('.$menu->id.',\'/admin/menu/destroy\') ">
                    <i class="fas fa-trash-alt"></i>
                    </a>
                </th>
                </tr>';

                unset($menu[$key]);

                $html .= self::menu($menus, $menu->id, $char.'--');


            }
        }
         return $html;
    }

    public static function active($active = 0): string
    {
        return $active == 0 ? '<span class="btn btn-danger btn-xs">NO</span>'
            : '<span class="btn btn-success btn-xs">YES</span>';
    }

    public static function menus($menus)
    {
        dd(1);
    }

}
