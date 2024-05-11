<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function getRoles()
    {
        try {
            $roles = Role::with('permissions')->get();
          
            return response()->json([
                'status' => 'success',
                'message' => 'Data Retrieved Successfully!', 
                'data' => $roles
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
           
            Log::error('Error retrieve roles data: ' . $errorMessage );
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('rbac.roles', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'unique:' . Role::class],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->input('permission'));

            return response()->json([
                'status' => 'success',
                'message' => 'Data Stored Successfully!',
                'data' => $role,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error store role data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $role = Role::updateOrCreate(['name' => $request->name]);
            $role->syncPermissions($request->input('permission'));

            return response()->json([
                'status' => 'success',
                'message' => 'Data Updated Successfully!',
                'data' => $role,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error store role data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
           
            $role->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data Deleted Successfully!',
                'data' => null
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error delete role data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }
}
