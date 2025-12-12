<?php

namespace Bodyloom\DynamicIconList;

use Bodyloom\DynamicIconList\Interfaces\Provider;
use Bodyloom\DynamicIconList\Providers\Static_Provider;
use Bodyloom\DynamicIconList\Providers\Acf_Provider;
use Bodyloom\DynamicIconList\Providers\Pods_Provider;
use Bodyloom\DynamicIconList\Providers\Metabox_Provider;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Provider_Factory
{

    public static function get_provider($settings): Provider
    {
        $type = isset($settings['data_type']) ? $settings['data_type'] : 'static';

        // Check if a specific dynamic source is selected (if we add a control for source selection later)
        // For now, if dynamic, we might need to check which specific provider logic to use, or if 'dynamic' implies ACF by default
        // In the original file, it seemed generic, but usually there's a selector.
        // Assuming 'data_type' is 'dynamic', we need to check if there is a 'dynamic_source' control or we just try ACF.
        // In the refactored code provided, there were controls for 'acf_repeater_field_name'.

        // Let's assume for now:
        if ('static' === $type) {
            return new Static_Provider();
        }

        // If dynamic, we default to ACF for now (based on prior convo), but we should probably detect or have a setting.
        // I will add a check if we implement a 'dynamic_source' control. If not, I'll default to ACF Provider for 'dynamic'.

        // Note: The previous plugin had explicit support for multiple, so I'll add logic here:
        $source = isset($settings['dynamic_source']) ? $settings['dynamic_source'] : 'acf';

        switch ($source) {
            case 'pods':
                return new Pods_Provider();
            case 'metabox':
                return new Metabox_Provider();
            case 'acf':
            default:
                return new Acf_Provider();
        }
    }
}
