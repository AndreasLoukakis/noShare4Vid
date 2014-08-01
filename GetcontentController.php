<?php namespace App\Site\Controllers;


class GetcontentController extends \BaseController {

	public function index(){
		
		$served = \App\Models\Countq::first();
		return \View::make('site::content.index')->with('served', $served->count);

	}

	public function getAjaxUrl(){
		$vurl = \Input::get('vidurl');
		if ( $vurl && $vurl != '' && substr($vurl, 0, 4) == 'http') {
			require __DIR__.'path/to/simple_html_dom.php';
			// Create DOM from URL or file
			$html = file_get_html($vurl);
			
			// Find all videos
			$videos = $html->find('div.youtubeblocker');
			
			$answer = array();
			$answer['vidids'] = array();
			$answer['iframes'] = array();
			foreach($videos as $element) {
				$answer['vidids'][] = $element->{'data-videoid'};
			}
			if (count($answer['vidids']) > 0) {
				$answer['type'] = 'hidden';
			} else {
				$answer['type'] = 'other';
				$iframes = $html->find('iframe');
				foreach($iframes as $ele) {
					$answer['iframes'][] = $ele->src;
				}
			}

			$countq = \App\Models\Countq::first();
			$newcount = $countq->count + 1;
			$countq->count = $newcount;
			$countq->save();
			$answer['count'] = $newcount;

			echo json_encode($answer);

		} else { echo 'invalid post'; }
	}

	public function getUrl(){
		$vurl = \Input::get('vidurl');
		if ( $vurl && $vurl != '' && substr($vurl, 0, 4) == 'http') {
			require __DIR__.'path/to/simple_html_dom.php';
			// Create DOM from URL or file
			$html = file_get_html($vurl);
			
			// Find all videos
			$videos = $html->find('div.youtubeblocker');
			$vidids = array();
			foreach($videos as $element) {
				$vidids[] = $element->{'data-videoid'};
			}
			//count vidids & regex if none?
			//
			
			$countq = \App\Models\Countq::first();
			$newcount = $countq->count + 1;
			$countq->count = $newcount;
			$countq->save();

			return \View::make('site::content.index')->with('videos', $vidids)->with('served', $newcount);;
		} else {
			return \View::make('site::content.index')->withErrors('Invalid URL');
		}
	}

	public function contactPost() {
		$validation = new \App\Services\Validators\ContactValidator;
		$v = $validation->passes();
		if ($v){
			$email = \Input::get('email');
			$name = \Input::get('name');
			$text = \Input::get('message');
			$sendMail = \Mail::send('site::email.contact', 
				array(
					'email' => $email,
					'name' => $name,
					'text' => $text
				), 
				function($message) use ($email) {
				  	$message->from('hey@noshare4vid.com', 'NS4V');
				  	$message->to(array('alou@alou.gr'))->subject('Contact from NS4V');
				}
			);
			if ($sendMail == 0) {
				return \Redirect::back()->with('success', 'Oops, the pigeons are all gone, cant send your message now. Please try again later.');
			}
			return \Redirect::route('home')->with('success', '<strong>Thanks!</strong> a pigeon was just released, carrying your message.');
		}
		return \Redirect::back()->withInput()->withErrors($validation->errors);
	}

}
