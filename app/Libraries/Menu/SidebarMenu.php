<?php

namespace App\Libraries\Menu;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class SidebarMenu
{
    public static function generate($config = null)
    {
        $items = config('menu');

        $elements = '';

        foreach ($items as $item) {
            $elements .= static::createMenuItem($item);
        }

        return '<ul class="sidebar-menu">' .$elements. '</ul>';
    }

    public static function createMenuItem(array $item)
    {
        if (isset($item['header'])) {
            if (static::notHavePermission($item) || static::userHasPermission($item)) {
                return '<li class="menu-header">' .$item['header']. '</li>';
            } else {
                return null;
            }
        }

        if (!isset($item['children']) || is_null($item['children']) || count($item['children']) < 1) {
            if (static::havePermission($item) && !static::userHasPermission($item)) {
                return null;
            }

            $isActive = (Route::getCurrentRoute()->uri == $item['link']) ? "class='active'" : null;
            $menuItem = '<li '.$isActive.'><a class="nav-link" href="' .url($item['link']). '">';
            $menuItem .= isset($item['icon']) ? '<i class="' .$item['icon']. '"></i> ' : '';
            $menuItem .= '<span>' .$item['label']. '</span></a></li>';

            return $menuItem;
        }

        if (static::notHavePermission($item) || (static::havePermission($item) && static::userHasPermission($item))) {
            $menuItem = '<li class="dropdown">';
            $menuItem .= '<a href="' .url($item['link']). '" class="nav-link has-dropdown"><i class="' .$item['icon']. '"></i> <span>' .$item['label']. '</span></a>';
            $menuItem .= '<ul class="dropdown-menu">';

            foreach ($item['children'] as $child) {
                $menuItem .= static::createMenuItem($child);
            }

            $menuItem .= '</ul>';
            $menuItem .= '</li>';

            return $menuItem;
        }
    }

    public static function havePermission($item)
    {
        return isset($item['permission']) && !is_null($item['permission']);
    }

    public static function notHavePermission($item)
    {
        return !isset($item['permission']) || is_null($item['permission']);
    }

    public static function userHasPermission($item)
    {
        return is_array($item['permission']) && auth()->user()->hasAnyRole($item['permission']);
    }
}
