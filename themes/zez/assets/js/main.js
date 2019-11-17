function Aruba(){
    var self= this;
    var l;
    var notify= undefined;
    this.init= function(){
        self.login();
        self.header();
        self.actionIP();
        self.actionItem();
        self.actionForm();


        if($(".aniview").length > 0){
            var options = {
                animateThreshold: 100,
                scrollPollInterval: 40
            }
            
            $('.aniview').AniView(options);  
        }


        $(window).scroll(function() {
            self.header();
        }); 

        if($("#home").length > 0){
            particlesJS('home', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        },
                        "image": {
                            "src": "img/github.svg",
                            "width": 100,
                            "height": 100
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 5,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 6,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 400,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true,
                "config_demo": {
                    "hide_card": false,
                    "background_color": "#b61924",
                    "background_image": "",
                    "background_position": "50% 50%",
                    "background_repeat": "no-repeat",
                    "background_size": "cover"
                }
            });    
        }
    };

    this.actionIP = function(){
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://api.ip.sb/geoip",
            "dataType": "jsonp",
            "method": "GET",
            "headers": {
                "Access-Control-Allow-Origin": "*"
            }
        }
        
        $.ajax(settings).done(function (response) {
            timezone = response.timezone;
            $.post(PATH+"auth/timezone", {token:token, timezone:timezone}, function(_result){});
            $(".auto-select-timezone").val(timezone);
        });
    };

    this.login = function(){
        $(".login-page").height($(window).height());
    };

    this.header = function(){
        if($("header").length > 0){
            _header = $("header");
            _width = _header.width();
            _header_pos = _header.offset();

            if($(".home").length > 0 && _width > 960){
                if(_header_pos.top > 10){
                    _header.addClass("header-light");
                }else{
                    _header.removeClass("header-light");
                }
            }else{
                _header.addClass("header-light");
            }

        }
    }

    this.actionItem= function(){
        $(document).on('click', ".actionItem", function(event) {
            event.preventDefault();    
            var _that           = $(this);
            var _action         = _that.attr("href");
            var _id             = _that.data("id");
            var _data           = $.param({token:token, id: _id});
            self.ajax_post(_that, _action, _data, null);
            return false;
        });
    };

    this.actionForm= function(){
        $(document).on('submit', ".actionForm", function(event) {
            event.preventDefault();    
            var _that           = $(this);
            var _action         = _that.attr("action");
            var _data           = _that.serialize();
            var _data           = _data + '&' + $.param({token:token});
            l = Ladda.create(document.querySelector( '.ladda-button' ), { timeout: 2000 });
            self.ajax_post(_that, _action, _data, null);
        });
    };

    this.ajax_post = function(_that, _action, _data, _function){
        var _confirm        = _that.data("confirm");
        var _transfer       = _that.data("transfer");
        var _type_message   = _that.data("type-message");
        var _rediect        = _that.data("redirect");
        var _content        = _that.data("content");
        var _append_content = _that.data("append_content");
        var _callback       = _that.data("callback");
        var _hide_overplay  = _that.data("hide-overplay");
        var _type           = _that.data("result");
        var _object         = false;
        if(_type == undefined){
            _type = 'json';
        }

        if(_confirm != undefined){
            if(!confirm(_confirm)) return false;
        }

        if(!_that.hasClass("disabled")){
            if(l != undefined){
                l.start();
            }
            clearTimeout(notify);
            _that.addClass("disabled");
            $.post(_action, _data, function(_result){
                
                //Check is object
                if(typeof _result != 'object'){
                    try {
                        _result = $.parseJSON(_result);
                        _object = true;
                    } catch (e) {
                        _object = false;
                    }
                }else{
                    _object = true;
                }

                //Callback
                if(_callback != undefined){
                    var fn = window[_callback];
                    if (typeof fn === "function") fn(_result);
                }

                //Using for update
                if(_transfer != undefined){
                    _that.removeClass("tag-success tag-danger").addClass(_result.tag).text(_result.text);
                }

                //Hide Loading
                _that.removeClass("disabled");

                //Redirect
                self.redirect(_rediect, _result.status);
                if(l != undefined){
                    l.stop();
                }

                //Message
                if(_result.status != undefined){
                    switch(_type_message){
                        case "text":
                            self.notify(_result.message, _result.status);
                            break;

                        default:
                            self.notify(_result.message, _result.status);
                            break;
                    }
                }

            }, _type).fail(function() {
                _that.removeClass("disabled");
            });
        }

        return false;
    };

    this.notify =function(_messagem, _type){
        switch(_type){
            case "success":
                _class = "text-success";
                break;

            default:
                _class = "text-danger";
                break;
        }

        $(".notify").html('<span class="'+_class+'">'+_messagem+'</span><br/><br/>').hide().fadeIn(100);
    };

    this.redirect = function(_rediect, _status){
        if(_rediect != undefined && _status == "success"){
            setTimeout(function(){
                window.location.assign(_rediect);
            }, 2000);
        }
    };
};

Aruba= new Aruba();
$(function(){
    Aruba.init();
});