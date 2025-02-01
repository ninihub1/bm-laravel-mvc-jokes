<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /*
     * Display a list of users
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Administrator')) {
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

        return redirect(route('static.home'))
            ->with('error', 'You are not authorized to view users!');
    }

    /*
     * Show form to create a new user
     */
    public function create()
    {
        if (auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Administrator')) {
            return view('users.create');
        }

        return redirect(route('users.index'))
            ->with('error', 'You are not authorized to create users!');
    }

    /*
     * Store new user to the database
     */
    public function store(Request $request)
    {
        if (auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Administrator')) {
            $validated = $request->validate([
                'given_name' => ['required', 'min:1', 'max:255', 'string'],
                'family_name' => ['required', 'min:1', 'max:255', 'string'],
                'nickname' => ['nullable', 'min:1', 'max:255', 'string'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', 'min:4', 'max:255', Rules\Password::defaults()],
            ]);

            $nickname = $validated['nickname'] ?? $validated['given_name'];
            $validated['nickname'] = $nickname;
            $validated['creator_id'] = auth()->user()->id;

            User::create($validated);

            return redirect(route('users.index'))->with('success', 'User created');
        }

        return redirect(route('users.index'))
            ->with('error', 'You are not authorized to create users!');
    }

    /*
     * Display the details of the user
     */
    public function show(string $id)
    {
        $users = User::find($id);

        if (!$users) {
            return redirect(route('users.index'))
                ->with('error', 'User Not Found');
        }

        if ($users->id == auth()->user()->id || $users->creator_id == auth()->user()->id || auth()->user()->hasRole('Superuser')) {
            return view('users.show', compact(['users']));
        }

        return redirect(route('users.index'))
            ->with('error', 'You Are Not Authorized To View This User!');
    }

    /*
     * Show the form to edit a user
     */
    public function edit(string $id)
    {
        $users = User::find($id);

        if (!$users) {
            return redirect(route('users.index'))
                ->with('error', 'User Not Found');
        }

        if (auth()->user()->hasRole('Superuser') && !$users->hasRole('Superuser')) {
            return view('users.update', compact(['users']));
        }

        if (auth()->user()->hasRole('Administrator') && !$users->hasRole('Superuser') && !$users->hasRole('Administrator')) {
            return view('users.update', compact(['users']));
        }

        if ($users->id == auth()->user()->id || $users->creator_id == auth()->user()->id) {
            return view('users.update', compact(['users']));
        }

        return redirect(route('users.index'))
            ->with('error', 'You Are Not Authorized To Edit This User!');
    }

    /*
     * Updated the details of a user
     */
    public function update(Request $request, string $id)
    {
        $users = User::find($id);

        if (!$users) {
            return redirect(route('users.index'))
                ->with('error', 'User Not Found');
        }

        if ($users->id !== auth()->user()->id && $users->creator_id !== auth()->user()->id && !auth()->user()->hasRole('Superuser')) {
            return redirect(route('users.index'))
                ->with('error', 'Unauthorized access');
        }

        if ($users->hasRole('Superuser') || $users->hasRole('Administrator')) {
            return redirect(route('users.index'))
                ->with('error', 'You are not allowed to update this user!');
        }

        if (auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Administrator')) {
            if (!$request->password) {
                unset($request['password'], $request['password_confirmation']);
            }

            $validated = $request->validate([
                'given_name' => ['required', 'min:1', 'max:255', 'string'],
                'family_name' => ['required', 'min:1', 'max:255', 'string'],
                'nickname' => ['required', 'min:1', 'max:255', 'string'],
                'email' => ['required', 'min:5', 'max:255', 'email', Rule::unique(User::class)->ignore($id)],
                'password' => ['sometimes', 'required', 'min:4', 'max:255', 'string', 'confirmed'],
                'password_confirmation' => ['sometimes', 'required_with:password', 'min:4', 'max:255', 'string'],
            ]);

            $users->fill($validated);

            if ($users->isDirty('email')) {
                $users->email_verified_at = null;
            }

            $users->save();

            return redirect(route('users.index', compact(['users'])))
                ->with('success', 'User updated');
        }

        return redirect(route('users.index'))
            ->with('error', 'You are not authorized to update users!');
    }

    /**
     * Remove the specified user from database.
     */
    public function destroy(string $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return redirect(route('users.index'))->with('error', 'User Not Found');
        }

        // Check if the user has a higher or equal role
        if ($user->hasRole('Superuser') || $user->hasRole('Administrator')) {
            if (auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Staff')) {
                return redirect(route('users.index'))
                    ->with('error', 'You are not authorized to delete this user!');
            }
        }

        // Superuser cannot delete themselves
        if ($user->id == auth()->user()->id && auth()->user()->hasRole('Superuser')) {
            return redirect(route('users.index'))->with('error', 'You cannot remove yourself from the system!');
        }

        // Perform soft delete
        if ($user->trashed()) {
            return redirect(route('users.index'))->with('error', 'User is already trashed!');
        }

        $user->delete();

        return redirect(route('users.index'))->with('success', 'User has been trashed');
    }

    public function trashed()
    {
        if (!auth()->check() || auth()->user()->hasRole('Client')) {
            return redirect(route('static.home'))
                ->with('error', 'You are not authorized to view this page!');
        }

        if (auth()->user()->hasRole('Superuser')) {
            $deletedUsers = User::onlyTrashed()->paginate(10);
        } elseif (auth()->user()->hasRole('Administrator')) {
            $deletedUsers = User::onlyTrashed()
                ->whereDoesntHave('roles', function ($query) {
                    $query->whereIn('name', ['Administrator', 'Superuser']);
                })
                ->paginate(10);
        } elseif (auth()->user()->hasRole('Staff')) {
            $deletedUsers = User::onlyTrashed()
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Client');
                })
                ->paginate(10);
        } else {
            $deletedUsers = User::onlyTrashed()
                ->where('id', auth()->user()->id)
                ->paginate(10);
        }

        return view('users.trashed', compact('deletedUsers'));
    }




    public function restore(string $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user || !$user->trashed()) {
            return redirect(route('users.index'))->with('error', 'User not found or is not trashed');
        }

        if (auth()->user()->hasRole('Staff')) {
            if ($user->hasRole('Administrator') || $user->hasRole('Superuser')) {
                return redirect(route('users.index'))
                    ->with('error', 'You are not authorized to restore this user!');
            }
        }

        $user->restore();

        return redirect(route('users.index'))->with('success', 'User restored successfully');
    }

    /**
     * Permanently delete a user from the system.
     */
    public function forceDelete(string $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user || !$user->trashed()) {
            return redirect(route('users.index'))->with('error', 'User not found or is not trashed');
        }

        if (auth()->user()->hasRole('Staff')) {
            if ($user->hasRole('Staff') || $user->hasRole('Administrator') || $user->hasRole('Superuser')) {
                return redirect(route('users.index'))
                    ->with('error', 'You are not authorized to permanently delete this user!');
            }
        }

        if (auth()->user()->hasRole('Administrator')) {
            if ($user->hasRole('Administrator') || $user->hasRole('Superuser')) {
                return redirect(route('users.index'))
                    ->with('error', 'You are not authorized to permanently delete this user!');
            }
        }

        if ($user->id == auth()->user()->id) {
            return redirect(route('users.index'))->with('error', 'You cannot remove yourself!');
        }

        $user->forceDelete();

        return redirect(route('users.index'))->with('success', 'User permanently deleted');
    }
}
