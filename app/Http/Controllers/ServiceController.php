<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use App\Models\Admin\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class ServiceController extends Controller
{
    public function __construct()
    {
        View::share("service", true);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Service $model
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Service $model)
    {
        $filters = $request->all();
        $service = DbHelper::create_query($model, $filters);


        //if its an export
        if (isset($request->export)) {
            $service = $service->sortable(['id' => 'desc'])->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('ussd_users._table', ['service' => $service])->setPaper('a4', 'portrait');
                return $pdf->stream('service.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('service.xlsx');
            }
        }
        $service = $service->sortable(['id' => 'desc'])->paginate(20);
        return view('service.index', compact('service', 'filters'));
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
        DB::table('tservicereq')->where("ID", $id)->update($request->all());
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
        DB::table('tservicereq')->where("ID", $request->id)->update($request->all());
        //$update = VehicleSale::updateorCreate(['ID'=>$id], [$request->all()]);
        return redirect()->back();
    }
}
