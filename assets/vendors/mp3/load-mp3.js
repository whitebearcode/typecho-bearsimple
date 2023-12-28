var loadAPlayer = function () {
    var len = APlayerOptions.length;
for(var i=0;i<len;i++){
    APlayers[i] = new APlayer({
        element: document.getElementById('player' + APlayerOptions[i]['id']),
        narrow: false,
        preload: APlayerOptions[i]['preload'],
        mutex: APlayerOptions[i]['mutex'],
        autoplay: APlayerOptions[i]['autoplay'],
        showlrc: APlayerOptions[i]['showlrc'],
        music: APlayerOptions[i]['music'],
        theme: APlayerOptions[i]['theme']
        });
    APlayers[i].init();
}
};
document.addEventListener('DOMContentLoaded', loadAPlayer, !1);