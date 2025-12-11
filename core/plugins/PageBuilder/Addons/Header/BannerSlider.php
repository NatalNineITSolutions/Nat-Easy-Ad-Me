<?php

namespace plugins\PageBuilder\Addons\Header;

use plugins\PageBuilder\Fields\ColorPicker;
use plugins\PageBuilder\Fields\Repeater;
use plugins\PageBuilder\Fields\Slider;
use plugins\PageBuilder\Fields\Slide;
use plugins\PageBuilder\Fields\Text;
use plugins\PageBuilder\Helpers\RepeaterField;
use plugins\PageBuilder\PageBuilderBase;
use plugins\PageBuilder\Traits\LanguageFallbackForPageBuilder;

class BannerSlider extends PageBuilderBase
{
    use LanguageFallbackForPageBuilder;

    public function preview_image()
    {
        return 'header/02.jpg';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= Text::get([
            'name' => 'title',
            'label' => __('Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'subtitle',
            'label' => __('Subtitle'),
            'value' => $widget_saved_values['subtitle'] ?? null,
        ]);

        $output .= ColorPicker::get([
            'name' => 'header_background_color',
            'label' => __('Background Color'),
            'value' => $widget_saved_values['header_background_color'] ?? null,
        ]);

        $output .= Repeater::get([
            'settings' => $widget_saved_values,
            'id' => 'background_slider',
            'fields' => [
                [
                    'type' => RepeaterField::IMAGE,
                    'name' => 'background_images',
                    'label' => __('Background Slider Images'),
                    'dimensions' => '1920x1080'
                ],
            ],
            'title_field' => __('Background Slider Images')
        ]);

        // Slider settings
        $output .= Slide::get([
            'name' => 'slider_speed',
            'label' => __('Slider Speed (ms)'),
            'value' => $widget_saved_values['slider_speed'] ?? 5000,
            'min' => 1000,
            'max' => 30000,
            'step' => 500,
        ]);

        $output .= Slider::get([
            'name' => 'padding_top',
            'label' => __('Padding Top'),
            'value' => $widget_saved_values['padding_top'] ?? 260,
            'max' => 500,
        ]);

        $output .= Slider::get([
            'name' => 'padding_bottom',
            'label' => __('Padding Bottom'),
            'value' => $widget_saved_values['padding_bottom'] ?? 190,
            'max' => 500,
        ]);

        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render(): string
    {
        $settings = $this->get_settings();

        $padding_top = $settings['padding_top'] ?? '100';
        $padding_bottom = $settings['padding_bottom'] ?? '100';
        $title = $settings['title'] ?? '';
        $subtitle = $settings['subtitle'] ?? '';
        $header_background_color = $settings['header_background_color'] ?? '';
        $background_slider = $settings['background_slider'] ?? [];
        $slider_speed = $settings['slider_speed'] ?? 5000;

        return $this->renderBlade('headers.banner-slider', [
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'title' => $title,
            'subtitle' => $subtitle,
            'header_background_color' => $header_background_color,
            'background_slider' => $background_slider,
            'slider_speed' => $slider_speed,
        ]);
    }

    public function addon_title()
    {
        return __('Header: 02 (Slider Background)');
    }
}