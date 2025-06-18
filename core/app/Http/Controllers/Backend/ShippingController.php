<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use App\Models\ShippingZone;
use App\Models\DeliveryCharge;

class ShippingController extends Controller
{
    public function shippingZones()
    {
        $zones = ShippingZone::with(['country', 'state'])->get();
        return view('backend.pages.shipping.zone-index', compact('zones'));
    }

    public function addZone()
    {
        $countries = Country::all();
        return view('backend.pages.shipping.add-zone', compact('countries'));
    }

    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return response()->json($states);
    }

    public function storeZone(Request $request)
    {
        $request->validate([
            'zone_name'  => 'required|string|max:255',
            'country'    => 'required|exists:countries,id',
            'state'      => 'nullable|exists:states,id',
        ]);

        ShippingZone::create([
            'zone_name'  => $request->zone_name,
            'country_id' => $request->country,
            'state_id'   => $request->state,
        ]);

        return redirect()->route('admin.shipping.zones')->with('success', 'Shipping zone created successfully.');
    }

    public function editZone($id)
    {
        $zone = ShippingZone::findOrFail($id);
        $countries = Country::all();
        $states = State::where('country_id', $zone->country_id)->get();

        return view('backend.pages.shipping.add-zone', compact('zone', 'countries', 'states'));
    }

    public function updateZone(Request $request, $id)
    {
        $request->validate([
            'zone_name' => 'required|string|max:255',
            'country' => 'required|exists:countries,id',
            'state' => 'nullable|exists:states,id',
        ]);

        $zone = ShippingZone::findOrFail($id);
        $zone->update([
            'zone_name' => $request->zone_name,
            'country_id' => $request->country,
            'state_id' => $request->state,
        ]);

        return redirect()->route('admin.shipping.zones')->with('success', 'Zone updated successfully');
    }

    public function deleteZone($id)
    {
        $zone = ShippingZone::findOrFail($id);
        $zone->delete();

        return redirect()->route('admin.shipping.zones')->with('success', 'Zone deleted successfully');
    }


    // Delivery charges
    public function deliveryCharge()
    {
        $charges = DeliveryCharge::with('zone')->get();
        return view('backend.pages.shipping.delivery-charge', compact('charges'));
    }

    public function addDeliveryCharge()
    {
        $zones = ShippingZone::all();
        return view('backend.pages.shipping.add-delivery-charge', compact('zones'));
    }

    public function storeDeliveryCharge(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|exists:shipping_zones,id',
            'weight_in_grams' => 'required|numeric|min:0',
            'delivery_charge' => 'required|numeric|min:0',
            'setting_type' => 'required|in:na,min_order',
            'min_order' => 'nullable|numeric|min:0|required_if:setting_type,min_order',
        ]);

        // Check if a delivery charge already exists for the selected zone
        $existingCharge = DeliveryCharge::where('zone_id', $request->zone_id)->first();

        if ($existingCharge) {
            return back()->withErrors(['zone_id' => 'Delivery charge already exists for the selected zone.']);
        }

        // Create the new delivery charge
        DeliveryCharge::create([
            'zone_id' => $request->zone_id,
            'weight_in_grams' => $request->weight_in_grams,
            'delivery_charge' => $request->delivery_charge,
            'setting_type' => $request->setting_type,
            'min_order' => $request->setting_type === 'min_order' ? $request->min_order : null,
        ]);

        return redirect()->route('admin.shipping.delivery.charge')->with('success', 'Delivery charge added successfully.');
    }

    public function editDeliveryCharge($id)
    {
        $deliveryCharge = DeliveryCharge::findOrFail($id);
        $zones = ShippingZone::all();

        return view('backend.pages.shipping.add-delivery-charge', compact('deliveryCharge', 'zones'));
    }

    public function updateDeliveryCharge(Request $request, $id)
    {
        $request->validate([
            'zone_id'       => 'required|exists:shipping_zones,id',
            'weight_in_grams' => 'required|numeric|min:0',
            'delivery_charge' => 'required|numeric|min:0',
            'setting_type'    => 'required|in:na,min_order',
            'min_order'       => 'nullable|numeric|min:0|required_if:setting_type,min_order',
        ]);

        $deliveryCharge = DeliveryCharge::findOrFail($id);

        $deliveryCharge->update([
            'zone_id'          => $request->zone_id,
            'weight_in_grams'  => $request->weight_in_grams,
            'delivery_charge'  => $request->delivery_charge,
            'setting_type'     => $request->setting_type,
            'min_order'        => $request->setting_type === 'min_order'
                                    ? $request->min_order
                                    : null,
        ]);

        return redirect()->route('admin.shipping.delivery.charge')
        ->with('success', 'Delivery charge updated successfully.');
    }

    public function deleteDeliveryCharge($id)
    {
        $charge = DeliveryCharge::findOrFail($id);
        $charge->delete();

        return redirect()->route('admin.shipping.delivery.charge')
        ->with('success', 'Delivery charge deleted successfully.');
    }


}
