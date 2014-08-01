<?php
/*
* @package noshare4vids.com
* @author Andreas Loukakis, alou@alou.gr
*/
Route::get('/', array('as' => 'home', 
 'uses' => 'App\Site\Controllers\GetcontentController@index')
);

//normal post route, in case js is disabled
Route::post('vfind', array('before' => 'csrf', 'as' => 'postvid', 
 'uses' => 'App\Site\Controllers\GetcontentController@getUrl')
);

//ajax post route
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
