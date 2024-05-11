<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function getEmployees()
    {
        try {
            $roleNames = ['staff', 'finance'];
            $usersWithRoles = User::with('roles')->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Retrieved Successfully!',
                'data' => $usersWithRoles
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            Log::error('Error retrieve users data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve',
                'data' => null,
                'errors' => $errorMessage,
            ], $statusCode);
        }
    }

    public function index()
    {
        return view('employees.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'role' => 'required|in:finance,staff',
            ] + ($request->filled('password') ? ['password' => ['string', 'min:8', 'confirmed']] : []));
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ] + ($request->filled('password') ? ['password' => Hash::make($request->password)] : []));

            $user->syncRoles($request->role);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Data Updated Successfully!',
                'data' => $user,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            Log::error('Error update empployee data: ' . $errorMessage);
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
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data Deleted Successfully!',
                'data' => null
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            Log::error('Error delete user data: ' . $errorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete',
                'data' => null,
                'errors' => $errorMessage,
            ], $statusCode);
        }
    }
}
