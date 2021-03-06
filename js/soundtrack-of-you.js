var duration = 1; // track the duration of the currently playing track
var state = {};
var defaults = {};
state.uses = 0;

// there might be some defaults coming through from 
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.search);
    if (results == null) return undefined;
    else return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function toTitleCase(str) {
    return str.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

defaults.day = getParameterByName('day');
defaults.month = getParameterByName('month');
defaults.year = getParameterByName('year');


// be warned, this function may make you feel nausious when viewed in the browser
// what has been seen, cannot be unseen
function getTunesOfYou(from, to, success) {

    state.imageloaded = false;
    state.playbackstarted = false;
    state.volume = 1;

    function readytoshow() {
        if (state.abort === true) {

            return;
        }
        if (state.imageloaded === true && state.playbackstarted === true) {
            success();
        }
    }

    function setupPlayer(id) {

        if (state.uses === 0) {
            $('#api').bind('ready.rdio', function () {
                $(this).rdio().play(id);
            });

        } else {
            $('#api').rdio().play(id);
        }



        state.uses = state.uses + 1;

        $('#api').bind('playingTrackChanged.rdio', function (e, playingTrack, sourcePosition) {
            var played = false;
            // 
            var timer = setTimeout(function () {

                state.imageloaded = true;
                readytoshow();
                played = true;
            }, 2000);



            if (playingTrack) {
                duration = playingTrack.duration;
                console.log(playingTrack);
                $('#art').attr('src', playingTrack.icon);

                $('#art').bind('load', function () {

                    clearTimeout(timer);

                    if (played === true) {
                        return false;

                    }
                    state.imageloaded = true;
                    readytoshow();


                });
                $('#track').text(playingTrack.name);
                $('#album').text(playingTrack.album);
                $('#artist').text(playingTrack.artist);
                $('#api').rdio().setVolume(1);
            }
        });
        $('#api').bind('positionChanged.rdio', function (e, position) {
            $('#position').css('width', Math.floor(100 * position / duration) + '%');
        });
        $('#api').bind('playStateChanged.rdio', function (e, playState) {


            if (playState == 0) { // paused
                $('#play').show();
                $('#pause').hide();
            } else {
                $('#play').hide();
                $('#pause').show();
                state.playbackstarted = true;
                readytoshow();
            }



        });
        // this is a valid playback token for localhost.
        // but you should go get your own for your own domain.
        // GBBPnL2m_____2o1a3JjMmJxcDNwZGs5MjNuMnBxdmZ4OXd3dy5oYWNrZGF5cy5jb21Mg2Qy7muLnC90jWLt62al

        var keys = {
            'www.hackdays.com': 'GBBPnL2m_____2o1a3JjMmJxcDNwZGs5MjNuMnBxdmZ4OXd3dy5oYWNrZGF5cy5jb21Mg2Qy7muLnC90jWLt62al',
            'localhost': 'GAlNi78J_____zlyYWs5ZG02N2pkaHlhcWsyOWJtYjkyN2xvY2FsaG9zdEbwl7EHvbylWSWFWYMZwfc='
        }

        $('#api').rdio(keys[document.domain]);

        $('#previous').click(function () {
            $('#api').rdio().previous();
        });
        $('#play').click(function () {
            $('#api').rdio().play();
        });
        $('#pause').click(function () {
            $('#api').rdio().pause();
        });
        $('#next').click(function () {
            $('#api').rdio().next();
        });



    };

    function getTitle(title, artist) {

        $.ajax({
            url: 'http://www.hackdays.com/2012-sydney-music-hack-day/services/rdio/title/?title=' + title + '&artist=' + artist + '&callback=?',
            dataType: 'jsonp',
            success: function (data) {
                console.log('title', data);
                setupPlayer(data.key);

            }
        });

    };

    function makeDateString(dateinfo) {
        return dateinfo.year + '' + dateinfo.month + '' + dateinfo.day;
    }

    console.log('WTF', from, to);

    $.ajax({
        url: 'http://www.hackdays.com/2012-sydney-music-hack-day/services/rovi/search/?from=' + makeDateString(from) + '&to=' + makeDateString(to) + '&callback=?',
        dataType: 'jsonp',
        success: function (data) {
            console.log('search', data);
            getTitle(data.searchResponse.results[0].song.title, data.searchResponse.results[0].song.primaryArtists[0].name);

        }
    });

}

function convertMonth(month) {
    var i, months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

    month = month.toLowerCase();

    for (i = 0; i < months.length; i = i + 1) {
        if (month.indexOf(months[i]) !== -1) {
            break;
        }
    }

    monthnumber = i + 1;
    return monthnumber;
}

function convertDay(day) {
    if (day < 10) {
        day = "0" + day;
    }
    return day + '';
}

function fadeOut(success) {
    var fade, current = state.volume;
    fade = function () {
        if (current < 0) {
            success();
        } else {
            current = current - 0.1;
            $('#api').rdio().setVolume(current);
            setTimeout(fade, 100);
        }
    }
    fade();
}

// takes the date submitted by the user and winds it back by 9 months (ish)
function windbackclock(day, month, year) {
    var wildnight = {};


    // month - 9
    wildnight.month = parseInt(month) - 9;

    console.log('month', month - 9);

    wildnight.day = day;

    // if it's less than 1 then set year back by 1
    if (wildnight.month < 1) {
        wildnight.year = year - 1;
        wildnight.month = 12 + wildnight.month;
    } else {
        wildnight.year = year;
    }

    wildnight.day = convertDay(wildnight.day);
    wildnight.month = wildnight.month;

    if (wildnight.month < 10) {
        wildnight.month = '0' + wildnight.month;
    }

    console.log(wildnight);

    return wildnight;

}


$(document).ready(function () {

    // pre populate form if we have everything we need
    if (defaults.day && defaults.month && defaults.year) {
        $('#day').val(defaults.day);
        $('#month').val(toTitleCase(defaults.month));
        $('#year').val(defaults.year);

    }


    $('#playit').bind('click', function (ev) {

        state.abort = false;
        if (state.uses > 0) {
            $('#api').rdio().pause();
        }
        $('body').addClass('loading');
        ev.preventDefault();
        var dateto = {},
            datefrom = {};


        dateto = windbackclock($('#day').val(), convertMonth($('#month').val()), $('#year').val());

        console.log(dateto);

        datefrom.day = dateto.day;
        datefrom.month = dateto.month - 6;
        datefrom.year = dateto.year;

        if (datefrom.month < 1) {
            datefrom.month = 12 + datefrom.month;
            datefrom.year = dateto.year - 1;
        }

        if (datefrom.month < 10) {
            datefrom.month = '0' + datefrom.month;
        }

        console.log('dateto', convertMonth($('#month').val()));

        getTunesOfYou(datefrom, dateto, function () {
            $('body').removeClass('loading').addClass("zoom").addClass("reveal");
        })

        return false;
    });

    $('.resetlink').bind('click', function (ev) {

        state.abort = true;
        ev.preventDefault();

        $('body').removeClass('loading')

        $('body').removeClass("zoom").removeClass("reveal").removeClass("loading");

        fadeOut(function () {
            $('#api').rdio().pause();

        });

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