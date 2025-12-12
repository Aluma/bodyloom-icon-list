<?php

namespace Bodyloom\DynamicIconList;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Plugin
{

	private static $instance = null;

	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct()
	{
		add_action('init', [$this, 'init']);

		add_action('elementor/widgets/register', [$this, 'register_elementor_widgets']);

		add_action('elementor/controls/register', [$this, 'register_controls']);
	}

	public function init()
	{
		// Register Style
		wp_register_style(
			'bodyloom-dynamic-icon-list',
			BODYLOOM_DYNAMIC_ICON_LIST_URL . 'assets/css/bodyloom-dynamic-icon-list.css',
			[],
			BODYLOOM_DYNAMIC_ICON_LIST_VERSION
		);

		// Register Shortcode
		add_shortcode('bodyloom_icon_list', [new Shortcode(), 'render']);

		// Register Block
		register_block_type(BODYLOOM_DYNAMIC_ICON_LIST_PATH . 'blocks/icon-list');
	}

	public function register_controls($controls_manager)
	{
		require_once BODYLOOM_DYNAMIC_ICON_LIST_PATH . 'includes/controls/class-choose-text-control.php';
		$controls_manager->register(new \Bodyloom\DynamicIconList\Controls\Choose_Text_Control());
	}

	public function register_elementor_widgets($widgets_manager)
	{
		$widget_file = BODYLOOM_DYNAMIC_ICON_LIST_PATH . 'widgets/elementor/class-icon-list-widget.php';
		if (file_exists($widget_file)) {
			require_once $widget_file;
			$widgets_manager->register(new \Bodyloom\DynamicIconList\Widgets\Elementor\Icon_List_Widget());
		}
	}
}
