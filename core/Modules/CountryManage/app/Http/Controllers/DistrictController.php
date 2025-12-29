<?php

namespace Modules\CountryManage\app\Http\Controllers;

use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use Modules\CountryManage\app\Models\District;

class DistrictController extends Controller
{
    public function all_district(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'district'   => 'required|max:191|unique:districts,district',
                'country'    => 'required',
                'state'      => 'required',
            ]);

            District::create([
                'district'   => $request->district,
                'country_id' => $request->country,
                'state_id'   => $request->state,
                'status'     => $request->status,
            ]);

            FlashMsg::item_new(__('New District Successfully Added'));
        }

        $all_districts = District::latest()->paginate(10);
        $all_countries = Country::all_countries();
        $all_states    = State::all();

        return view('countrymanage::district.all-district', compact(
            'all_districts',
            'all_countries',
            'all_states'
        ));
    }

    public function edit_district(Request $request)
    {
        $request->validate([
            'edit_district' => 'required|max:191|unique:districts,district,' . $request->district_id,
            'edit_country'  => 'required',
            'edit_state'    => 'required',
        ]);

        District::where('id', $request->district_id)->update([
            'district'   => $request->edit_district,
            'country_id' => $request->edit_country,
            'state_id'   => $request->edit_state,
        ]);

        return redirect()->back()->with(
            FlashMsg::item_new(__('District Successfully Updated'))
        );
    }

    public function change_status_district($id)
    {
        $district = District::select('status')->where('id', $id)->first();
        $status = $district->status == 1 ? 0 : 1;

        District::where('id', $id)->update(['status' => $status]);

        return redirect()->back()->with(
            FlashMsg::item_new(__('Status Successfully Changed'))
        );
    }

    public function delete_district($id)
    {
        District::find($id)->delete();

        return redirect()->back()->with(
            FlashMsg::item_delete(__('District Successfully Deleted'))
        );
    }

    public function bulk_action_district(Request $request)
    {
        District::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with(
            FlashMsg::item_new(__('Selected District Successfully Deleted'))
        );
    }

    /* ---------------- CSV IMPORT ---------------- */

    public function import_settings()
{
    $all_countries = Country::all_countries();
    $all_states = State::all();

    return view('countrymanage::district.import-district', compact(
        'all_countries',
        'all_states'
    ));
}


    public function update_import_settings(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:150000'
        ]);

        if ($request->hasFile('csv_file')) {
            $file = $request->csv_file;
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'csv') {

                $old_file = Session::get('import_csv_file_name');
                if (file_exists('assets/uploads/import/' . $old_file)) {
                    @unlink('assets/uploads/import/' . $old_file);
                }

                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file_name = strtolower(Str::slug($file_name));
                $file_tmp_name = $file_name . time() . '.' . $extension;

                $file->move('assets/uploads/import', $file_tmp_name);

                $data = array_map('str_getcsv', file('assets/uploads/import/' . $file_tmp_name));
                $csv_data = array_slice($data, 0, 1);

                Session::put('import_csv_file_name', $file_tmp_name);

                return view('countrymanage::district.import-district', [
                    'import_data' => $csv_data,
                ]);
            }
        }

        FlashMsg::item_delete(__('Something went wrong, try again'));
        return back();
    }

    public function import_to_database_settings(Request $request)
    {
        $file_tmp_name = Session::get('import_csv_file_name');
        $data = array_map('str_getcsv', file('assets/uploads/import/' . $file_tmp_name));

        $csv_data = current(array_slice($data, 0, 1));
        $csv_data = array_map('trim', $csv_data);

        $district_index = array_search($request->district, $csv_data, true);

        $imported = 0;
        $x = 0;

        foreach ($data as $index => $item) {
            if ($x === 0) {
                $x++;
                continue;
            }

            if (empty($item[$district_index])) {
                continue;
            }

            $exists = District::where('district', $item[$district_index])
                ->where('state_id', $request->state_id)
                ->count();

            if ($exists < 1) {
                District::create([
                    'district'   => $item[$district_index],
                    'country_id' => $request->country_id,
                    'state_id'   => $request->state_id,
                    'status'     => $request->status,
                ]);
                $imported++;
            }
        }

        FlashMsg::item_new($imported . ' ' . __('Districts imported successfully'));
        return redirect()->route('admin.district.import.csv.settings');
    }

    /* ---------------- AJAX ---------------- */

    public function pagination(Request $request)
    {
        if ($request->ajax()) {
            $all_districts = District::latest()->paginate(10);
            return view('countrymanage::district.search-result', compact('all_districts'))->render();
        }
    }

    public function search_district(Request $request)
    {
        $all_districts = District::where(
            'district',
            'LIKE',
            "%" . strip_tags($request->string_search) . "%"
        )->paginate(10);

        if ($all_districts->total() >= 1) {
            return view('countrymanage::district.search-result', compact('all_districts'))->render();
        }

        return response()->json(['status' => __('nothing')]);
    }
}
