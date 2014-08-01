/* 
 * @package noshare4vids.com
 * @author Andreas Loukakis, alou@alou.gr
 * 
 */

jQuery(document).ready(function($) {
	function getvideo(formdata){
		$.ajax({
			url:'/a/vfind',
			type:'POST',
			data: formdata,
			dataType:'json',
			cache:false,
			success:function(data){
				//console.log(data);
				showResults(data);
			},
			error:function(jxhr){
				//console.log(jxhr);
			}
		});
	}
	
	function showResults(vids) {
		$('.video').remove();
		//are the vids hidden?
		if (vids.type === 'hidden') {
			$('#counter').text(vids.count);
			$('#videos').append('<h3 class="video">Found ' + vids.vidids.length + ' videos!</h3>');
			for (var i = 0;i < vids.vidids.length; i++){
				$('#videos').append('<div class="video"><iframe width="700" height="500" src="//www.youtube.com/embed/'+ vids.vidids[i] + '" frameborder="0" allowfullscreen></iframe></div>');
			}
		} else {
			$('#videos').append('<h3 class="video">No hidden videos there</h3>');
			if (vids.iframes.length > 0){
				$('#videos').append('<h3 class="video text-left"><small>but there are video links you might want to check:</small></h3>');
				$('#videos').append('<ul class="video" style="text-align:left"></ul>');
				for (var c = 0;c < vids.iframes.length; c++){
					if (vids.iframes[c].indexOf('yout') > 0 || vids.iframes[c].indexOf('vimeo') > 0) {
						$('ul.video').append('<li><span class=""></span> <a href="' + vids.iframes[c] + '">' + vids.iframes[c] +'</a></li>');
					}
				}
			}
		}
	}
	
	$('#searchvids').on('submit', function(e){
		e.preventDefault();
		var vurl = $('input[name="vidurl"]').val();
		if (vurl !== '' && vurl.substring(0,4) === 'http'){
			var formdata = $('form.searchvids').serialize();
			getvideo(formdata);
		} else { alert('Invalid URL'); }
	});

	var wh = $(window).height();
	$('.mainc').css('min-height', wh - 200 + 'px');
	$('.footer').css({'opacity': '0', 'display':'block'}).animate({'opacity': '1'}, 400);
});
