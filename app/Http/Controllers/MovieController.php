<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function store(StoreMovieRequest $request): JsonResponse
    {
        $movie = new Movie();
        $movie->user_id = $request->user_id;
        $movie->thumbnail = $request->file('thumbnail')->store('thumbnails');
        $movie->category = json_encode($request->category);
        $movie->year = $request->year;
        $movie->budget = $request->budget;
        $movie->setTranslation('movie_name', 'en', $request->movie_name_en);
        $movie->setTranslation('movie_name', 'ka', $request->movie_name_ka);
        $movie->setTranslation('director', 'en', $request->director_en);
        $movie->setTranslation('director', 'ka', $request->director_ka);
        $movie->setTranslation('description', 'en', $request->description_en);
        $movie->setTranslation('description', 'ka', $request->description_ka);
        $movie->save();

        return response()->json('Movie created Successfully');
    }
    public function show($id): JsonResponse
    {
        $movies = Movie::where('user_id', '=', $id)->get();

        return response()->json($movies);
    }

    public function showMovie($movieId): JsonResponse
    {
        $movie = Movie::where('id', '=', $movieId)->get();

        return response()->json($movie);
    }

    public function update(Movie $movie, StoreMovieRequest $request): JsonResponse
    {
        $movie = Movie::find($request->id);
        $movie->user_id = $request->user_id;
        $movie->thumbnail = $request->file('thumbnail')->store('thumbnails');
        $movie->category = json_encode($request->category);
        $movie->year = $request->year;
        $movie->budget = $request->budget;
        $movie->setTranslation('movie_name', 'en', $request->movie_name_en);
        $movie->setTranslation('movie_name', 'ka', $request->movie_name_ka);
        $movie->setTranslation('director', 'en', $request->director_en);
        $movie->setTranslation('director', 'ka', $request->director_ka);
        $movie->setTranslation('description', 'en', $request->description_en);
        $movie->setTranslation('description', 'ka', $request->description_ka);

        $movie->update();
        return response()->json('Movie updated Successfully');
    }

    public function destroy(Movie $movie, $id)
    {
        $movie = Movie::find($id);
        $movie->delete();
        return response()->json('Movie removed Successfully');
    }
}
