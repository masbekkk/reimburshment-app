<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReimburshmentRequest;
use App\Models\Reimburshment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ReimburshmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:direktur|finance')->except(['index', 'getReimburshment', 'store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */

    public function getReimburshment()
    {
        try {
            if (!auth()->user()->hasRoles('staff')) {
                $reimburshment = Reimburshment::with('user')->get();
            }else {
                $reimburshment = Reimburshment::where('user_id', auth()->user()->id)->with('user')->get();
            }
           
            return response()->json(['data' => $reimburshment], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            return response()->json(['error' => $errorMessage], $statusCode);
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
                // if ($oldFile?->resume !== null) {
                //     File::delete(public_path($oldFile?->resume));
                // }
                $reimburshment->support_file = $support_file;
            }
            $reimburshment->user_id = auth()->user()->id;
            $reimburshment->save();

            return response()->json([
                'status' => 'error',
                'message' => 'Data Stored Successfully!', 
                'data' => $reimburshment
            ], Response::HTTP_CREATED);
            
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            Log::error('Error store reimburshment data: ' . $errorMessage );
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store',
                'data' => null,
                'errors' => $errorMessage,
            ], $statusCode);
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reimburshment $reimburshment)
    {
        try {
            $reimburshment->date_of_submission = $request->date_of_submission;
            $reimburshment->reimburshment_name = $request->reimburshment_name;
            $reimburshment->description = $request->description;
            $reimburshment->support_file = $request->support_file;
            $reimburshment->save();

            return response()->json([
                'status' => 'error',
                'message' => 'Data Updated Successfully!', 
                'data' => $reimburshment
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            Log::error('Error store reimburshment data: ' . $errorMessage );
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update',
                'data' => null,
                'errors' => $errorMessage,
            ], $statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reimburshment $reimburshment)
    {
        try {
          
            $reimburshment->delete();
            return response()->json([
                'status' => 'error',
                'message' => 'Data Deleted Successfully!', 
                'data' => null
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            Log::error('Error delete reimburshment data: ' . $errorMessage );
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete',
                'data' => null,
                'errors' => $errorMessage,
            ], $statusCode);
        }
    }
}
