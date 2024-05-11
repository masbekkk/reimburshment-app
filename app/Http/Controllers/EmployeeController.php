<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function getEmployees()
    {
        try {
            $roleNames = ['staff', 'finance'];
            $usersWithRoles = User::with('roles')->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->orWhereDoesntHave('roles')->with('roles')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Retrieved Successfully!',
                'data' => $usersWithRoles
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error retrieve users data: ' . $errorMessage);
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
        $roles = Role::where('name', '!=', 'direktur')->get();
        return view('employees.index', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'nip' => ['required', 'integer', 'unique:' . User::class],
                'job_title' => ['required', 'string', 'max:255'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'role' => 'required|in:finance,staff',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = new User();
            $user->name = $request->name;
            $user->nip = $request->nip;
            $user->job_title = $request->job_title;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->syncRoles($request->role);
            return response()->json([
                'status' => 'success',
                'message' => 'Data Stored Successfully!',
                'data' => $user,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error store empployee data: ' . $errorMessage);
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
        $user = User::findOrFail($id);
        $roles = Role::where('name', '!=', 'direktur')->get();
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
                'nip' => ['required', 'integer'],
                'job_title' => ['required', 'string', 'max:255'],
                'role' => 'required|in:finance,staff',
            ] + ($request->filled('password') ? ['password' => ['required', 'confirmed', Password::defaults()]] : []));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->nip = $request->nip;
            $user->job_title = $request->job_title;
            if($request->filled('password'))
            $user->password = Hash::make($request->password);

            $user->save();

            $user->syncRoles($request->role);

            return response()->json([
                'status' => 'success',
                'message' => 'Data Updated Successfully!',
                'data' => $user,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Error update empployee data: ' . $errorMessage);
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
            $user = User::findOrFail($id);
            $user->delete();
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
