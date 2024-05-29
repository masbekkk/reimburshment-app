<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleLoanRequest;
use App\Models\VehicleLoan;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class VehicleLoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:direktur|stakeholder')->except(['index', 'getVehicleLoan', 'store', 'edit','update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */

    public function getVehicleLoan()
    {
        try {
            if (!auth()->user()->hasRoles('admin')) {
                $vehicleLoan = VehicleLoan::with('user', 'stakeholder', 'vehicle')->orderBy('id', 'ASC')->get();
            }else {
                $vehicleLoan = VehicleLoan::with('user', 'stakeholder', 'vehicle')->where('user_id', auth()->user()->id)->orderBy('id', 'ASC')->get();
            }
           
            return response()->json([
                'status' => 'success',
                'message' => 'Data Retrieved Successfully!', 
                'data' => $vehicleLoan
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
           
            Log::error('Error retrieve reimburshment data: ' . $errorMessage );
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }

    //  function di model dan if else di column datatables

    /**
     * Display a listing of the resource as view.
     */
    public function index()
    {
        return view('vehicle_loan.index');
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
    public function store(VehicleLoanRequest $request)
    {
        try {
            $vehicleLoan = new VehicleLoan();

            $vehicleLoan->notes = $request->notes;
            $vehicleLoan->vehicle_id = $request->vehicle_id;
            $vehicleLoan->stakeholder_id = $request->stakeholder_id;
            $vehicleLoan->user_id = auth()->user()->id;
            $vehicleLoan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Stored Successfully!', 
                'data' => $vehicleLoan
            ], Response::HTTP_CREATED);
            
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
           
            Log::error('Error store reimburshment data: ' . $errorMessage );
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
    public function show(VehicleLoan $vehicleLoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleLoan $vehicleLoan)
    {
        $vehicles = Vehicle::all();
        return view('vehicle_loan.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleLoan $vehicleLoan)
    {
        try {
            $request->validate([
                'notes' => 'nullable|string',
            ]);
            // $vehicleLoan = VehicleLoan::findOrFail($vehicleLoan->id);
            $vehicleLoan->notes = $request->notes;
            $vehicleLoan->vehicle_id = $request->vehicle_id;
            $vehicleLoan->stakeholder_id = $request->stakeholder_id;
            $vehicleLoan->user_id = auth()->user()->id;
            $vehicleLoan->update();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Updated Successfully!', 
                'data' => $vehicleLoan
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
           
            Log::error('Error store reimburshment data: ' . $errorMessage );
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
    public function destroy(VehicleLoan $vehicleLoan)
    {
        try {
            $vehicleLoan->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data Deleted Successfully!', 
                'data' => null
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
           
            Log::error('Error delete reimburshment data: ' . $errorMessage );
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }


    /**
     * Update reimburshment status
     */
    public function updateStatus(Request $request)
    {
        // dd($request->status);
        try {
            $request->validate([
                'id' => 'required|integer',
                'status' => 'required|in:accept,reject,done',
            ]);
           
            $vehicleLoan = VehicleLoan::findOrFail($request->id);
            $vehicleLoan->status = $request->status;
            $vehicleLoan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Status Updated Successfully!', 
                'data' => $vehicleLoan
            ], Response::HTTP_CREATED);
            
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
           
            Log::error('Error Status Updated reimburshment data: ' . $errorMessage );
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to Status Updated',
                'data' => null,
                'errors' => $errorMessage,
            ], 500);
        }
    }
}
