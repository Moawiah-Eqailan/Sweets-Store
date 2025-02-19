<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->get();


        $users = DB::table('users')
            ->orderBy('users.id', 'desc')
            ->paginate(10);

        return view('Admin.Users.index', compact('users'));
    }

    public function create()
    {
        return view('Admin.Users.create');
    }
    public function store(Request $request)
    {
        User::create($request->all());

        return redirect()->route('Users')->with('success', 'Users added successfully');
    }
    /**
     * Display the user's Users form.
     */
    public function edit(Request $request): View
    {
        return view('Admin.Users.edit', [
            'users' => $request->user(),
        ]);
    }

    public function show(string $id)
    {
        $users = User::findOrFail($id);

        return view('Admin.Users.show', compact('users'));
    }

    /**
     * Update the user's Users information.
     */
    public function update(Request $request, string $id)
    {
        $users = User::findOrFail($id);

        $users->update($request->all());

        return redirect()->route('Users')->with('success', 'User updated successfully');
    }

    /**
     * Delete the user's account.
     */

    public function destroy(string $id)
    {
        $users = User::findOrFail($id);

        $users->delete();

        return redirect()->route('Users')->with('success', 'User deleted successfully');
    }


    public function ssearchh(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('name', 'LIKE', "%$query%")->get();
        $users = User::where('email', 'LIKE', "%$query%")->get();
        return view('Admin.users.index', ['users' => $users]);
    }

    public function updateUserProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|min:10|max:60|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|min:10|max:14',
            'address' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:10',
            'state' => 'nullable|string|max:80',
            'city' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'old_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        if ($request->old_password === $request->password) {
            return redirect()->back()->withErrors(['password' => 'The new password must be different from the old one.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }


    public function statistics()
    {
        $totalUsers = User::count();
        return view('dashboard', compact('totalUsers'));
    }
    







    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
    
        $id = $request->id; 
    
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
    
        return response()->json([
            'status' => 200,
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }
}
