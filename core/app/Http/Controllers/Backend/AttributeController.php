<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Size;
use App\Models\DeliveryOption;

class AttributeController extends Controller
{
    // Unit
    public function index() 
    {
        $units = Unit::all();
        return view('backend.pages.attributes.unit-index', compact('units'));
    }

    public function create()
    {
        return view('backend.pages.attributes.add-unit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
        ]);

        Unit::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.attributes.unit.index')
            ->with('message', 'Unit created successfully.');
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('backend.pages.attributes.add-unit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $id,
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update(['name' => $request->name]);

        return redirect()->route('admin.attributes.unit.index')
                        ->with('message', 'Unit updated successfully.');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('admin.attributes.unit.index')
            ->with('message', 'Unit deleted successfully.');
    }

    // Size
    public function sizeIndex()
    {
        $sizes = Size::all();
        return view('backend.pages.attributes.size-index', compact('sizes'));
    }

    public function addSize()
    {
        return view('backend.pages.attributes.add-size');
    }

    public function storeSize(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255|unique:sizes,name',
            'size_code' => 'required|string|max:10|unique:sizes,size_code',
            'slug'      => 'nullable|string|max:255|unique:sizes,slug',
        ]);

        Size::create([
            'name'      => $request->name,
            'size_code' => $request->size_code,
            'slug'      => $request->slug ?? \Str::slug($request->name),
        ]);

        return redirect()->route('admin.attributes.size.index')->with('message', 'Size created successfully.');
    }

    public function editSize($id)
    {
        $size = Size::findOrFail($id);
        return view('backend.pages.attributes.add-size', compact('size'));
    }

    public function updateSize(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255|unique:sizes,name,' . $id,
            'size_code' => 'required|string|max:10|unique:sizes,size_code,' . $id,
            'slug'      => 'nullable|string|max:255|unique:sizes,slug,' . $id,
        ]);

        $size = Size::findOrFail($id);
        $size->update([
            'name'      => $request->name,
            'size_code' => $request->size_code,
            'slug'      => $request->slug ?? \Str::slug($request->name),
        ]);

        return redirect()->route('admin.attributes.size.index')->with('message', 'Size updated successfully.');
    }

    public function deleteSize($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('admin.attributes.size.index')->with('message', 'Size deleted successfully.');
    }

    // Delivery Options
    public function deliveryOptionIndex()
    {
        $deliveryOptions = DeliveryOption::all();
        return view('backend.pages.attributes.delivery-option-index', compact('deliveryOptions'));
    }

    public function addDeliveryOption()
    {
        return view('backend.pages.attributes.add-delivery-option');
    }

    public function storeDeliveryOption(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        DeliveryOption::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
        ]);

        return redirect()->route('admin.attributes.delivery.option.index')
                        ->with('message', 'Delivery option created successfully.');
    }

    public function editDeliveryOption($id)
    {
        $deliveryOption = DeliveryOption::findOrFail($id);
        return view('backend.pages.attributes.add-delivery-option', compact('deliveryOption'));
    }

    public function updateDeliveryOption(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        $deliveryOption = DeliveryOption::findOrFail($id);
        $deliveryOption->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
        ]);

        return redirect()->route('admin.attributes.delivery.option.index')
                        ->with('message', 'Delivery option updated successfully.');
    }

    public function destroyDeliveryOption($id)
    {
        $option = DeliveryOption::findOrFail($id);
        $option->delete();

        return redirect()->route('admin.attributes.delivery.option.index')
            ->with('message', 'Delivery option deleted successfully.');
    }

}
