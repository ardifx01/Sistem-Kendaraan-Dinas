<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'operator');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }

        $operators = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.operators.index', compact('operators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.operators.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'operator';

        User::create($data);

        return redirect()->route('admin.operators.index')
                        ->with('success', 'Data operator berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $operator)
    {
        if ($operator->role !== 'operator') {
            abort(404);
        }

        return view('admin.operators.show', compact('operator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $operator)
    {
        if ($operator->role !== 'operator') {
            abort(404);
        }

        return view('admin.operators.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $operator)
    {
        if ($operator->role !== 'operator') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($operator->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($operator->id)],
            'password' => 'nullable|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $operator->update($data);

        return redirect()->route('admin.operators.index')
                        ->with('success', 'Data operator berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $operator)
    {
        if ($operator->role !== 'operator') {
            abort(404);
        }

        $operator->delete();

        return redirect()->route('admin.operators.index')
                        ->with('success', 'Data operator berhasil dihapus!');
    }
}
