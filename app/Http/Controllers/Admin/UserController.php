<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'operator');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['role'] = 'operator';
        $validated['is_active'] = true;
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Operator berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Only allow viewing operators
        if ($user->role !== 'operator') {
            abort(404);
        }

        $user->load(['services.vehicle', 'borrowings.vehicle', 'payments.service']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Only allow editing operators
        if ($user->role !== 'operator') {
            abort(404);
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Only allow updating operators
        if ($user->role !== 'operator') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data operator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Only allow deleting operators
        if ($user->role !== 'operator') {
            abort(404);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Operator berhasil dihapus.');
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        // Only allow resetting operator passwords
        if ($user->role !== 'operator') {
            abort(404);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password operator berhasil direset.');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Only allow toggling operator status
        if ($user->role !== 'operator') {
            abort(404);
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.users.index')
            ->with('success', "Operator berhasil {$status}.");
    }
}
