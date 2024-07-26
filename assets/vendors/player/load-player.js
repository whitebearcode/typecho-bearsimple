var dPlayers = [];
var loadDPlayer = function () {
    var load = function (d, conf) {
        conf.container = d;
        dPlayers.push(new DPlayer(conf));
    };
    for (var i = 0; i < dPlayers.length; i++) {
        dPlayers[i].destroy();
    }
    dPlayers = [];
    for (var j = 0, k = document.querySelectorAll('.dplayer'); j < k.length; j++) {
        load(k[j], JSON.parse(k[j].dataset.config));
    }
};

document.addEventListener('DOMContentLoaded', loadDPlayer, !1);