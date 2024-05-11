<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReimburshmentRequest;
use App\Models\Reimburshment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ReimburshmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:direktur|finance')->except(['index', 'getReimburshment', 'store', 'edit','update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */

    public function getReimburshment()
    {
        try {
            if (!auth()->user()->hasRoles('staff')) {
                $reimburshment = Reimburshment::with('user')->orderBy('id', 'ASC')->get();
            }else {
                $reimburshment = Reimburshment::with('user')->where('user_id', auth()->user()->id)->orderBy('id', 'ASC')->get();
            }
           
            return response()->json([
                'status' => 'success',
                'message' => 'Data Retrieved Successfully!', 
                'data' => $reimburshment
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
        return view('reimburshment.index');
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
    public function store(ReimburshmentRequest $request)
    {
        try {
            $reimburshment = new Reimburshment();

            $reimburshment->date_of_submission = $request->date_of_submission;
            $reimburshment->reimburshment_name = $request->reimburshment_name;
            $reimburshment->description = $request->description;
            if ($request->hasFile('support_file')) {
                $filePath = $request->file('support_file')->store('reimburshment/support_file', 'public');
                $support_file = 'storage/' . $filePath;
                $reimburshment->support_file = $support_file;
            }
            $reimburshment->user_id = auth()->user()->id;
            $reimburshment->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Stored Successfully!', 
                'data' => $reimburshment
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
    public function show(Reimburshment $reimburshment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reimburshment $reimburshment)
    {
        return view('reimburshment.edit', compact('reimburshment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reimburshment $reimburshment)
    {
        try {
            $request->validate([
                'date_of_submission' => 'required|date',
                'reimburshment_name' => 'required|string|max:255',
                'description' => 'required|string',
                'support_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            ]);
            // $reimburshment = Reimburshment::findOrFail($reimburshment->id);
            $reimburshment->date_of_submission = $request->date_of_submission;
            $reimburshment->reimburshment_name = $request->reimburshment_name;
            $reimburshment->description = $request->description;
            if ($request->hasFile('support_file')) {
                $filePath = $request->file('support_file')->store('reimburshment/support_file', 'public');
                $support_file = 'storage/' . $filePath;
                if ($reimburshment->support_file !== null && File::exists($reimburshment->support_file)) {
                    File::delete(public_path($reimburshment->support_file));
                }
                $reimburshment->support_file = $support_file;
            }
            $reimburshment->user_id = auth()->user()->id;
            $reimburshment->update();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Updated Successfully!', 
                'data' => $reimburshment
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
    public function destroy(Reimburshment $reimburshment)
    {
        try {
            if ($reimburshment->support_file !== null && File::exists($reimburshment->support_file)) {
                File::delete(public_path($reimburshment->support_file));
            }
            $reimburshment->delete();
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
           
            $reimburshment = Reimburshment::findOrFail($request->id);
            $reimburshment->status = $request->status;
            $reimburshment->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Status Updated Successfully!', 
                'data' => $reimburshment
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
