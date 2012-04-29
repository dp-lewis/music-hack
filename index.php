<!DOCTYPE html>
<html>
<head>
	<title>Music Hack Day</title>
	<meta property="og:title" content="Soundtrack to you" />
    <meta property="og:image" content="images/thumbnail.jpg" />
	<meta property="og:description" content="Dare you find out what your parents were listening to when they made you?" />
	
		
	<script type="text/javascript" src="http://use.typekit.com/fgf3xxn.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="js/jquery.rdio.min.js"></script>
	<script src="js/soundtrack-of-you.js"></script>

	
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
		
		form button, #results a.resetlink { display: block; background: #983C5F; color: #fff; border-radius: 50%; font-size: 22px; border: none; font-family: Bello-Pro, sans-serif; font-weight: 400; height: 65px; width: 65px; line-height: 21px; text-align: center; margin: 30px auto 20px;  -webkit-transition: all ease-out 0.7s; }
		
		#results a.resetlink { padding-top: 15px; height: 61px; width: 76px; text-decoration: none;}
		
		form button:hover, #results a.resetlink:hover { background: #000; -webkit-transition: all ease-in 0.2s; }
		#results a.resetlink:hover { background-color: #e1b12b; }
		
		#intro { margin-left: 40%; opacity:1; -webkit-transition: all ease-in 0.4s; }
		.zoom #intro { display: none; opacity: 0;  -webkit-transition: all ease-in 0.4s;  }
		.loading #intro { opacity: 0;  -webkit-transition: all ease-in 0.2s; }
		
		#loading { display: none; opacity: 0;  -webkit-transition: all ease-in 0.4s; margin-top: -120px; margin-left: 40%; color: #777; }
		#loading .resetlink { color: #666; }
		.loading #loading { display: block; opacity: 1;  -webkit-transition: all ease-in 0.8s; }
		#zoom #loading { display: none; opacity: 0;  -webkit-transition: all ease-in 0.4s; }
		
		#results { display: block; width: 1px; height: 1px; overflow: hidden; color: #fff; opacity: 0; -webkit-transition: 3s opacity ease-in; color: #222; }
		.zoom #results { display: width: auto; height: auto; overflow: visible; opacity: 1; -webkit-transition: 3s opacity ease-out; }
		
		#rdio-playback #track { text-style: italic; font-weight: 400; }
		#rdio-playback button { display: none; }

		#keyhole { -webkit-transform: scale(0.9); position: absolute; top: 15%; left: 21%; -webkit-transition: ease-out 0.8s; z-index: -1; }
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
		
		#logos { width: 200px;  height: 30px; position: absolute; bottom: 10px; right: 5%; margin: 0; padding: 0; opacity: 0.7; }
		#logos:hover { opacity: 1; }
		#logos li { list-style: none; margin: 0; padding: 0; display: inline; }
		#logos a#rovi { text-indent: -1000em; background: url(images/rovi-grey.png) scroll no-repeat 0 0; width: 123px; height: 30px; overflow: hidden; display: inline-block; }
		#logos a#rdio { text-indent: -1000em; background: url(images/rdio-grey.png) scroll no-repeat 0 0; width: 63px; height: 30px; overflow: hidden; display: inline-block; }
		
		.resetlink { color: #fff;  }
		
		#audio-controls button {  background: transparent; border: none; text-indent: -1000em; overflow: hidden;  }
		#audio-controls #play { width: 25px; height: 25px; background: url(images/controls.png) scroll no-repeat 8px 5px; opacity: 0.6; }
		#audio-controls #play:hover { opacity: 1; }
		
		#audio-controls #pause { width: 25px; height: 25px; background: url(images/controls.png) scroll no-repeat -20px 5px; opacity: 0.6; }
		#audio-controls #pause:hover { opacity: 1; }
		
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
		
		<label for="month">Month</label>
		<input type="date" id="month" size="6" placeholder="month" />
		
		<label for="year">Year</label>
		<input type="text" id="year" size="4" placeholder="year" />
		
		<button type="submit" id="playit">Look in</button>
	</form>
</div>

<div class="content" id="loading"><p>shhhhh! we're sneaking in.</p><p><a href="index.php" class="resetlink">Start again?</a></p></div>


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
    <div id="audio-controls">
      <button id="previous">&lt;&lt;</button>
      <button id="play">|&gt;</button>
      <button id="pause">||</button>
      <button id="next">&gt;&gt;</button>
    </div>
	<p id="reset"><a href="index.php" class="resetlink">Start again?</a></p>
  </div>
</div>
	
</div>
	
<ul id="logos">
<li><a href="http://www.rovicorp.com/" id="rovi">Powered by Rovi</a></li>
<li><a href="http://www.rdio.com/" id="rdio">Streaming by Rdio</a></li>
</ul>	

</div>

</div>

</body>
</html>