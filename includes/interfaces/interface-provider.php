<?php

namespace Bodyloom\DynamicIconList\Interfaces;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

interface Provider
{
    /**
     * Get items from the provider.
     *
     * @param array $settings Widget settings.
     * @return array List of items, each containing 'text', 'value', 'link', 'icon', etc.
     */
    public function get_items($settings);
}
