<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin\Part;
use App\Models\Admin\Offer;
use Illuminate\Http\Request;
use App\Models\Admin\Service;
use App\Models\Admin\Brochure;
use App\Models\Admin\PsvAward;
use App\Models\Admin\TestDrive;
use App\Models\Admin\VehicleSale;
use App\Models\Admin\LocateDealer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    public function __construct()
    {
        View::share("index", true);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function allCounts(Request $request)
    {
        //all counts

        $counts = array();
        if (isset($request['range'])) {
            $date_range[] = explode(" ", $request['range']);
            $start_date[] = explode("-", $date_range[0][0]);
            $start = Carbon::create($start_date[0][0], $start_date[0][1], $start_date[0][2]);

            $end_date[] = explode("-", $date_range[0][2]);
            $end = Carbon::create($end_date[0][0], $end_date[0][1], $end_date[0][2]);

            $counts['Test drives'] = TestDrive::whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();
            $counts['Brochures'] = Brochure::whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();
            $counts['Offers'] = Offer::whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();
            $counts['Service'] = Service::whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();
            $counts['Parts'] = Part::whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();
            $counts['Psv Awards'] = PsvAward::whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();
            $counts['Locate dealers'] = LocateDealer::where('contact_id', 3)->whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();
            $counts['Technical assistance'] = LocateDealer::where('contact_id', 5)->whereRaw('date(created_at) >= ?', [$start->startOfDay()])->whereRaw('date(created_at) <= ?', [$end->endOfDay()])->count();

            return Response::json($counts);
        }

        $counts['Test drives'] = TestDrive::count();
        $counts['Brochures'] = Brochure::count();
        $counts['Offers'] = Offer::count();
        $counts['Service'] = Service::count();
        $counts['Parts'] = Part::count();
        $counts['Psv Awards'] = PsvAward::count();
        $counts['Locate dealers'] = LocateDealer::where('contact_id', 3)->count();
        $counts['Technical assistance'] = LocateDealer::where('contact_id', 5)->count();

        //dd($counts);

        //dd(json_encode($counts["test_drives"]));
        return Response::json($counts);
    }

    public function pickups()
    {
        $counts  = array();
        $counts['single_cab'] = VehicleSale::where('quote_name', 'like', '%Single Cab%')->count();
        $counts['double_cab'] = VehicleSale::where('quote_name', 'like', '%Double Cab%')->count();

        return Response::json($counts);
    }

    public function pickupYearly()
    {
        $data = array();
        $year = date('Y');
        $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

        foreach ($months as $month) {
            $start_time = date("Y-m-d", strtotime($year . '-' . $month . '-01'));
            $days = date('t', strtotime($month . '/' . $year));
            $end_time = date("Y-m-d", strtotime($year . '-' . $month . '-' . $days));

            $data['singleCab'][] = (int) VehicleSale::where('quote_name', 'like', '%Single Cab%')
                ->where('created_at', '>=', $start_time)
                ->where('created_at', '<=', $end_time)
                ->count();

            $data['doubleCab'][] = (int) VehicleSale::where('quote_name', 'like', '%Double Cab%')
                ->where('created_at', '>=', $start_time)
                ->where('created_at', '<=', $end_time)
                ->count();
        }

        return Response::json($data);
    }

    public function vehicleSales()
    {
        $data = array();
        $year = date('Y');
        $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

        foreach ($months as $month) {
            $start_time = date("Y-m-d", strtotime($year . '-' . $month . '-01'));
            $days = date('t', strtotime($month . '/' . $year));
            $end_time = date("Y-m-d", strtotime($year . '-' . $month . '-' . $days));

            $data['pickUp'][] = (int) VehicleSale::where('quote_name', 'like', '%pickup%')
                ->where('created_at', '>=', $start_time)
                ->where('created_at', '<=', $end_time)
                ->count();

            $data['bus'][] = (int) VehicleSale::where('quote_name', 'like', '%bus%')
                ->where('created_at', '>=', $start_time)
                ->where('created_at', '<=', $end_time)
                ->count();

            $data['truck'][] = (int) VehicleSale::where('quote_name', 'like', '%truck%')
                ->where('created_at', '>=', $start_time)
                ->where('created_at', '<=', $end_time)
                ->count();

            $data['primeMovers'][] = (int) VehicleSale::where('quote_name', 'like', '%prime mover%')
                ->where('created_at', '>=', $start_time)
                ->where('created_at', '<=', $end_time)
                ->count();

            $data['mux'][] = (int) VehicleSale::where('quote_name', 'like', '%mu-x%')
                ->where('created_at', '>=', $start_time)
                ->where('created_at', '<=', $end_time)
                ->count();
        }

        return Response::json($data);
    }
}
