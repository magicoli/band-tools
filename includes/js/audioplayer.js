// https://www.codeproject.com/Articles/5164334/Create-Music-Playlist-with-HTML5-and-JavaScript
//

var _currentPlayerClass = null;
var _currentListClass = null;
var _currentTrack = 1;
// var _currentAudio = document.getElementById("audio");
var _trackLoaded = false;

var _elements = {
  audio: document.querySelector("audio").children[0],
  players: document.getElementsByTagName("audio"),
  playerButtons: {
    // largeToggleBtn: document.querySelector(".large-toggle-btn"),
    // nextTrackBtn: document.querySelector(".next-track-btn"),
    // previousTrackBtn: document.querySelector(".previous-track-btn"),
    smallToggleBtn: document.getElementsByClassName("small-toggle-btn")
  },
  // progressBar: document.querySelector(".progress-box"),
  playLists: document.getElementsByClassName("playlist"),
  playListRows: document.getElementsByClassName("playlist-row"),
  // playListRows: document.querySelector(".playlist-row"),
  trackInfoBox: document.querySelector(".track-info-box")
};
var _currentList = _elements.playLists[0];

for (var i = 0; i < _elements.playListRows.length; i++) {
  var smallToggleBtn = _elements.playerButtons.smallToggleBtn[i];
  // var playListLink = _elements.playListRows[i].children[2].children[0];
  var playListLink = _elements.playListRows[i].querySelector('.playlist-track');

  //Playlist link clicked.
  playListLink.addEventListener("click", function(e) {
    e.preventDefault();
    var selectedTrack = parseInt(this.getAttribute("data-play-track"));
    var selectedPlayerClass = 'audio-' + this.getAttribute("data-play-list");
    var selectedListClass = 'playlist-' + this.getAttribute("data-play-list");
    console.log('found list ' + selectedPlayerClass + ' track ' + selectedTrack + ' id ' + this.getAttribute("data-play-list"));

    if (selectedTrack !== _currentTrack || selectedPlayerClass !== _currentPlayerClass) {
      _resetPlayStatus();

      _currentTrack = null;
      _currentPlayerClass = null;
      _currentListClass = null;
      // _currentList = null;
      _trackLoaded = false;
    }

    if (_trackLoaded === false) {
      _currentTrack = parseInt(selectedTrack);
      _currentPlayerClass = selectedPlayerClass;
      _currentListClass = selectedListClass;
      _currentList = document.getElementById(_currentListClass);

      _setTrack();
    } else {
      _playBack(this);
    }
  }, false);

  //Small toggle button clicked.
  smallToggleBtn.addEventListener("click", function(e) {
    e.preventDefault();
    var selectedTrack = parseInt(this.getAttribute("data-play-track"));
    var selectedPlayerClass = 'audio-' + this.getAttribute("data-play-list");

    if (selectedTrack !== _currentTrack || selectedPlayerClass !== _currentPlayerClass) {
      _resetPlayStatus();
      _currentTrack = null;
      _trackLoaded = false;
    }

    if (_trackLoaded === false) {
      _currentTrack = parseInt(selectedTrack);
      _currentPlayerClass = selectedPlayerClass;
      _setTrack();
    } else {
      _playBack(this);
    }

  }, false);
}

var _playBack = function() {
  // var sounds = document.getElementsByTagName('audio');
  for(i=0; i<_elements.players.length; i++) _elements.players[i].pause();
  _elements.audio.load();
  if (_elements.audio.paused) {
    _elements.audio.play();
    _updatePlayStatus(true);
    // document.title = "\u25B6 " + document.title;
  } else {
    _elements.audio.pause();
    _updatePlayStatus(false);
    // document.title = document.title.substr(2);
  }
};

var _updatePlayStatus = function(audioPlaying) {
  if (audioPlaying) {
    // _elements.playerButtons.largeToggleBtn.children[0].className = "large-pause-btn";

    // _elements.playerButtons.smallToggleBtn[_currentTrack - 1].className = "small-pause-btn";
  // } else {
  //   _elements.playerButtons.largeToggleBtn.children[0].className = "large-play-btn";
  //
  //   _elements.playerButtons.smallToggleBtn[_currentTrack - 1].children[0].className = "small-play-btn";
  }

  //Update next and previous buttons accordingly
  // if (_currentTrack === 1) {
  //   _elements.playerButtons.previousTrackBtn.disabled = true;
  //   _elements.playerButtons.previousTrackBtn.className = "previous-track-btn disabled";
  // } else if (_currentTrack > 1 && _currentTrack !== _elements.playListRows.length) {
  //   _elements.playerButtons.previousTrackBtn.disabled = false;
  //   _elements.playerButtons.previousTrackBtn.className = "previous-track-btn";
  //   _elements.playerButtons.nextTrackBtn.disabled = false;
  //   _elements.playerButtons.nextTrackBtn.className = "next-track-btn";
  // } else if (_currentTrack === _elements.playListRows.length) {
  //   _elements.playerButtons.nextTrackBtn.disabled = true;
  //   _elements.playerButtons.nextTrackBtn.className = "next-track-btn disabled";
  // }
};

var _trackHasEnded = function() {
  parseInt(_currentTrack);
  var stopPlaying = (_currentTrack === _elements.playListRows.length);
  _currentTrack = (_currentTrack === _elements.playListRows.length) ? 1 : _currentTrack + 1;
  _trackLoaded = false;

  _resetPlayStatus();
  if(! stopPlaying) _setTrack();
};

_elements.audio.addEventListener("ended", function(e) {
  _trackHasEnded();
}, false);

var _setTrack = function() {
  // console.log('_currentPlayerClass is now : '+ _currentPlayerClass);
  // _elements.audio = document.getElementById("audio" + _currentPlayerClass);
  _elements.audio = document.getElementById(_currentPlayerClass);

  var songURL = _elements.audio.children[_currentTrack - 1].src;

  _elements.audio.setAttribute("src", songURL);
  _elements.audio.load();

  _trackLoaded = true;

  _setTrackTitle(_currentTrack, _elements.playListRows);

  _setActiveItem(_currentTrack, _elements.playListRows);

  if(typeof trackInfoBox !== 'undefined') _elements.trackInfoBox.style.visibility = "visible";

  _playBack();
};

var _setTrackTitle = function(currentTrack, playListRows) {
  var trackTitleBox = document.querySelector(".player .info-box .track-info-box .track-title-text");
  // var trackTitle = playListRows[currentTrack - 1].children[2].outerText;
  if(trackTitleBox) {
    trackTitleBox.innerHTML = null;

    trackTitleBox.innerHTML = trackTitle;

    document.title = trackTitle;
  }
};

var _setActiveItem = function(currentTrack, playListRows) {
  // console.log('Track ' + currentTrack + ' active - row ' + (currentTrack - 1));

  for (var i = 0; i < playListRows.length; i++) {
    // console.log('Deactivate track ' + currentTrack + ' active - row ' + i);
    _elements.playListRows[i].classList.remove("active-track");
  }

  // playListRows[currentTrack - 1].className = "track-title active-track";
  console.log('Activate track ' + currentTrack + ' on ' + _currentListClass);
  _currentList = document.getElementById(_currentListClass);
  var currentRows = _currentList.getElementsByClassName("playlist-row");
  currentRows[currentTrack - 1].classList.add("active-track");
};


var _resetPlayStatus = function() {
  var smallToggleBtn = _elements.playerButtons.smallToggleBtn;

  // _elements.playerButtons.largeToggleBtn.children[0].className = "large-play-btn";

  for (var i = 0; i < smallToggleBtn.length; i++) {
    if (smallToggleBtn[i].className === "small-pause-btn") {
      smallToggleBtn[i].className = "small-play-btn";
    }
  }
};
//

for (var i = 0; i < _elements.players.length; i++) {
  // console.log('Adding listener for ' + _elements.players[i].id);
  // var audio_info = document.getElementById('audio' + players[i].id);
  // var player = document.getElementById('audio' + _elements.players[i].id);
  _elements.players[i].addEventListener('playing', function(e){
    if(_currentPlayerClass !== e.target.id) {
      _elements.audio = document.getElementById(_currentPlayerClass);
      if(_elements.audio) {
        _elements.audio.pause();
      }
      _resetPlayStatus();
      _currentPlayerClass = e.target.id;
      _elements.audio = document.getElementById(_currentPlayerClass);
    }

    // console.log('Audio playback has started ...');
    // _resetPlayStatus();
    // _setTrackTitle(_currentTrack, _elements.playListRows);
    _setTrackTitle(_currentTrack, _elements.playListRows);
    _setActiveItem(_currentTrack, _elements.playListRows);
  }, false);
}

// audio_info.addEventListener('pause', function(e){
//     // console.log('Audio playback has been paused ...');
//     console.log('Playback paused at : '+ e.target.currentTime +" seconds");
// }, false);
//
// audio_info.addEventListener('ended', function(e){
//     console.log('Playback has ended');
// }, false);
// audio_info.addEventListener('volumechange', function(e){
//     // console.log("Volume has changed ...");
//     console.log("Volume is now "+ e.target.volume);
// }, false);
