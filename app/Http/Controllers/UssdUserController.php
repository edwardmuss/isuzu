<?php

namespace App\Http\Controllers;

use PDF;;

use App\Exports\Excel;
use App\Helpers\DbHelper;
use App\Exports\UssdUsers;
use Illuminate\Http\Request;
use App\Models\Admin\UssdUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class UssdUserController extends Controller
{

    public function __construct()
    {
        View::share("ussd_users", true);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param UssdUser $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UssdUser $user)
    {
        $filters = $request->all();
        $users = DbHelper::create_query($user, $filters);
        //if its an export
        if (isset($request->export)) {
            $users = $users->sortable(['ID' => 'desc'])->take(10)->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('ussd_users._table', ['users' => $users])->setPaper('a4', 'portrait');
                return $pdf->stream('ussd_users.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $user))->download('ussd_users.xlsx');
            }
        }
        $users = $users->sortable(['ID' => 'desc'])->paginate(20);
        return view('ussd_users.index', compact('users', 'filters'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('tussdusers')->where("ID", $id)->update(['comment' => $request->comment]);
        //$update = VehicleSale::updateorCreate(['ID'=>$id], [$request->all()]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
