<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function getVehicles()
    {
        try {
            $vehicles = Vehicle::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Retrieved Successfully!',
                'data' => $vehicles
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error retrieve vehicles data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }

    public function index()
    {
        return view('vehicles.index');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'fuel_type' => ['required', 'string', 'max:255'],
                'fuel_capacity' => 'required', 'integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $vehicle = new Vehicle();
            $vehicle->name = $request->name;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->fuel_capacity = $request->fuel_capacity;
            $vehicle->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Stored Successfully!',
                'data' => $vehicle,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error store vehicle data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }

    public function edit($id)
    {
        return view('employees.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'fuel_type' => ['required', 'string', 'max:255'],
                'fuel_capacity' => 'required', 'integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->name = $request->name;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->fuel_capacity = $request->fuel_capacity;

            $vehicle->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Updated Successfully!',
                'data' => $vehicle,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error update vehicle data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data Deleted Successfully!',
                'data' => null
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error delete user data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }
}
