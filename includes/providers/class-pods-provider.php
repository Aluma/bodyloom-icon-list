<?php

namespace Bodyloom\DynamicIconList\Providers;

use Bodyloom\DynamicIconList\Interfaces\Provider;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Pods_Provider implements Provider
{

    public function get_items($settings)
    {
        if (!function_exists('pods')) {
            return [];
        }

        $repeater_name = isset($settings['acf_repeater_field_name']) ? $settings['acf_repeater_field_name'] : ''; // Reusing the control name for simplicity

        if (empty($repeater_name)) {
            return [];
        }

        $pod = pods(get_post_type(), get_the_ID());

        if (!$pod || !$pod->exists()) {
            return [];
        }

        $rows = $pod->field($repeater_name);

        if (!$rows || !is_array($rows)) {
            return [];
        }

        $items = [];
        $text_key = isset($settings['dynamic_text_sub_field']) ? $settings['dynamic_text_sub_field'] : 'text';
        $value_key = isset($settings['dynamic_value_sub_field']) ? $settings['dynamic_value_sub_field'] : 'value';
        $link_key = isset($settings['dynamic_link_sub_field']) ? $settings['dynamic_link_sub_field'] : 'link';

        foreach ($rows as $row) {
            $text = isset($row[$text_key]) ? $row[$text_key] : '';
            $value = isset($row[$value_key]) ? $row[$value_key] : '';
            $link_raw = isset($row[$link_key]) ? $row[$link_key] : '';

            // Normalize Link
            $link = [
                'url' => '',
                'is_external' => '',
                'nofollow' => '',
                'custom_attributes' => '',
            ];

            if (is_array($link_raw) && isset($link_raw['url'])) {
                $link['url'] = $link_raw['url'];
            } elseif (is_string($link_raw)) {
                $link['url'] = $link_raw;
            }

            $items[] = [
                '_id' => uniqid(),
                'text' => $text,
                'value' => $value,
                'link' => $link,
                'icon_type' => 'global',
                'icon' => [],
                'text_nowrap' => '',
            ];
        }

        return $items;
    }
}
