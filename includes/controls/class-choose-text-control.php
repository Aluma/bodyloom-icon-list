<?php
namespace Bodyloom\DynamicIconList\Controls;

use Elementor\Base_Data_Control;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Choose_Text_Control extends Base_Data_Control
{

    public function get_type()
    {
        return 'choose_text';
    }

    protected function get_default_settings()
    {
        return [
            'options' => [],
            'toggle' => true,
        ];
    }

    public function content_template()
    {
        ?>
        <div class="elementor-control-field">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <div class="elementor-choices">
                    <# _.each( data.options, function( option, value ) { #>
                        <input id="<?php echo esc_attr($this->get_control_uid('{{ value }}')); ?>" type="radio"
                            name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}"
                            data-setting="{{ data.name }}" <# if ( value===data.controlValue ) { #>checked<# } #>>
                            <label class="elementor-choices-label elementor-control-unit-1"
                                for="<?php echo esc_attr($this->get_control_uid('{{ value }}')); ?>" title="{{ option.title }}">
                                {{{ option.title }}}
                            </label>
                            <# } ); #>
                </div>
            </div>
        </div>
        <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>
                <?php
    }

    public function enqueue()
    {
        // Enqueue styles to make it look like standard buttons
        wp_register_style('bodyloom-choose-text-control', false);
        wp_enqueue_style('bodyloom-choose-text-control');
        $css = "
            .elementor-control-type-choose_text .elementor-choices {
                display: flex;
                flex-wrap: wrap;
            }
            .elementor-control-type-choose_text .elementor-choices label.elementor-choices-label {
                width: auto;
                padding: 0 10px;
                font-size: 11px;
                text-transform: uppercase;
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 60px;
                font-weight: 500;
            }
            .elementor-control-type-choose_text .elementor-choices input:checked + label.elementor-choices-label {
                background-color: #556068;
                color: #fff;
            }
        ";
        wp_add_inline_style('bodyloom-choose-text-control', $css);
    }
}
