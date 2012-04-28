<html>
<head>
	<title>Music Hack Day</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="js/jquery.rdio.min.js"></script>
	
	<script type="text/javascript">
    var duration = 1; // track the duration of the currently playing track


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

    $(document).ready(function() {
	
		$.ajax({
			url: 'http://www.hackdays.com/2012-sydney-music-hack-day/services/rovi/search/?to=<?php echo $_GET["to"] ?>&from=<?php echo $_GET['from']; ?>&callback=?',
			dataType: 'jsonp',
			success : function (data) {
				console.log('search', data);
				getTitle(data.searchResponse.results[0].song.title, data.searchResponse.results[0].song.primaryArtists[0].name);

			}	
		});	
	
	
	    
	});
  </script>
	
	
</head>
<body>



<div id="rdio-playback">	
	<div id="api"></div>
  <img id="art" src="" height="200" width="200" style="float:left;margin-right:20px;">
  <div>
    <div><b>Track: </b><span id="track"></span></div>
    <div><b>Album: </b><span id="album"></span></div>
    <div><b>Artist: </b><span id="artist"></span></div>
    <div><b>Position: </b>
      <span style="display:inline-block;width:200px;border:1px solid black;">
        <span id="position" style="display:inline-block;background-color:#666">&nbsp;</span>
      </span></div>
    <div>
      <button id="previous">&lt;&lt;</button>
      <button id="play">|&gt;</button>
      <button id="pause">||</button>
      <button id="next">&gt;&gt;</button>
    </div>
  </div>
</div>
	
	
	
	


</body>
</html>