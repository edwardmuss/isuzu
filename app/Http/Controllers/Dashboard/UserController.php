<?php

namespace App\Http\Controllers\Dashboard;

use PDF;
use App\Models\User;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel as Exc;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $model)
    {
        $filters = $request->all();
        // Base query
        $query = User::query();
        $admin_users = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $admin_users = $admin_users->sortable()->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('users._table', ['admin_users' => $admin_users])->setPaper('a4', 'portrait');
                return $pdf->stream('admin_users.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('admin_users.xlsx');
            }
        }

        // Paginate results
        $admin_users = $admin_users->sortable()->paginate(10);

        return view('users.index', compact('admin_users', 'filters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);


        return redirect()->route('users.index')
            ->with('success', 'user added successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6', // Password is optional, but if provided, it should be confirmed
        ]);

        // Update the user details
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update the password if it's not blank
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Save the updated user
        $user->save();

        // Redirect to the users list with success message
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin_users = User::findOrFail($id);

        $admin_users->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
