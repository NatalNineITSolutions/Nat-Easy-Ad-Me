<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Listing;
use Illuminate\Http\Request;
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\State;

class FrontendSearchController extends Controller
{
    public function home_search(Request $request)
{
    $memberIds = [0];

    if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
        $memberIds = Listing::query()
            ->join('user_memberships', 'user_memberships.user_id','=','listings.user_id')
            ->where('user_memberships.expire_date','>=',date('Y-m-d'))
            ->pluck('listings.user_id')
            ->push(0)
            ->toArray();
    }

    $listings = Listing::query()
        ->where(function ($query) use ($memberIds) {
            $query->whereIn('listings.user_id', $memberIds)
                  ->orWhereNotNull('admin_id');
        })
        ->where('status', 1)
        ->where('is_published', 1);

    // 🔍 text search
    if (!empty($request->search_text)) {
        $listings->where(function ($query) use ($request) {
            $query->where('listings.title', 'LIKE', '%' . $request->search_text . '%')
            ->orWhere('listings.description', 'LIKE', '%' . $request->search_text . '%')
            ->orWhere('listings.price', 'LIKE', '%' . $request->search_text . '%')
            ->orWhereHas('tags', function ($q) use ($request) {
                $q->where('tags.name', 'LIKE', '%' . $request->search_text . '%');
            });
        });
    }

    // 📍 location filters
    if (!empty($request->country_id)) {
        $listings->where('country_id', $request->country_id);
    }

    if (!empty($request->state_id)) {
        $listings->where('state_id', $request->state_id);
    }

    if (!empty($request->city_id)) {
        $listings->where('city_id', $request->city_id);
    }

    $listings = $listings->latest()->get();

    return response()->json([
        'status' => 'success',
        'result' => view('frontend.layout.partials.search.search-result', compact('listings'))->render(),
    ]);
}


    public function getState(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->where('status', 1)->take(500)->get();
        return response()->json([
            'status' => 'success',
            'states' => $states,
        ]);
    }
    public function getStateAjaxSearch(Request $request)
    {
        $dQuery = City::query();
        if(!empty($request->country_id)){
            $dQuery->where('country_id', $request->country_id);
        }
        if($request->has('q')){
            $search = $request->q;
            $dQuery->where('state','LIKE',"%$search%");
        }
        $data = $dQuery->where('status', 1)->take(200)->get();
        return response()->json($data);
    }

    public function getCity(Request $request)
    {
        $cites = City::where('state_id', $request->state_id)->where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'cites' => $cites,
        ]);
    }

}
