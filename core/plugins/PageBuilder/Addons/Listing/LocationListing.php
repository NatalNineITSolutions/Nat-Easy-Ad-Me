<?php

namespace plugins\PageBuilder\Addons\Listing;

use App\Models\Backend\Listing;
use plugins\PageBuilder\Fields\ColorPicker;
use plugins\PageBuilder\Fields\Number;
use plugins\PageBuilder\Fields\Slide;
use plugins\PageBuilder\Fields\Slider;
use plugins\PageBuilder\Fields\Text;
use plugins\PageBuilder\Traits\LanguageFallbackForPageBuilder;
use plugins\PageBuilder\PageBuilderBase;

class LocationListing extends PageBuilderBase
{
    use LanguageFallbackForPageBuilder;

    public function preview_image()
    {
        return 'listings/google-location-listing.jpg';
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
            'name' => 'explore_all',
            'label' => __('Explore Text'),
            'value' => $widget_saved_values['explore_all'] ?? null,
        ]);

        $output .= Number::get([
            'name' => 'items',
            'label' => __('Items'),
            'value' => $widget_saved_values['items'] ?? null,
            'info' => __('Enter how many items you want to show in the frontend'),
        ]);

        $output .= Slide::get([
            'name' => 'distance',
            'label' => __('Default Distance (in km)'),
            'value' => $widget_saved_values['distance'] ?? 50,
            'min' => 1,
            'max' => 100,
            'info' => __('Set the default distance for filtering listings'),
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

        $output .= ColorPicker::get([
            'name' => 'section_bg',
            'label' => __('Background Color'),
            'value' => $widget_saved_values['section_bg'] ?? null,
            'info' => __('Select the background color for the section'),
        ]);

        $output .= ColorPicker::get([
            'name' => 'btn_color',
            'label' => __('Button Background Color'),
            'value' => $widget_saved_values['btn_color'] ?? null,
            'info' => __('Select the button background color'),
        ]);

        $output .= ColorPicker::get([
            'name' => 'button_text_color',
            'label' => __('Button Text Color'),
            'value' => $widget_saved_values['button_text_color'] ?? null,
            'info' => __('Select the button text color'),
        ]);

        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render(): string
    {
        $settings = $this->get_settings();
        $items = $settings['items'] ?? 6;
        $distance = $settings['distance'] ?? 50;
        $padding_top = $settings['padding_top'] ?? 260;
        $padding_bottom = $settings['padding_bottom'] ?? 190;

        $location = request()->get('location', 'Coimbatore');

        $latitude = session('latitude');
        $longitude = session('longitude');

        $listings = Listing::where('status', 1)
            ->where('is_published', 1);

        if ($latitude && $longitude) {
            $listings = $listings->selectRaw(
                "*, (6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lon) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance",
                [$latitude, $longitude, $latitude]
            )
                ->havingRaw('distance <= ?', [$distance])
                ->orderBy('distance', 'asc');
        } else {
            $listings = $listings->where('location', 'like', '%' . $location . '%');
        }

        $listings = $listings->take($items)->get();

        return $this->renderBlade('listing.location-wise-listing', [
            'padding_top'        => $padding_top,
            'padding_bottom'     => $padding_bottom,
            'section_bg'         => $settings['section_bg'] ?? '',
            'section_title'      => $settings['title'] ?? '',
            'explore_text'       => $settings['explore_all'] ?? '',
            'listings'           => $listings,
            'btn_color'          => $settings['btn_color'] ?? '',
            'button_text_color'  => $settings['button_text_color'] ?? '',
            'location'           => $location,
            'distance'           => $distance,
            'latitude'           => $latitude,
            'longitude'          => $longitude,
        ]);
    }


    public function addon_title()
    {
        return __('Location Listing');
    }
}
