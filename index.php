<html>
<head>
	<title>Music Hack Day</title>
	<script type="text/javascript" src="http://use.typekit.com/fgf3xxn.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="js/jquery.rdio.min.js"></script>
	

	<script type="text/javascript">
    var duration = 1; // track the duration of the currently playing track


	
	function getTunesOfYou(from, to, success) {
		
		function setupPlayer(id) {	
		      $('#api').bind('ready.rdio', function() {
		        $(this).rdio().play(id);
		      });
		      $('#api').bind('playingTrackChanged.rdio', function(e, playingTrack, sourcePosition) {
		        if (playingTrack) {
		          duration = playingTrack.duration;
		console.log(playingTrack);
		          $('#art').attr('src', playingTrack.icon);
		          $('#track').text(playingTrack.name);
		          $('#album').text(playingTrack.album);
		          $('#artist').text(playingTrack.artist);
		        }
		        });
		      $('#api').bind('positionChanged.rdio', function(e, position) {
		        $('#position').css('width', Math.floor(100*position/duration)+'%');
		      });
		      $('#api').bind('playStateChanged.rdio', function(e, playState) {
		        if (playState == 0) { // paused
		          $('#play').show();
		          $('#pause').hide();
		        } else {
		          $('#play').hide();
		          $('#pause').show();
		        }
		      });
		      // this is a valid playback token for localhost.
		      // but you should go get your own for your own domain.
		      $('#api').rdio('GAlNi78J_____zlyYWs5ZG02N2pkaHlhcWsyOWJtYjkyN2xvY2FsaG9zdEbwl7EHvbylWSWFWYMZwfc=');

		      $('#previous').click(function() { $('#api').rdio().previous(); });
		      $('#play').click(function() { $('#api').rdio().play(); });
		      $('#pause').click(function() { $('#api').rdio().pause(); });
		      $('#next').click(function() { $('#api').rdio().next(); });
		
		
		      success();
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

    $(document).ready(function() {
	    $('#playit').bind('click', function (ev) {
		    ev.preventDefault();
		    var dateto = {}, datefrom = {};
		
		    dateto.day = $('#day').val();
		    dateto.month = $('#month').val();
		    dateto.year = $('#year').val();
		
		    datefrom.day = $('#day').val();
		    datefrom.month = $('#month').val();
		    datefrom.year = $('#year').val() - 1;		
			
			getTunesOfYou(datefrom, dateto, function () {
			    $('body').addClass("zoom").addClass("reveal");
			})
			
			return false;
	    });

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
  </script>

	
	<style type="text/css">
		body { margin: 0; padding: 0; background: #fff; font-family: Brevia, sans-serif; overflow: hidden; }
		#container { width: 950px; margin: 35px auto; padding: 30px 0; color: #000; }
		#container header, #container #content { margin: 0 40px 0 414px; }
		header { position: relative; }
		header h1 { font: 92px/82px bello-pro, sans-serif; color: #e1b12b; -webkit-transform:rotate(-12deg); height: 150px; margin-top: 20px;  text-shadow: 1px 1px 0 #fff, 2px 2px 0 rgba(0,0,0,0.3); -webkit-transition: 0.5s all ease-in; }
		header h1 span, header h1 em { color: #fff; -webkit-transition: 0.5s all ease-in; }
		header h1 .the { font-size: 21px; position: absolute; top: -20px; left: -28px; border-radius: 50%; height: 38px; width: 38px; overflow: hidden; color: #fff; background: #8a8a8a; text-align: center; line-height: 44px; text-shadow: none; -webkit-transition: 0.5s all ease-in; }
		header h1 em {position: relative; top: -23px; left: 285px; font-size: 121px; color: #983C5F; padding-right: 40px; -webkit-transition: 0.5s all ease-in; }
		header h1 .of { font-size: 46px; position: relative; left: -150px; top: 40px; text-shadow: none; color: #555; -webkit-transition: 0.5s all ease-in; }
		
		.zoom header h1, .zoom header * { color: #555; text-shadow: -1px -1px 0 #000 !important; -webkit-transition: 0.5s all ease-in; }
		.zoom header h1 span.the { color: #000 !important; background: #555; text-shadow: none !important; -webkit-transition: 0.5s all ease-in; }
		
		#container .content { text-align: center; }
		
		form label { display: none; }
		form input { background: #fff; border: none; border-bottom: 1px dashed #ccc; font-size: 22px; padding: 0 3px 3px 3px; color: #000; display: inline; text-align: center; font-family: Brevia, sans-serif; }
		
		form input::-webkit-input-placeholder { color: #777; }
		form input:-moz-placeholder { color: #777; }
		
		form button { display: block; background: #983C5F; color: #fff; border-radius: 50%; font-size: 22px; border: none; font-family: Bello-Pro, sans-serif; font-weight: 400; height: 65px; width: 65px; line-height: 21px; text-align: center; margin: 30px auto 20px;  -webkit-transition: all ease-out 0.7s; }
		
		form button:hover { background: #000; -webkit-transition: all ease-in 0.2s; }
		
		#intro { margin-left: 40%; }
		.zoom #intro { display: none; }
		
		
		#results { display: block; width: 1px; height: 1px; overflow: hidden; color: #fff; opacity: 0; -webkit-transition: 3s opacity ease-in; color: #222; }
		.zoom #results { display: width: auto; height: auto; overflow: visible; opacity: 1; -webkit-transition: 3s opacity ease-out; }
		
		#rdio-playback #track { text-style: italic; font-weight: 400; }
		#rdio-playback button { display: none; }

		#keyhole { -webkit-transform: scale(0.9); position: absolute; top: 15%; left: 21%; -webkit-transition: ease-in 2s; z-index: -1; }
		.zoom #keyhole { top: 0; left: 25%; -webkit-transform: scale(25); -webkit-transition: ease-in 1.8s;  }
		#circle { width: 220px; border-radius: 220px; background: #111; height: 220px; }
		#rest { height: 0; width: 160px; border-bottom: 220px solid #111; border-left: 30px solid transparent; border-right: 30px solid transparent; margin-top: -44px; }
		
		#coverart { position: relative; }
		#coverart img { box-shadow: 0 0 9px rgba(255,255,255,0.2); }
		#medium { background: url(images/record-lg.png) scroll no-repeat 50% 50%; position: relative; width: 345px; height: 345px;  -webkit-transition: 0.75s all ease-in; position: absolute; z-index: -1; }
		.reveal #medium { left: 190px; -webkit-transform: rotate(65deg); -webkit-transition: 1.5s all ease-out;  }
		
		#results #metadata { width: 400px; margin-left: 510px; padding-top: 70px; color: #fff; }
		#results #metadata div { display: block; }
		#results #track-wrapper { font-family: Bello-Pro; font-size: 32px; line-height: 32px; width: 100%; color: #e1b12b; }
		#results #album { font-style: italics; }
		
	</style>
	
</head>
<body>

<div id="container">

<header>
	<h1><span class="the">The</span> Soundtrack <span class="of">of</span> <em>You</em></h1>
</header>

<div class="content" id="intro">
	<p>When were you were born?</p>
	
	<form id="dateform">
		<label for="day">Day</label>
		<input type="text" id="day" size="3" placeholder="day" />
		
		<label for="day">Month</label>
		<input type="text" id="month" size="12" placeholder="month" />
		
		<label for="day">Year</label>
		<input type="text" id="year" size="4" placeholder="year" />
		
		<button type="submit" id="playit">Play it!</button>
	</form>
</div>



<div id="keyhole">
<div id="circle"></div>
<div id="rest"></div>
</div>




<div class="content" id="results">

<div id="rdio-playback">	
	<div id="api"></div>
<div id="coverart">
  <div id="medium"></div>
  <img id="art" src="" height="350" width="350" style="float:left;margin-right:20px;">
</div>
  <div id="metadata">
    <div id="track-wrapper"><span id="track"></span></div>
 	<div class="artist-wrapper">by <span id="artist"></span></div>
    <div><b>Album: </b><span id="album"></span></div>
    <div>
      <button id="previous">&lt;&lt;</button>
      <button id="play">|&gt;</button>
      <button id="pause">||</button>
      <button id="next">&gt;&gt;</button>
    </div>
  </div>
</div>
	
</div>
	
	
	
</div>

</div>

</body>
</html>