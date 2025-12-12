<?php

namespace Bodyloom\DynamicIconList;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Shortcode
{

    public function __construct()
    {
        add_shortcode('bodyloom_icon_list', [$this, 'render']);
    }

    public function render($atts)
    {
        $atts = shortcode_atts([
            'data_type' => 'static',
            'title' => '',
            // Add defaults for other settings
        ], $atts, 'bodyloom_icon_list');

        // Convert simple atts to settings array structure expected by Provider/Renderer
        $settings = $atts;

        // If static, we need to parse items from attributes? 
        // Shortcodes usually have children or a strict format. 
        // For simplicity, this shortcode might be primarily for Dynamic usage or pre-defined usages.
        // If the user wants to define items in shortcode, it gets complex (JSON string?).

        wp_enqueue_style('bodyloom-dynamic-icon-list');

        $provider = Provider_Factory::get_provider($settings);
        $items = $provider->get_items($settings);

        return Renderer::render($settings, $items);
    }
}

new Shortcode();
