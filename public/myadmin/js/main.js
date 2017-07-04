var States = {};

States.Boot = function (game) {
};

States.Boot.prototype = {
    init: function () {
        this.game.scale.scaleMode = this.game.scale.scaleMode = Phaser.ScaleManager.EXACT_FIT;
        this.game.stage.backgroundColor = bgColor;
    },
    preload: function () {
        this.load.image('preload', "../images/preload.png");
    },
    create: function () {
        this.state.start('PreLoader');
    }
};

States.PreLoader = function (game) {
};

States.PreLoader.prototype = {
    init: function() {
        this.game.stage.backgroundColor = bgColor;
        var preload = this.game.add.sprite(this.game.world.width / 2, this.game.world.height / 2, 'preload');
        preload.anchor.setTo(0.5, 0.5);
        var tween = game.add.tween(preload).to( { y: [this.game.world.height / 2 - 50, this.game.world.height / 2] }, 800, "Linear", true);
        tween.repeat(-1);
        this.time = Date.now();
    },
    preload: function () {
        // Common
        this.game.load.image('back', "../images/back.png");
        this.game.load.image('btnClose', "../images/btnClose.png");

        // Main
        this.game.load.image('mainBg', "../images/mainBg.png");
        this.game.load.image('title', "../images/title.png");
        this.game.load.image('btnDraw', "../images/btnDraw.png");
        this.game.load.image('btnRule', "../images/btnRule.png");
        this.game.load.image('btnAward', "../images/btnAward.png");
        this.game.load.image('selected', "../images/selected.png");
        this.game.load.image('spot1', "../images/spot1.png");
        this.game.load.image('spot2', "../images/spot2.png");
        this.game.load.bitmapFont('countFont', "../images/countFont.png", "../images/countFont.xml");
        this.game.load.image('awardBg', "../images/awardBg.png");
        this.game.load.image('fakeAwardBg', "../images/fakeAwardBg.png");
        this.game.load.image('outBg', "../images/outBg.png");
        this.game.load.image('involvedBg', "../images/involvedBg.png");
        // Load award image
        for (var i = 0; i < 8; i++) {
            this.game.load.image('award'+i, "../" + awards[i].image);
        }

        // Rule
        this.game.load.image('ruleBg', "../images/ruleBg.png");

        // Award
        this.game.load.image('qrcodeBg', "../images/qrcodeBg.png");
        this.game.load.image('btnBack', "../images/btnBack.png");
        this.game.load.image('btnShare', "../images/btnShare.png");
        this.game.load.image('chicken', "../images/chicken.png");
        this.game.load.image('btnExchange', "../images/btnExchange.png");
    },

    create: function () {
        if (Date.now() - this.time < 1000) {
            setTimeout(function () {
                this.game.state.start("Main");
            }.bind(this), 1300 - Date.now() + this.time);
        } else {
            this.game.state.start("Main");
        }
    }
};

States.Main = function (game) {
};

States.Main.prototype = {
    turn: 0,
    spotTurn: 0,
    /*
     * Status Define:
     * 0 - Normal Status
     * 1 - Drawing Status
     * 2 - Prepare-to-stop Status
     * 3 - Stopped Status
     * 4 - Waiting for phone
     */
    status: 0,
    selected: null,
    startSelected: 0,
    curSelected: 0,
    prepare: 0,
    curAward: 0,
    countText: null,

    init: function () {
        this.game.stage.backgroundColor = bgColor;
    },
    
    create: function () {
        this.game.add.sprite(0, 0, 'mainBg');
        var bmd = game.make.bitmapData();
        bmd.load('title');
        this.game.add.sprite(122, 60, bmd);
        function hexToRgb(hex) {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                    r: parseInt(result[1], 16),
                    g: parseInt(result[2], 16),
                    b: parseInt(result[3], 16)
                } : null;
        }
        var titleRGB = hexToRgb(titleColor);
        bmd.replaceRGB(60, 93, 255, 255, titleRGB.r, titleRGB.g, titleRGB.b, 255);
        var btnRule = this.game.add.sprite(60, this.game.world.height - 40, 'btnRule');
        btnRule.anchor.setTo(0, 1);
        btnRule.inputEnabled = true;
        btnRule.events.onInputDown.add(function () {
            $('#rule').show();
        });
        var btnAward = this.game.add.sprite(this.game.world.width - 60, this.game.world.height - 40, 'btnAward');
        btnAward.anchor.setTo(1, 1);
        btnAward.inputEnabled = true;
        btnAward.events.onInputDown.add(function () {
            if (mobile) {
                var ua = navigator.userAgent.toLowerCase();
                if (/micromessenger/.test(ua)) {
                    var redirect_url = 'https://' + domain + '/weixin/awardList.php';
                    location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' + appid + '&redirect_uri=' + redirect_url + '&response_type=code&scope=snsapi_base&state=#wechat_redirect';
                } else {
                    $("#awardlist").show();
                    $('.wardlist').empty();
                    $.get('../awardlist.php', {mobile: mobile}, function(data){
                        data = JSON.parse(data);
                        if(data.status == "success"){
                            console.log(data.awardList);
                            $.each(data.awardList,function(i,val){
                                if(data.awardList[i].code.length<9){
                                    var ele = '<div class="item">'+
                                        '<img src="../'+awards[data.awardList[i].award_id - 1].image+'" class="wardlogo">'+
                                        '<span class="wardtext">'+awards[data.awardList[i].award_id - 1].name+'</span>'+
                                        '<span class="awardId" hidden>'+data.awardList[i].award_id+'</span>'+
                                        '<button class="btn-style show-code">兑换码：'+data.awardList[i].code+'</button>'+
                                        '</div>';
                                    $('.wardlist').append(ele);
                                }else{
                                    var ele = '<div class="item">'+
                                        '<img src="../'+awards[data.awardList[i].award_id - 1].image+'" class="wardlogo">'+
                                        '<span class="wardtext">'+awards[data.awardList[i].award_id - 1].name+'</span>'+
                                        '<span class="codenumber" hidden>兑换码：'+data.awardList[i].code+'</span>'+
                                        '<button class="btn-style click-code">显示兑换码</button>'+
                                        '<span class="awardId" hidden>'+data.awardList[i].award_id+'</span>'+
                                        '</div>';
                                    $('.wardlist').append(ele);
                                }
                            });
                        }else{
                            alert(data.message);
                        }
                    });
                }
            } else {
                var involvedPop = this.game.add.group();
                var background = new Phaser.Graphics(this.game, 0, 0);
                background.beginFill(0x000000, 0.4);
                background.drawRect(0, 0, this.world.width, this.world.height);
                background.endFill();
                background.inputEnabled = true;
                involvedPop.add(background);
                involvedPop.create(186, 464, 'involvedBg');
                var btnClose = involvedPop.create(504, 494, 'btnClose');
                btnClose.inputEnabled = true;
                btnClose.events.onInputDown.add(function () {
                    involvedPop.removeAll(true);
                    this.turn = 0;
                    this.status = 0;
                }.bind(this));
            }
        }.bind(this));

        this.countText = this.game.add.bitmapText(360, 300, 'countFont', ""+todayCount, 22);
        this.countText.x = 360 + (32 - this.countText.textWidth) / 2.0;
        this.spot = this.game.add.sprite(76, 374, 'spot1');
        // Load award
        for (var i = 0; i < 8; i++) {
            var awardFrame = this.game.add.graphics();
            awardFrame.beginFill(0xFFFFFF, 1);
            awardFrame.drawRoundedRect(awards[i].framePos.x, awards[i].framePos.y, 156, 166, 10);
            awardFrame.endFill();
            var awardImage = this.game.add.sprite(awards[i].imagePos.x, awards[i].imagePos.y, 'award'+i);
            awardImage.anchor.setTo(0.5, 0.5);
            awardImage.width = 90;
            awardImage.height = 90;
            var titleStyle = {
                font: "24px",
                fill: "#404040",
                align: "center",
                boundsAlignH: "center",
                boundsAlignV: "center"
            };
            var awardTitle = this.game.add.text(awards[i].titlePos.x, awards[i].titlePos.y, awards[i].name, titleStyle);
            awardTitle.anchor.setTo(0.5, 0.5);
        }
        this.selected = this.game.add.sprite(awards[0].framePos.x, awards[0].framePos.y, 'selected');
        this.selected.visible = false;

        // Draw lottery
        this.btnDraw = this.game.add.sprite(296, 604, 'btnDraw');
        this.btnDraw.inputEnabled = true;
        this.btnDraw.events.onInputDown.add(function () {
            this.drawLottery();
        }.bind(this));
    },

    update: function () {
        if (this.spotTurn === 15) {
            this.spotTurn = 0;
            if (this.spot.key === 'spot1') {
                this.spot.loadTexture('spot2');
            } else {
                this.spot.loadTexture('spot1');
            }
        } else {
            this.spotTurn++;
        }
        switch (this.status) {
            case 0:
                this.selected.visible = false;
                break;
            case 1:
                this.selected.visible = true;
                if (this.turn === 5) {
                    this.turn = 0;
                    this.curSelected = (++this.curSelected) % 8;
                    this.selected.x = awards[this.curSelected].framePos.x;
                    this.selected.y = awards[this.curSelected].framePos.y;
                } else {
                    this.turn++;
                }
                break;
            case 2:
                this.selected.visible = true;
                if (this.prepare > 1) {
                    if (this.turn === 5) {
                        this.turn = 0;
                        this.curSelected = (++this.curSelected) % 8;
                        this.selected.x = awards[this.curSelected].framePos.x;
                        this.selected.y = awards[this.curSelected].framePos.y;
                        if (this.curSelected == this.startSelected) this.prepare--;
                    } else {
                        this.turn++;
                    }
                } else {
                    if (this.turn === 15) {
                        this.turn = 0;
                        this.curSelected = (++this.curSelected) % 8;
                        if (this.curAward > -1) {
                            this.selected.x = awards[this.curSelected].framePos.x;
                            this.selected.y = awards[this.curSelected].framePos.y;
                            if (this.curSelected == this.curAward) {
                                if (this.prepare > 0) this.prepare--; else this.showAward();
                            }
                        } else {
                            this.selected.x = this.btnDraw.x;
                            this.selected.y = this.btnDraw.y;
                            this.showAward();
                        }
                    } else {
                        this.turn++;
                    }
                }
                break;
            case 4:
                this.selected.visible = true;
                if ($('#Phone').css('display') == 'none') this.status = 0;
                if (mobile) {
                    this.drawLottery();
                    this.countText.text = todayCount;
                    this.countText.updateText();
                    this.countText.x = 360 + (32 - this.countText.textWidth) / 2.0;
                    return;
                }
                if (this.turn === 15) {
                    this.turn = 0;
                    this.curSelected = (++this.curSelected) % 8;
                    this.selected.x = awards[this.curSelected].framePos.x;
                    this.selected.y = awards[this.curSelected].framePos.y;
                } else {
                    this.turn++;
                }
        }
    },
    
    drawLottery: function () {
        if (this.status != 0) return;
        if (todayCount <= 0) {
            this.todayOut();
            return;
        }
        if (mobile) {
            this.turn = 0;
            this.status = 1;
            $.post("../gainaward.php", {mobile: mobile}, function (data) {
                switch (parseInt(data.status)) {
                    case 200:
                        this.turn = 0;
                        this.status = 2;
                        this.curAward = parseInt(data['award']) - 1;
                        this.startSelected = this.curSelected;
                        this.prepare = 5;
                        break;
                    case 501:
                        this.todayOut();
                        break;
                    default:
                        this.turn = 0;
                        this.status = 0;
                        alert(data.message);
                        break;
                }
            }.bind(this), "json");
        } else {
            $('#Phone').show();
            this.status = 4;
        }
    },
    
    showAward: function () {
        this.turn = 0;
        this.status = 3;
        this.updateTodayCount();
        if (this.curAward > -1) {
            var award = awards[this.curAward];
        } else {
            award = {real: false};
        }
        var awardPop = this.game.add.group();
        var background = new Phaser.Graphics(this.game, 0, 0);
        background.beginFill(0x000000, 0.4);
        background.drawRect(0, 0, this.world.width, this.world.height);
        background.endFill();
        background.inputEnabled = true;
        awardPop.add(background);
        var awardStyle = {
            font: "24px",
            fill: "#FFFFFF",
            align: "center",
            boundsAlignH: "center",
            boundsAlignV: "center",
            lineSpacing: 40
        };
        var text;
        if (award.real) {
            awardPop.create(186, 464, 'awardBg');
            text = this.game.add.text(378, 758, award.notice, awardStyle, awardPop);
        } else {
            awardPop.create(186, 464, 'fakeAwardBg');
            text = this.game.add.text(378, 758, fakeNotice, awardStyle, awardPop);
        }
        text.anchor.setTo(0.5, 0.5);
        var btnClose = awardPop.create(504, 494, 'btnClose');
        btnClose.inputEnabled = true;
        btnClose.events.onInputDown.add(function () {
            awardPop.removeAll(true);
            this.turn = 0;
            this.status = 0;
        }.bind(this));
    },
    
    todayOut: function () {
        this.turn = 0;
        this.status = 0;
        var outPop = this.game.add.group();
        var background = new Phaser.Graphics(this.game, 0, 0);
        background.beginFill(0x000000, 0.4);
        background.drawRect(0, 0, this.world.width, this.world.height);
        background.endFill();
        background.inputEnabled = true;
        outPop.add(background);
        outPop.create(186, 464, "outBg");
        var outStyle = {
            font: "24px",
            fill: "#FFFFFF",
            align: "center",
            boundsAlignH: "center",
            boundsAlignV: "center",
            lineSpacing: 40
        };
        var outText = this.game.add.text(378, 758, todayOutNotice, outStyle, outPop);
        outText.anchor.setTo(0.5, 0.5);
        var btnClose = outPop.create(504, 494, 'btnClose');
        btnClose.inputEnabled = true;
        btnClose.events.onInputDown.add(function () {
            outPop.removeAll(true);
        });
    },
    
    updateTodayCount: function () {
        if (todayCount <= 0) return;
        todayCount--;
        this.countText.text = todayCount;
        this.countText.updateText();
        this.countText.x = 360 + (32 - this.countText.textWidth) / 2.0;
    }
};

var game = new Phaser.Game(750, 1206, Phaser.CANVAS, '');
game.state.add('Boot', States.Boot);
game.state.add('PreLoader', States.PreLoader);
game.state.add('Main', States.Main);
game.state.start('Boot');