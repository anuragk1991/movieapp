<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class PersonViewModel extends ViewModel
{
	public $person;
	public $social;
	public $credits;

    public function __construct($person, $social, $credits)
    {
        $this->person = $person;
        $this->social = $social;
        $this->credits = $credits;
    }

    public function person()
    {
    	return collect($this->person)->merge([
    		'age' => \Carbon\Carbon::parse($this->person['birthday'])->age,
    		'dob' => \Carbon\Carbon::parse($this->person['birthday'])->format('M d, Y'),
    		'profile_pic' => $this->person['profile_path'] ? 'https://image.tmdb.org/t/p/w300'.$this->person['profile_path'] : 'https://via.placeholder.com/300x450',

    	]);
    }

    public function social()
    {
    	return collect($this->social)->merge([
    		'twitter' => $this->social['twitter_id']? 'https://twitter.com/'.$this->social['twitter_id']: null,
    		'facebook' => $this->social['facebook_id']? 'https://facebook.com/'.$this->social['facebook_id']: null,
    		'instagram' => $this->social['instagram_id']? 'https://instagram.com/'.$this->social['instagram_id']: null,
    	]);
    }

    public function credits()
    {
    	$castMovies= collect($this->credits)->get('cast');

    	return collect($castMovies)->map(function($movie){
    		if(isset($movie['title'])){
				$title = $movie['title'];
    		}elseif(isset($movie['name'])){
    			$title = $movie['name'];
    		}else{
    			$title = 'Untitled'; 
    		}

    		if(isset($movie['release_date'])){
				$releaseDate = $movie['release_date'];
    		}elseif(isset($movie['fir_air_date'])){
    			$releaseDate = $movie['fir_air_date'];
    		}else{
    			$releaseDate = ''; 
    		}
			return collect($movie)->merge([
				'release_date' => $releaseDate,
				'release_year' => isset($releaseDate)? \Carbon\Carbon::parse($releaseDate)->format('Y') : '--',
				'title' => $title,
				'character' => $movie['character'] ?? '',
			]);
    	})->sortByDesc('release_date');
    }

    public function knownForMovies()
    {
    	$castTitles = collect($this->credits)->get('cast');

    	return collect($castTitles)->where('media_type', 'movie')->sortByDesc('popularity')->take(5)
    		->map(function($movie){
    			return collect($movie)->merge([
    				'poster_path' => $movie['poster_path']? 'https://image.tmdb.org/t/p/w185'.$movie['poster_path']: 'https://via.placeholder.com/185x278',
    				'title' => $movie['title'] ?? 'Untitled' 
    			]);
    		});

    }
}
