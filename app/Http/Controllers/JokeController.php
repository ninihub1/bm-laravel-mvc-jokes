<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Joke;

class JokeController extends Controller
{
    /**
     * Display listing of the jokes
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        if ($keyword) {
            $jokes = Joke::where('content', 'LIKE', "%$keyword%")
                ->orWhere('title', 'LIKE', "%$keyword%")
                ->orWhere('tags', 'LIKE', "%$keyword%")
                ->paginate(5);
        } else {
            $jokes = Joke::paginate(5);
        }

        return view('jokes.index', compact(['jokes'], ['keyword']));
    }

    /**
     * Display the specified joke
     */
    public function show(string $id)
    {
        $joke = Joke::find($id);

        if (!$joke){
            return redirect()->route('jokes.index')
                ->with('error', 'Joke could not be found.');
        }
        return view('jokes.show', compact(['joke']));
    }

    /**
     * Show the form for creating a new joke
     */
    public function create()
    {
        if (auth()->check() && auth()->user()->hasRole(['Superuser', 'Administrator', 'Client'])) {
            $categories = Category::all();
            return view('jokes.create', compact(['categories']));
        } else {
            return redirect()->route('login')
                ->with('error', 'You need to login first');
        }
    }

    /**
     * Store a newly created joke in the database
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasRole(['Superuser', 'Administrator', 'Client'])) {
            return redirect()->route('jokes.index')
                ->with('error', 'You do not have permissions to add jokes.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'content' => ['required', 'string', 'max:255', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'tags' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        $validated['category_id'] = (int) $validated['category_id'];

        $validated['author_id'] = auth()->user()->id;

        Joke::create($validated);

        return redirect()->route('jokes.index')
            ->with('success', 'Joke added successfully!');
    }

    /**
     * Show the form for editing the specified joke
     */
    public function edit(string $id)
    {
        $joke = Joke::find($id);

        if (!$joke) {
            return redirect(route('jokes.index'))->with('error', 'Joke not found!');
        }


        if (auth()->check() && (auth()->user()->hasRole(['Superuser', 'Administrator', 'Staff']) || $joke->author_id === auth()->user()->id)) {
            $categories = Category::all();
            return view('jokes.update', compact(['joke'], ['categories']));
        } else {
            return redirect(route('jokes.index'))->with('error', 'You are not authorized to edit this joke.');
        }
    }

    /**
     * Update the specified joke in the database
     */
    public function update(Request $request, string $id)
    {
        $joke = Joke::find($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'content' => ['required', 'string', 'min:1', 'max:255'],
            'category_id' => ['required', 'exists:categories,id', 'integer'],
            'tags' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        $validated['category_id'] = (int) $validated['category_id'];
        $validated['author_id'] = auth()->user()->id;

        if (auth()->check() && (auth()->user()->hasRole(['Superuser', 'Administrator', 'Staff']) || $joke->author_id === auth()->user()->id)) {
            $joke->update($validated);

            return redirect()->route('jokes.index')
                ->with('success', 'Joke updated successfully!');
        } else {
            return redirect(route('jokes.index'))
                ->with('error', 'You are not authorized to edit this joke.');
        }
    }

    /**
     * Remove the specified joke from the database
     */
    public function destroy(string $id)
    {
        $joke = Joke::withTrashed()->find($id);

        if (!$joke) {
            return redirect(route('jokes.index'))->with('error', 'Joke Not Found');
        }

        if ($joke->trashed()) {
            return redirect(route('jokes.index'))->with('error', 'Joke is already trashed!');
        }

        if (auth()->user()->hasRole('Client') && $joke->author_id !== auth()->id()) {
            return redirect(route('jokes.index'))->with('error', 'You can only delete your own jokes!');
        }

        $joke->delete();

        return redirect(route('jokes.index'))->with('success', 'Joke has been trashed');
    }

    public function trashed()
    {
        if (auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Administrator')) {
            $trashedJokes = Joke::onlyTrashed()->paginate(10);
        } elseif (auth()->user()->hasRole('Staff')) {
            $trashedJokes = Joke::onlyTrashed()->whereHas('user', function ($query) {
                $query->where('role', 'Client');
            })->paginate(10);
        } else {
            $trashedJokes = Joke::onlyTrashed()->where('author_id', auth()->id())->paginate(10);
        }

        return view('jokes.trashed', compact('trashedJokes'));
    }

    public function restore(string $id)
    {
        $joke = Joke::withTrashed()->find($id);

        if (!$joke || !$joke->trashed()) {
            return redirect(route('jokes.index'))->with('error', 'Joke not found or is not trashed');
        }

        if (auth()->user()->hasRole('Client') && $joke->author_id !== auth()->id()) {
            return redirect(route('jokes.index'))->with('error', 'You can only restore your own jokes!');
        }

        if (auth()->user()->hasRole('Staff') && $joke->user->hasRole('Staff')) {
            return redirect(route('jokes.index'))->with('error', 'You are not authorized to restore this joke!');
        }

        $joke->restore();

        return redirect(route('jokes.index'))->with('success', 'Joke restored successfully');
    }

    public function forceDelete(string $id)
    {
        $joke = Joke::withTrashed()->find($id);

        if (!$joke || !$joke->trashed()) {
            return redirect(route('jokes.index'))->with('error', 'Joke not found or is not trashed');
        }

        if (auth()->user()->hasRole('Client') && $joke->author_id !== auth()->id()) {
            return redirect(route('jokes.index'))->with('error', 'You can only permanently delete your own jokes!');
        }

        if (auth()->user()->hasRole('Staff') && $joke->user->hasRole('Staff')) {
            return redirect(route('jokes.index'))->with('error', 'You cannot permanently delete another staff member\'s joke!');
        }

        if (auth()->user()->hasRole('Administrator') && $joke->user->hasRole('Administrator')) {
            return redirect(route('jokes.index'))->with('error', 'You cannot permanently delete another administrator\'s joke!');
        }

        $joke->forceDelete();

        return redirect(route('jokes.index'))->with('success', 'Joke permanently deleted');
    }
}
