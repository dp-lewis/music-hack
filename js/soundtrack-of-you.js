var duration = 1; // track the duration of the currently playing track



function getTunesOfYou(from, to, success) {
    var state = {};

    state.imageloaded = false;
    state.playbackstarted = false;

    function readytoshow() {
	    if (state.imageloaded === true && state.playbackstarted === true) {
		    success();		
	    }
    }
			
	function setupPlayer(id) {	

		
		
	      $('#api').bind('ready.rdio', function() {
	        $(this).rdio().play(id);
	      });
	      $('#api').bind('playingTrackChanged.rdio', function(e, playingTrack, sourcePosition) {
	        if (playingTrack) {
	          duration = playingTrack.duration;
	console.log(playingTrack);
	          $('#art').attr('src', playingTrack.icon);
	
	          $('#art').bind('load', function () {
		          state.imageloaded = true;
		          readytoshow();
		
	          });
	          $('#track').text(playingTrack.name);
	          $('#album').text(playingTrack.album);
	          $('#artist').text(playingTrack.artist);
	        }
	        });
	      $('#api').bind('positionChanged.rdio', function(e, position) {
	        $('#position').css('width', Math.floor(100*position/duration)+'%');
	      });
	      $('#api').bind('playStateChanged.rdio', function(e, playState) {
		     state.playbackstarted = true;
		
	        if (playState == 0) { // paused
	          $('#play').show();
	          $('#pause').hide();
	        } else {
	          $('#play').hide();
	          $('#pause').show();
	        }
	        readytoshow();
	        	      
	
	      });
	      // this is a valid playback token for localhost.
	      // but you should go get your own for your own domain.
	      $('#api').rdio('GAlNi78J_____zlyYWs5ZG02N2pkaHlhcWsyOWJtYjkyN2xvY2FsaG9zdEbwl7EHvbylWSWFWYMZwfc=');

	      $('#previous').click(function() { $('#api').rdio().previous(); });
	      $('#play').click(function() { $('#api').rdio().play(); });
	      $('#pause').click(function() { $('#api').rdio().pause(); });
	      $('#next').click(function() { $('#api').rdio().next(); });
	
	

	};

	function getTitle(title, artist) {

		$.ajax({
			url: 'http://www.hackdays.com/2012-sydney-music-hack-day/services/rdio/title/?title=' + title + '&artist=' + artist + '&callback=?',
			dataType: 'jsonp',
			success : function (data) {
				console.log('title', data);
				setupPlayer(data.key);

			}	
		});		

	};

	function makeDateString(dateinfo) {
		return dateinfo.year + '' + dateinfo.month + '' + dateinfo.day;
	}		
	
	$.ajax({
		url: 'http://www.hackdays.com/2012-sydney-music-hack-day/services/rovi/search/?from=' + makeDateString(from) + '&to=' + makeDateString(to) + '&callback=?',
		dataType: 'jsonp',
		success : function (data) {
			console.log('search', data);
			getTitle(data.searchResponse.results[0].song.title, data.searchResponse.results[0].song.primaryArtists[0].name);

		}	
	});		
	
}

function convertMonth(month) {
	var i, months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
	
	month = month.toLowerCase();
	
    for(i = 0; i < months.length; i = i + 1) {
        if (month.search(month.search(month, months[i]))) {
	         break;
        }
    }

    monthnumber = i + 1 ;

    if (monthnumber < 10) {
	    monthnumber = '0' + monthnumber;
    }
	
	return monthnumber + '';
}

function convertDay(day) {
	if (day < 10) {
		day = "0" + day;
	}
	return day + '';
}

$(document).ready(function() {
    $('#playit').bind('click', function (ev) {
	    ev.preventDefault();
	    var dateto = {}, datefrom = {};
	
	    dateto.day = convertDay($('#day').val());
	    dateto.month = convertMonth($('#month').val());
	    dateto.year = $('#year').val();
	
	    datefrom.day = convertDay($('#day').val());
	    datefrom.month = convertMonth($('#month').val());
	    datefrom.year = $('#year').val() - 1;		
		
		getTunesOfYou(datefrom, dateto, function () {
		    $('body').addClass("zoom").addClass("reveal");
		})
		
		return false;
    });

    $('#resetlink').bind('click', function (ev) {
	    ev.preventDefault();
	    $('body').removeClass("zoom").removeClass("reveal");
	    return false;
    })



    /*
	$('#playit').toggle(function() {
		$('body').addClass("zoom").delay(3500).addClass("reveal");
		return false;
	}, function () {
		$('body').removeClass("zoom").removeClass("reveal");
		return false;
	});
	*/

});
