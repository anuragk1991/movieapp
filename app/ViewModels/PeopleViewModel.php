<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class PeopleViewModel extends ViewModel
{
	public $page;
	public $next = null;
	public $previous  = null;
	public $popularPeople;

    public function __construct($popularPeople, $page)
    {
    	$this->page = $page;
        $this->popularPeople = $popularPeople;
    	$this->previous();
    	$this->next();
    }

    public function popularPeople()
    {
    	return collect($this->popularPeople)->map(function($person){
    		$known_for = collect($person['known_for']);
    		return collect($person)->merge([
    			
	    		'full_image' => ($person['profile_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$person['profile_path']: 'https://ui-avatars.com/api/?size=235&name='.$person['name'] ,
	    		'known_for_str' => $known_for->where('media_type', 'movie')->pluck('title')->union($known_for->where('media_type', 'tv')->pluck('name'))->implode(', ')

	    	]);
    	});
    }

    public function previous()
    {
    	return $this->page > 1? $this->page - 1: null;
    }

    public function next()
    {
    	return $this->page < 500 ? $this->page + 1: null; 
    }
}
