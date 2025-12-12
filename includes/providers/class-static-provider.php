<?php

namespace Bodyloom\DynamicIconList\Providers;

use Bodyloom\DynamicIconList\Interfaces\Provider;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Static_Provider implements Provider
{

    public function get_items($settings)
    {
        if (!isset($settings['icon_list']) || !is_array($settings['icon_list'])) {
            return [];
        }

        return $settings['icon_list'];
    }
}
