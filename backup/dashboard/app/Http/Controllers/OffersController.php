<?php

namespace App\Http\Controllers;

use App\Exports\Excel;
use App\Helpers\DbHelper;
use App\Model\Offer;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Offer $model
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Offer $model)
    {
        $filters = $request->all();
        $offers = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $offers = $offers->sortable(['id' => 'desc'])->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('offers._table', ['offers' => $offers])->setPaper('a4', 'portrait');
                return $pdf->stream('offers.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('offers.xlsx');
            }
        }
        $offers = $offers->sortable(['id' => 'desc'])->paginate(20);
        return view('offers.index', compact('offers', 'filters'));
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
        DB::table('tspecialoffers')->where("id", $id)->update($request->all());
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
        DB::table('tspecialoffers')->where("id", $request->id)->update($request->all());
        //$update = VehicleSale::updateorCreate(['ID'=>$id], [$request->all()]);
        return redirect()->back();
    }
}
