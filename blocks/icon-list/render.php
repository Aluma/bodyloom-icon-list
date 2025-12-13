<?php
/**
 * Render callback for the Bodyloom Dynamic Icon List block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block content.
 * @var WP_Block $block      Block instance.
 */

use Bodyloom\DynamicIconList\Provider_Factory;
use Bodyloom\DynamicIconList\Renderer;

if (!defined('ABSPATH')) {
    exit;
}

// Map block style attributes to plugin settings format if needed
$bodyloom_settings = $attributes;

// Ensure defaults
$bodyloom_settings['data_type'] = isset($bodyloom_settings['data_type']) ? $bodyloom_settings['data_type'] : 'static';

// Get items from provider
$bodyloom_provider = Provider_Factory::get_provider($bodyloom_settings);
$bodyloom_items = $bodyloom_provider->get_items($bodyloom_settings);

// Render
echo wp_kses_post(Renderer::render($bodyloom_settings, $bodyloom_items));

