<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use App\Models\Admin\LocateDealer;
use Illuminate\Support\Facades\DB;

class TechnicalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param  LocateDealer $model
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LocateDealer $model)
    {
        $filters = $request->all();
        $tech_assistance = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $tech_assistance = $tech_assistance->sortable(['id' => 'desc'])->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('tech_assistance._table', ['tech_assistance' => $tech_assistance])->setPaper('a4', 'portrait');
                return $pdf->stream('tech_assistance.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('tech_assistance.xlsx');
            }
        }
        $tech_assistance = $tech_assistance->where('contact_id', 3);
        $tech_assistance = $tech_assistance->sortable(['id' => 'desc'])->paginate(20);
        return view('technical.index', compact('tech_assistance', 'filters'));
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
        DB::table('tcontactreq')->where("id", $id)->update($request->all());
        //$update = VehicleSale::updateorCreate(['ID'=>$id], [$request->all()]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function change(Request $request)
    {
        DB::table('tcontactreq')->where("id", $request->id)->update($request->all());
        //$update = VehicleSale::updateorCreate(['ID'=>$id], [$request->all()]);
        return redirect()->back();
    }
}
