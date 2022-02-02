<?php

namespace App\Http\Controllers;

use App\Models\MovieRating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MovieRatingResource;
use App\Http\Resources\MovieRatingCollection;

class MovieRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(new MovieRatingCollection(MovieRating::all()), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovieRating  $movieRating
     * @return \Illuminate\Http\Response
     */
    public function show(MovieRating $movieRating)
    {
        return response()->json(new MovieRatingResource($movieRating), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->only([
            'movie_rating', 'movie_id', 'user_id'
        ]),[
            'movie_rating' => 'required|integer|between:1,5',
            'movie_id' => 'required|integer|between:0, 1000000',
            'user_id' => 'required|integer|between:0, 1000000',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        };
        $movieRating=MovieRating::create($request->only([
            'movie_rating', 'movie_id', 'user_id'
        ]));

        return response()->json(new MovieRatingResource($movieRating), Response::HTTP_CREATED);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MovieRating  $movieRating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MovieRating $movieRating)
    {
        $movieRating->update($request->only([
            'movie_rating', 'movie_id', 'user_id'
        ]));
        return response()->json(new MovieRatingResource($movieRating), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovieRating  $movieRating
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovieRating $movieRating)
    {
        $movieRating->delete();

        return response()->json(([
            'Message'=>'Campo eliminato correttamente', "Response Status" => Response::HTTP_NO_CONTENT
        ]));
    }

    public function getMovieRatingsById($id)
    {
        return response()->json(new MovieRatingCollection(MovieRating::where('id', $id)->get()), Response::HTTP_OK);
    }

    public function getMovieRatingsByUserId($user_id)
    {
        return response()->json(new MovieRatingCollection(MovieRating::where('user_id', $user_id)->get()), Response::HTTP_OK);
    }

    public function getMovieRatingsByUserAndMovieId($movie_id, $user_id)
    {
        return response()->json(new MovieRatingCollection(MovieRating::where([['movie_id', $movie_id], ['user_id', $user_id]])
        ->get()), Response::HTTP_OK);
    }

}
