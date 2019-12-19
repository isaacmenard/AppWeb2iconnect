window.addEventListener('load', function(){
    var newVideo = document.getElementById('musique');
    newVideo.addEventListener('ended', function() {
        this.currentTime = 0;
        this.play();
    }, false);

    newVideo.play();

});