<?php

namespace Bodyloom\DynamicIconList\Providers;

use Bodyloom\DynamicIconList\Interfaces\Provider;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Acf_Provider implements Provider
{

    public function get_items($settings)
    {
        if (!function_exists('get_field')) {
            return [];
        }

        $repeater_name = isset($settings['acf_repeater_field_name']) ? $settings['acf_repeater_field_name'] : '';

        if (empty($repeater_name)) {
            return [];
        }

        // Handle nested repeaters (e.g., 'parent/child')
        // For simplicity, let's assume direct field access first or standard ACF get_field which can handle some paths if we do it right,
        // but typically get_field('repeater') returns the array.
        // If the user provided 'parent/child', we might need to explode. 
        // Original code description said: "For nested fields, use a slash"

        $keys = explode('/', $repeater_name);
        $rows = [];

        $current_obj = get_queried_object();
        $post_id = get_the_ID();
        // If we are on an archive or special page, this might need adjustment, typically get_the_ID() is safe for single posts.

        if (count($keys) > 1) {
            // Nested Logic
            $parent = get_field($keys[0]);
            if (is_array($parent)) {
                // Traverse down
                $temp = $parent;
                for ($i = 1; $i < count($keys); $i++) {
                    if (isset($temp[$keys[$i]])) {
                        $temp = $temp[$keys[$i]];
                    } else {
                        // Attempt to find if it's inside a loop or we just take the first one?
                        // Nested repeaters are tricky without context of WHICH parent row we are in.
                        // Usually, generic widgets on a page pull from the page's meta.
                        // If it's a nested repeater, it might expect to return THE array.
                        $temp = [];
                        break;
                    }
                }
                $rows = is_array($temp) ? $temp : [];
            }
        } else {
            $rows = get_field($repeater_name);
        }

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
                // ACF Link Field Type
                $link['url'] = $link_raw['url'];
                $link['is_external'] = isset($link_raw['target']) && '_blank' === $link_raw['target'] ? 'on' : '';
                $link['nofollow'] = ''; // ACF doesn't usually have this unless custom
            } elseif (is_string($link_raw)) {
                $link['url'] = $link_raw;
            }

            $items[] = [
                '_id' => uniqid(), // Elementor needs IDs sometimes
                'text' => $text,
                'value' => $value,
                'link' => $link,
                'icon_type' => 'global', // Dynamic items usually use the global icon unless we add an icon subfield
                'icon' => [], // Could add dynamic icon support later
                'text_nowrap' => '',
            ];
        }

        return $items;
    }
}
