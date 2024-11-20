<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index', compact(['users',]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'given_name' => ['required', 'min:1', 'max:255', 'string',],
            'family_name' => ['required', 'min:1', 'max:255', 'string',],
            'nickname' => ['nullable', 'min:1', 'max:255', 'string',],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class,],
            'password' => ['required', 'confirmed', 'min:4', 'max:255', Rules\Password::defaults(),],
        ]);

        $nickname = $validated['nickname'] ?? $validated['given_name'];
        $validated['nickname'] = $nickname;

        $users = User::create($validated);

        return redirect(route('users.index'))
            ->with('success', 'User created');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::whereId($id)->get()->first();

        if ($users) {
            return view('users.show', compact(['users',]))
                ->with('success', 'User found');
        }

        return redirect(route('users.index'))
            ->with('warning', 'User not found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::where('id', '=', $id)->get()->first();

        if ($users) {
            return view('users.update', compact(['users',]))
                ->with('success', 'User found');
        }

        return redirect(route('users.index'))
            ->with('error', 'User not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if (!$request->password) {
            unset($request['password'], $request['password_confirmation']);
        }

        $validated = $request->validate([
            'given_name' => ['required', 'min:1', 'max:255', 'string',],
            'family_name' => ['required', 'min:1', 'max:255', 'string',],
            'nickname' => ['required', 'min:1', 'max:255', 'string',],
            'email' => ['required', 'min:5', 'max:255', 'email', Rule::unique(User::class)->ignore($id),],
            'password' => ['sometimes', 'required', 'min:4', 'max:255', 'string', 'confirmed',],
            'password_confirmation' => ['sometimes', 'required_with:password', 'min:4', 'max:255', 'string',],
        ]);

        $user = User::where('id', '=', $id)->get()->first();

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect(route('users.index', compact(['user'])))
            ->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', '=', $id)->get()->first();

        if (auth()->user()->id !== $user->id) {

            $user->delete();

            return redirect(route('users.index'))
                ->with('success', 'User deleted');

        }
        return back()
            ->with('error', 'Cannot delete yourself');

    }
}
