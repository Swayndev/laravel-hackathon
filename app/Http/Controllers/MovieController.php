<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Movie;

class UserController extends Controller
{

    public function select()
    {

        $movies = Movie::where('votes_nr', '>', 5000) // AND `votes_nr` > 5000
            ->orderBy('rating', 'desc') // ORDER BY `rating` DESC
            ->where('movie_type_id', 1) // WHERE `movie_type_id` = 1
            ->limit(50) // LIMIT 50
            ->get();

        return view('movie.index', compact('movies'));
    }



    public function show($id = null)
    {
        $movie = Movie::findOrFail($id);

        // dd();

        return view('movie.show', compact('movie'));

        // if (isset($id)) {
        //     return $id;
        // } else {
        //     return 'no id';
        // }
    }




    public function create()
    {
        return view('movie.form');
    }



    public function store(Request $request)
    {
        $movie = new Movie();
        $movie->name = $request->input('name'); // ============
        $movie->year = $request->input('year'); // ===========
        $movie->save();                           // store the data inputed by the user into the DB

        return redirect()->action('MovieController@show', ['id' => $movie->id]);  // ===========
    }



    public function delete($id)
    {
        $movie = Movie::findOrFail($id);

        $movie->delete();

        session()->flash('success_message', 'The comment was successfully saved!');

        return redirect()->action('MovieController@index');
    }
}
