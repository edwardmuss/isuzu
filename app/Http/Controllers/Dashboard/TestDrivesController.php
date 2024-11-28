<?php

namespace App\Http\Controllers\Dashboard;

use PDF;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use App\Models\Admin\TestDrive;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TestDrivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param TestDrive $model
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TestDrive $model)
    {
        $filters = $request->all();
        $test_drives = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $test_drives = $test_drives->sortable(['id' => 'desc'])->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('test_drives._table', ['test_drives' => $test_drives])->setPaper('a4', 'portrait');
                return $pdf->stream('test_drives.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('test-drives.xlsx');
            }
        }
        $test_drives = $test_drives->sortable(['id' => 'desc'])->paginate(20);
        return view('test_drives.index', compact('test_drives', 'filters'));
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
        DB::table('ttestdrivereq')->where("id", $id)->update(['comment' => $request->comment]);
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
