<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class MovieViewModel extends ViewModel
{
	public $movie;

    public function __construct($movie)
    {
        $this->movie = $movie;
    }

    public function movie()
    {
    	return collect($this->movie)->merge([
    		'full_poster_path' => 'https://image.tmdb.org/t/p/w500'.$this->movie['poster_path'],
			'rating_by_10' => $this->movie['vote_average']."/10",
			'release_date_readable' => \Carbon\Carbon::parse($this->movie['release_date'])->format('M d, Y'),
			'genre_str' => collect($this->movie['genres'])->pluck('name')->implode(', '),
			'crew' => collect($this->movie['credits']['crew'])->take(2),
			'cast' => collect($this->movie['credits']['cast'])->take(5),
			'backdrops' => collect($this->movie['images']['backdrops'])->take(8),
    	]);
    }
}
