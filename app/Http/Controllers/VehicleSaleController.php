<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use App\Exports\VehicleSales;
use App\Models\Admin\VehicleSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class VehicleSaleController extends Controller
{

    public function __construct()
    {
        View::share("vehicle_sales", true);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param VehicleSale $model
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, VehicleSale $model)
    {

        $filters = $request->all();
        $vehicleSale = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $vehicleSale = $vehicleSale->sortable()->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('vehicle_sale._table', ['vehicle-sale' => $vehicleSale])->setPaper('a4', 'portrait');
                return $pdf->stream('vehicle-sales.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('vehicle_sales.xlsx');
            }
        }
        $vehicleSale = $vehicleSale->sortable(['ID' => 'desc'])->paginate(10);
        return view('vehicle_sale.index', compact('vehicleSale', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        unset($request['_token']);
        unset($request['_method']);
        DB::table('trequestquote')->where("ID", $id)->update($request->all());
        //$update = VehicleSale::updateorCreate(['ID'=>$id], [$request->all()]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function change(Request $request)
    {
        DB::table('trequestquote')->where("ID", $request->id)->update($request->all());
        //$update = VehicleSale::updateorCreate(['ID'=>$id], [$request->all()]);
        return redirect()->back();
    }
}
