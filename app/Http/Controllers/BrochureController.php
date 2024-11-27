<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use App\Models\Admin\Brochure;
use Illuminate\Support\Facades\DB;

class BrochureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Brochure $model
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Brochure $model)
    {
        $filters = $request->all();
        $brochure = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $brochure = $brochure->sortable()->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('brochure._table', ['brochure' => $brochure])->setPaper('a4', 'portrait');
                return $pdf->stream('brochure.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel(filters, $model))->download('brochure.xlsx');
            }
        }
        $brochure = $brochure->sortable(['id' => 'desc'])->paginate(20);
        return view('brochure.index', compact('brochure', 'filters'));
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
        DB::table('tbrochurereq')->where("id", $id)->update(['comment' => $request->comment]);
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
}
