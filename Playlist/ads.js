/**
 * Copyright 2014 Google Inc.
 */
"use strict"
var player;
var wrapperDiv;
var linearAdPlaying = false;
var adblocked = '';
var cos_playlist = jsdata;
var videoIndex = 0;

if (window.canRunAds === undefined) {
        adblocked = 'yes';
} else {
        adblocked = 'no';
}
var vjsOptions = {
        autoplay: true,
        muted: true,
        debug: true
};
player = videojs('content_video', vjsOptions);
var imaOptions = {
        id: 'content_video',
        //adTagUrl: 'https://googleads.g.doubleclick.net/pagead/ads?client=ca-video-pub-6804475519558550&slotname=3729725924&ad_type=video&description_url=https%3A%2F%2Fconsequenceofsound.net&max_ad_duration=30000&videoad_start_delay=0&vpmute=1&vpa=1'
		adTagUrl: 'https://pubads.g.doubleclick.net/gampad/ads?sz=1280x720|400x300|640x480&iu=/134312942/COS_Video_Test&ciu_szs=300x250&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=[referrer_url]&description_url=[description_url]&correlator=[timestamp]'
};
player.ima(imaOptions);
var adsRequest = new google.ima.AdsRequest();
adsRequest.adTagUrl = imaOptions.adTagUrl;

	if (navigator.userAgent.match(/iPhone/i) ||
			navigator.userAgent.match(/iPad/i) ||
			navigator.userAgent.match(/Android/i)) {
			startEvent = 'touchend';
	}

	wrapperDiv = document.getElementById('content_video');
	wrapperDiv.addEventListener(startEvent, initAdDisplayContainer);
     
function initPlayer() {
        console.log(" init function >>>", videoIndex);
  		playVideo(0);	
}

function playVideo(videoIndex){
	
        console.log(" videoIndex >>>", videoIndex);
        player.ima.requestAds(adsRequest);
	
        // code to update src,type,poster on loop
        var videoSrc = cos_playlist[videoIndex].src;
        var videoType = cos_playlist[videoIndex].type;
        var videoPoster = cos_playlist[videoIndex].poster;
        player.src({
                src: videoSrc,
                type: videoType
        });
	    player.poster(videoPoster);

}

//player code starts
player.on("adsready", function() {
        console.log(">>> ads ready event started");
        player.ima.addEventListener(google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED, function() {
                console.log(">>> Content paused for ad");
                linearAdPlaying = true;
        });
        player.ima.addEventListener(google.ima.AdEvent.Type.STARTED, function() {
                console.log(">>>> Ad Event Started");
        });
        player.ima.addEventListener(google.ima.AdEvent.Type.ALL_ADS_COMPLETED, function() {
                console.log(">>> Completed ad");
                linearAdPlaying = false;
        });
        player.ima.addEventListener(google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED, function() {
                console.log(">>> Video content starts playing");
                linearAdPlaying = false;
        });
        player.ima.addEventListener(google.ima.AdEvent.Type.ERROR, function() {
                console.log(">>> error in ad loading");
                linearAdPlaying = false;
        });
});
player.on('ended', function() {
        // auto advance to next video on video end
        loadNext();
});
player.on('adserror', function() {
        console.log('ad stoped by above error');
        linearAdPlaying = false;
});

// api fns
function loadNext() {
        console.log(">>> Load Next Video");
        if (!linearAdPlaying) {
                videoIndex++;
                if (videoIndex >= cos_playlist.length) {
                        videoIndex = 0;
                }
                playVideo(videoIndex);
        }
}

function loadPrev() {
        console.log(">>> Load Prev Video");
        if (!linearAdPlaying) {
                videoIndex--;
                if (videoIndex < 0) {
                        videoIndex = cos_playlist.length - 1;
                }
                playVideo(videoIndex);
        }
}

function initAdDisplayContainer() {
        player.ima.initializeAdDisplayContainer();
        wrapperDiv.removeEventListener(startEvent, initAdDisplayContainer);
}

var startEvent = 'click';
initPlayer();
initAdDisplayContainer();