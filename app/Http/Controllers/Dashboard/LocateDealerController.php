<?php

namespace App\Http\Controllers\Dashboard;

use PDF;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use App\Models\Admin\LocateDealer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LocateDealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param LocateDealer $model
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LocateDealer $model)
    {
        $filters = $request->all();
        $locate_dealer = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $locate_dealer = $locate_dealer->sortable(['id' => 'desc'])->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('locate_dealer._table', ['locate_dealer' => $locate_dealer])->setPaper('a4', 'portrait');
                return $pdf->stream('locate_dealer.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('locate_dealer.xlsx');
            }
        }
        $locate_dealer = $locate_dealer->where('contact_id', 5);
        $locate_dealer = $locate_dealer->sortable(['id' => 'desc'])->paginate(20);
        return view('locate_dealer.index', compact('locate_dealer', 'filters'));
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
        DB::table('tcontactreq')->where("id", $id)->update(['comment' => $request->comment]);
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
