<?php
// Home page
Route::get('/', array('as' => 'home', 
 'uses' => 'App\Site\Controllers\GetcontentController@index')
);

Route::post('vfind', array('before' => 'csrf', 'as' => 'postvid', 
 'uses' => 'App\Site\Controllers\GetcontentController@getUrl')
);

Route::post('a/vfind', array('before' => 'csrf', 'as' => 'ajaxpostvid', 
 'uses' => 'App\Site\Controllers\GetcontentController@getAjaxUrl')
);

Route::get('/contact', array('as' => 'contact', function(){
 		return View::make('site::content.contact');
	})
);

Route::post('/contact', array('as' => 'contactPost', 'before' => 'csrf',
 'uses' => 'App\Site\Controllers\GetcontentController@contactPost')
);
