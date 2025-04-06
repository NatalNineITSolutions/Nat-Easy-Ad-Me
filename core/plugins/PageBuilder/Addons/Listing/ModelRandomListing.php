<?php

namespace plugins\PageBuilder\Addons\Listing;

use App\Models\Backend\Listing;
use plugins\PageBuilder\Fields\ColorPicker;
use plugins\PageBuilder\Fields\Number;
use plugins\PageBuilder\PageBuilderBase;
use plugins\PageBuilder\Traits\LanguageFallbackForPageBuilder;

class ModelRandomListing extends PageBuilderBase
{
    use LanguageFallbackForPageBuilder;

    public function preview_image()
    {
        return 'listings/modal-ad.jpg'; // Update preview image
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        // Simplified admin fields for modal
        $output .= Number::get([
            'name' => 'delay_seconds',
            'label' => __('Close Button Delay'),
            'value' => $widget_saved_values['delay_seconds'] ?? 5,
            'info' => __('Seconds before close button appears'),
        ]);

        $output .= Number::get([
            'name' => 'max_ads',
            'label' => __('Max Ads Pool'),
            'value' => $widget_saved_values['max_ads'] ?? 10,
            'info' => __('Maximum ads to select randomly from'),
        ]);

        $output .= Number::get([
            'name' => 'show_every_visits',
            'label' => __('Show Frequency'),
            'value' => $widget_saved_values['show_every_visits'] ?? 1,
            'info' => __('Number of visits between modal appearances (0 = show only once)'),
        ]);

        $output .= ColorPicker::get([
            'name' => 'overlay_color',
            'label' => __('Overlay Color'),
            'value' => $widget_saved_values['overlay_color'] ?? 'rgba(0,0,0,0.8)',
        ]);

        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render(): string
    {
        $settings = $this->get_settings();
        $delay = $settings['delay_seconds'] ?? 5;
        $maxAds = $settings['max_ads'] ?? 10;
        $showEvery = $settings['show_every_visits'] ?? 1;

        // Get random active listing
        $randomAd = Listing::where('status', 1)
            ->where('is_published', 1)
            ->inRandomOrder()
            ->take($maxAds)
            ->get()
            ->random(min($maxAds, 1)); // Ensure at least 1

        return $this->renderBlade('listing.modal-ad', [
            'delay' => $delay * 1000, // Convert to milliseconds
            'random_ad' => $randomAd,
            'show_every_visits' => $showEvery,
            'overlay_color' => $settings['overlay_color'] ?? 'rgba(0,0,0,0.8)'
        ]);
    }

    public function addon_title()
    {
        return __('Modal Ad Display');
    }
}