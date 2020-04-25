<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class MoviesViewModel extends ViewModel
{
	public $generes;
	public $popularMovies;
	public $nowPlayingMovies;

    public function __construct($popularMovies, $nowPlayingMovies, $genres)
    {
        $this->genres = $genres;
        $this->popularMovies = $popularMovies;
        $this->nowPlayingMovies = $nowPlayingMovies;
    }

    public function nowPlayingMovies(){
    	return $this->formatMovies($this->nowPlayingMovies);
    }

    public function popularMovies(){
    	return $this->formatMovies($this->popularMovies);
    }

    private function formatMovies($movies){
    	return collect($movies)->map(function($movie){
    		
    		$genre_str = collect($movie['genre_ids'])->mapWithKeys(function($value){
    			return [$value => $this->genres()->get($value)];
    		})->implode(',');
        	
    		return collect($movie)->merge([
    			'full_poster_path' => 'https://image.tmdb.org/t/p/w500'.$movie['poster_path'],
    			'rating_by_10' => $movie['vote_average']."/10",
    			'release_date_readable' => \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y'),
    			'genre_str' => $genre_str
    		]);
    	});
    }

    public function genres(){
    	return  collect($this->genres)->mapWithKeys(function($genre){
            return [$genre['id'] => $genre['name']];
        });
    }
}
