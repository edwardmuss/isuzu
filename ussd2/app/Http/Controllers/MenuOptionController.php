<?php

namespace App\Http\Controllers;

use App\Models\MenuOption;
use Illuminate\Http\Request;

class MenuOptionController extends Controller
{
    public function index()
    {
        $menuOptions = MenuOption::with('parent')->orderBy('option_code', 'ASC')->get();
        // return $menuOptions;
        return view('menu_options.index', compact('menuOptions'));
    }

    public function create()
    {
        $parentOptions = MenuOption::whereNull('parent_id')->orderBy('option_code', 'ASC')->get();  // Get top-level options
        return view('menu_options.create', compact('parentOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'option_code' => 'required',
            'option_name' => 'required',
            'parent_id' => 'nullable|exists:menu_options,id',
            'action' => 'nullable|string',
        ]);

        MenuOption::create($validated);

        return redirect()->route('menu_options.index')->with('success', 'Menu option created successfully.');
    }

    // public function edit($id)
    // {
    //     $menuOption = MenuOption::findOrFail($id);
    //     $allMenuOptions = MenuOption::all();  // Get all menu options for the dropdown
    //     return view('menu_options.edit', compact('menuOption', 'allMenuOptions'));
    // }

    public function edit($id)
    {
        $menuOption = MenuOption::findOrFail($id);
        return response()->json($menuOption);
    }

    public function update2(Request $request, MenuOption $menuOption)
    {
        $validated = $request->validate([
            'option_code' => 'required',
            'option_name' => 'required',
            'parent_id' => 'nullable|exists:menu_options,id',
            'action' => 'nullable|string',
        ]);

        $menuOption->update($validated);

        return redirect()->route('menu_options.index')->with('success', 'Menu option updated successfully.');
    }

    public function update(Request $request, $id)
    {
        $menuOption = MenuOption::findOrFail($id);
        $menuOption->update($request->all());

        return redirect()->route('menu_options.index')->with('success', 'Menu option updated successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            MenuOption::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['status' => 'success']);
    }

    public function destroy(MenuOption $menuOption)
    {
        $menuOption->delete();
        return redirect()->route('menu_options.index')->with('success', 'Menu option deleted successfully.');
    }
}
