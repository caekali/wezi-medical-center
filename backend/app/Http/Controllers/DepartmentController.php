<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;

class DepartmentServiceController extends Controller
{
    /**
     * List all departments with services.
     */
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    /**
     * Store a new department or service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $department = Department::create([
            'name' => $request->name,
        ]);

        return response()->json($department, 201);
    }

    /**
     * Update department.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $department = Department::findOrFail($id);
        $department->update(['name' => $request->name, 'description' => $request->description]);
        return response()->json($department);
    }

    /**
     * Soft delete department.
     */
    public function destroy($type, $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(['message' => 'Department deleted']);
    }

    /**
     * Show soft deleted items.
     */
    public function trashed($type)
    {

        $trashed = Department::onlyTrashed()->get();
        return response()->json($trashed);
    }

    /**
     * Restore a soft deleted item.
     */
    public function restore($id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->restore();
        return response()->json(['message' => 'Department restored']);
    }
}
