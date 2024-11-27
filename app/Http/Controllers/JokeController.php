<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                ->orWhere('category', 'LIKE', "%$keyword%")
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
            return redirect()->route('joke.index')
                ->with('error', 'Joke could not be found.');
        }
        return view('jokes.show', compact(['joke']));
    }

    /**
     * Show the form for creating a new joke
     */
    public function create()
    {
        if (auth()->check()){
            return view('jokes.create');
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
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'content' => ['required', 'string', 'max:255', 'string'],
            'category' => ['required', 'string', 'min:1', 'max:255'],
            'tags' => ['required', 'string', 'min:1', 'max:255'],
        ]);

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

    if (auth()->check() && $joke->author_id === auth()->user()->id) {
        return view('jokes.update', compact('joke'));
    } else {
        return redirect(route('jokes.index'))->with('error', 'You are not authorized to edit this joke.');
    }
}

    /**
     * Update the specified joke in the database
     */
    public function update(Request $request, Joke $joke)
    {
        if (auth()->check() && $joke->author_id === auth()->user()->id) {
            $validated = $request->validate([
                'title' => ['required', 'string', 'min:1', 'max:255'],
                'content' => ['required', 'string', 'min:1', 'max:255'],
                'category' => ['required', 'string', 'min:1', 'max:255'],
                'tags' => ['required', 'string', 'min:1', 'max:255'],
            ]);
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
    public function destroy(Joke $joke)
    {
        if (auth()->check() && $joke->author_id === auth()->user()->id) {
            $joke->delete();

            return redirect()->route('jokes.index')
                ->with('success', 'Joke deleted successfully!');
        } else {
            return redirect()->route('jokes.index')->with('error', 'You are not authorized to delete this joke.');
        }
    }
}
