<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\Excel;
use App\Helpers\DbHelper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel as Exc;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\VehicleSeriesModel;
use App\Imports\VehicleSeriesModelsImport;

class VehicleSeriesModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, VehicleSeriesModel $model)
    {
        $filters = $request->all();
        // Base query
        $query = VehicleSeriesModel::query();
        $vehicleSeries = DbHelper::create_query($model, $filters);

        //if its an export
        if (isset($request->export)) {
            $vehicleSeries = $vehicleSeries->sortable()->get();
            if ($request->export == 'pdf') {
                $pdf =  PDF::loadView('vehicle_series_model._table', ['vehicleSeries' => $vehicleSeries])->setPaper('a4', 'portrait');
                return $pdf->stream('vehicle-series.pdf');
            }
            if ($request->export == 'excel') {
                return (new Excel($filters, $model))->download('vehicle_series.xlsx');
            }
        }

        // Paginate results
        $vehicleSeries = $vehicleSeries->sortable()->paginate(10);

        return view('vehicle_series_model.index', compact('vehicleSeries', 'filters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'series' => 'required|string|max:255',
            'previous_name' => 'nullable|string|max:255',
            'new_model_name_backend' => 'nullable|string|max:255',
            'new_model_name_customer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'amount' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max size 2MB
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('vehicle_photos', 'public');
        }

        VehicleSeriesModel::create($validated);

        return redirect()->route('vehicle-series.index')
            ->with('success', 'Vehicle series model added successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'series' => 'required|string|max:255',
            'previous_name' => 'nullable|string|max:255',
            'new_model_name_backend' => 'nullable|string|max:255',
            'new_model_name_customer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'amount' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $vehicleSeriesModel = VehicleSeriesModel::find($id);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($vehicleSeriesModel->photo) {
                Storage::disk('public')->delete($vehicleSeriesModel->photo);
            }

            $validated['photo'] = $request->file('photo')->store('vehicle_photos', 'public');
        }

        $update = $vehicleSeriesModel->update($validated);

        return redirect()->route('vehicle-series.index')
            ->with('success', 'Vehicle series model updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehicleSeries = VehicleSeriesModel::findOrFail($id);
        $vehicleSeries->delete();

        return redirect()->route('vehicle-series.index')->with('success', 'Vehicle Series deleted successfully.');
    }


    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Exc::import(new VehicleSeriesModelsImport, $request->file('file'));
            return redirect()->back()->with('success', 'Vehicle series and models have been successfully updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'An error occurred while importing the file: ' . $e->getMessage()]);
        }
    }
}
