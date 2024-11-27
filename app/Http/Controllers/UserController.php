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
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        if ($keyword) {
            $users = User::where('given_name', 'like', "%{$keyword}%")
                ->orWhere('family_name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->paginate(5);
        } else {
            $users = User::paginate(5);
        }

        return view('users.index', compact(['users']));
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

        $validated['creator_id'] = auth()->user()->id;

        User::create($validated);

        return redirect(route('users.index'))->with('success', 'User created');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::find($id);

        if (!$users){
            return redirect(route('users.index'))
                ->with('error', 'User Not Found');
        }

        if ($users->id == auth()->user()->id || $users->creator_id == auth()->user()->id) {
            return view('users.show', compact(['users',]));
        }


        return redirect(route('users.index'))
            ->with('error', 'You Are Not Authorized To View This User!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::find($id);

        if (!$users){
            return redirect(route('users.index'))
                ->with('error', 'User Not Found');
        }

        if ($users->id == auth()->user()->id || $users->creator_id == auth()->user()->id) {
            return view('users.update', compact(['users',]));
        }

        return redirect(route('users.index'))
            ->with('error', 'You Are Not Authorized To Edit This User!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = User::find($id);

        if (!$users){
            return redirect(route('users.index'))
                ->with('error', 'User Not Found');
        }

        if ($users->id !== auth()->user()->id && $users->creator_id !== auth()->user()->id) {
            return redirect(route('users.index'))
                ->with('error', 'Unauthorized access');
        }

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

        $users->fill($validated);

        if ($users->isDirty('email')) {
            $users->email_verified_at = null;
        }

        $users->save();

        return redirect(route('users.index', compact(['users'])))
            ->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user){
            return redirect(route('users.index'))
                ->with('error', 'User Not Found');
        }

        if ($user->id == auth()->user()->id || $user->creator_id == auth()->user()->id) {
            $user->delete();

            if ($user->id == auth()->user()->id) {
                return redirect(route('login'))->with('success', 'Your Account Has Been Deleted');
            }
            return redirect(route('users.index'))->with('success', 'User Deleted');
        }

        return redirect(route('users.index'))
            ->with('error', 'You Are Not Authorized To Delete This User!');

    }
}
