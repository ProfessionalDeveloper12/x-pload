function Instagram(){
    var self= this;
    var _current_link = "";
    var _current_link_carousel = [];
    var _started = false;
    this.init= function(){
        if($(".instagram-app").length > 0){
            self.optionInstagram();
            self.loadPreview();
            self.activity();
        }
    };

    this.optionInstagram = function(){
        /*
        * Select type post
        */
        if($("[name='default_type']").val() != undefined){
            _default_type = $("[name='default_type']").val();
            console.log(_default_type);
            setTimeout(function(){
                _that = $(".schedule-instagram-type .item[data-type='"+_default_type+"']");
                self.load_form(_that, false);
            }, 50);
        }
        
        $(document).on("click", ".schedule-instagram-type .item", function(){
            self.load_form($(this), true);
        });

        //Enable Schedule
        $(document).on("change", ".enable_instagram_schedule", function(){

            _that = $(this);
            if(!_that.hasClass("checked")){
                $('.time_post').removeAttr('disabled');
                $('.btnPostNow').addClass("hide");
                $('.btnSchedulePost').removeClass("hide");
                _that.addClass('checked');
            }else{
                $('.time_post').attr('disabled', true);
                $('.btnPostNow').removeClass("hide");
                $('.btnSchedulePost').addClass("hide");
                _that.removeClass('checked');        
            }
            return false;
        });

        //Get Instagram Media
        $(document).on("click", ".btnGetInstagramMedia", function(){
            _that    = $(this);
            _type    = _that.data("type");
            _media   = _that.data("media");
            _caption = _that.data("caption");

            //Select tab
            $(".schedule-instagram-type .item[data-type="+_type+"]").trigger("click");

            //Set caption
            $(".post-message").data("emojioneArea").setText(_caption);

            //Add image
            if(_type == "carousel"){
                FileManager.type_select = 'multi';
            }else{
                FileManager.type_select = 'single';
            }

            for (var i = 0; i < _media.length; i++) {
                FileManager.saveFile(_media[i]);
            }

            //Hide modal
            $('#mainModal').modal('hide');
        });

        //Search Location
        var _dayTime_search_location;
        $(".instagram_search_location").keyup(function(){
            _that = $(this);
            _action = _that.data("action");
            _keyword = _that.val();
            _data = $.param({token:token, keyword: _keyword });
            clearTimeout(_dayTime_search_location);
            if(_keyword.length > 1){
                $(".loading-location").show();
                _dayTime_search_location = setTimeout(function(){ 

                    Main.ajax_post(_that, _action, _data, function(_result){
                        $(".loading-location").hide();
                    });

                }, 2000);
            }else{
                $(".list_choice_options").remove();
                $(".loading-location").hide();
            }

        });

        $(document).on("click", ".list_choice_options .item", function(){
            _that = $(this);
            _radio = _that.find("input");
            if(_radio.is(':checked')) {
                _radio.prop('checked',false);

            }else{
                _radio.prop('checked',true);
            }

            return false;
        });

        $(document).on("click", ".list_choice_options .item input", function(){
            _radio = $(this);
            if(_radio.is(':checked')) {
                _radio.prop('checked',false);

            }else{
                _radio.prop('checked',true);
            }

            return false;
        });

        $(document).on("click", ".file-manager-list-images .item .close", function(){
            if($(".file-manager-list-images .item").length <= 0){
               self.defaultPreview();
            }
        });

        $(document).on("click", ".instagram-app .btnPostNow", function(){
            _that = $(this);
            self.postNow(_that);
        });
    };

    this.load_form = function(_that, _load_default_preview){
        _type = _that.data("type");
        _that.addClass("active");
        _that.siblings().removeClass("active");
        _that.siblings().find("input").removeAttr('checked');
        _that.find("input").attr('checked','checked');
        $(".preview-instagram").addClass("hide");
        $(".preview-instagram-"+_type).removeClass("hide");
        self.defaultPreview();
    };

    this.postNow = function(_that){
        _form    = _that.closest("form");
        _action  = _form.attr("action");
        _data    = $("[name!='account[]']").serialize();
        _data    = _data + '&' + $.param({token:token});
        _item    = $(".list-account .item.active");
        _stop    = false;
        if(_item.length > 0){
            _id     = _item.first().find("input").val();
            _data   = _form.serialize();
            _data   = Main.removeParam("account%5B%5D", _data);
            _data   = _data + '&' + $.param({token:token , 'account[]' :_id});
        }else{
            if(_started == true){
                _started = false;
                Main.statusCardOverplay("hide");
                return false;
            }
        }

        Main.statusOverplay("hide");
        Main.statusCardOverplay("show");

        Main.ajax_post(_that, _action, _data, function(_result){
            Main.statusOverplay("show");
            _started = true;

            //Remove mark item
            if(_result.stop == undefined){
                _item.first().trigger("click");
                setTimeout(function(){
                    $(".btnPostNow").trigger("click");
                }, 500);
            }else{
                Main.statusCardOverplay("hide");
            }
        });
    };

    this.activity = function(){
        /*
        * Enhanced Instagram Activity UI
        */
        $("input[name^='todo']").each(function(){
            var param = "[data-content='" + $(this).attr('name') + "']";
            if ($(this).is(':checked')) {
                $(param).show(500);
            } else $(param).hide(500);         
        });

        $("input[name^='todo']").change(function(){
            var param = "[data-content='" + $(this).attr('name') + "']";
            if ($(this).is(':checked')) {
                $(param).show(500);
            } else $(param).hide(500);
        });
        /*
        * Enhanced Instagram Activity UI
        */
        $(".inpTimeLimit").mask("99:99");

        $(document).on("change", ".inpTimeLimit", function(){
            _val = $(this).val();
            if(_val.length != 5){
                $(this).val("");
            }
        });
        
        $(document).on("click", ".btnActivityStart", function(){
            _that = $(this);
            _action = _that.attr("href");
            _data = {token:token};
            Main.ajax_post(_that, _action, _data, function(_result){
                if(_result.status == "success"){

                    _that.parents(".activity-profile").find(".status").find("span").remove();
                    _that.parents(".activity-profile").find(".status").append(_result.labeState);

                    _that.before(_result.btnStop).remove();
                    $(".activity-proccess").html(_result.iconState);
                }
            });

            return false;
        });

        $(document).on("click", ".btnActivityStop", function(){
            _that = $(this);
            _action = _that.attr("href");
            _data = {token:token};
            Main.ajax_post(_that, _action, _data, function(_result){
                if(_result.status == "success"){
                    
                    _that.parents(".activity-profile").find(".status").find("span").remove();
                    _that.parents(".activity-profile").find(".status").append(_result.labeState);

                    _that.before(_result.btnStart).remove();
                    $(".activity-proccess").html(_result.iconState);
                }
            });

            return false;
        });

        $(document).on("change", ".actionSaveActivity", function(){
            self.saveActivity();
        });

        $(document).on("click", ".activity-button-x", function(){
            _that = $(this);
            _that.parents("a").remove();
            self.saveActivity();
            return false;
        });

        $(document).on("click", ".actionAddComment", function(){
            _comments = $(".textarea-comment").val();
            var lines = _comments.split('\n');
            for(var i = 0;i < lines.length ; i++){
                if(lines[i] != ""){
                    _comment = lines[i];
                    _check_exist = false;
                    $("[name='comment[]']").each(function(){
                        _comment_exist = $(this).val();
                        if(_comment_exist == _comment){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _comment = '<a href="#" class="activity-option-item activity-option-comment"><span>'+_comment+'</span><input type="hidden" name="comment[]" value="'+_comment+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-comment").before(_comment);
                    }
                }
            }
            $('#mainModal').modal('toggle');
            self.saveActivity();
        });

        $(document).on("click", ".actionAddDirectMessage", function(){
            _direct_messages = $(".textarea-direct-message").val();
            var lines = _direct_messages.split('\n');
            for(var i = 0;i < lines.length ; i++){
                if(lines[i] != ""){
                    _direct_message = lines[i];
                    _check_exist = false;
                    $("[name='direct_message[]']").each(function(){
                        _direct_message_exist = $(this).val();
                        if(_direct_message_exist == _direct_message){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _direct_message = '<a href="#" class="activity-option-item activity-option-comment"><span>'+_direct_message+'</span><input type="hidden" name="direct_message[]" value="'+_direct_message+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-direct-message").before(_direct_message);
                    }
                }
            }
            $('#mainModal').modal('toggle');
            self.saveActivity();
        });

        $(document).on("click", ".actionAddTag", function(){
            _tags = $(".textarea-tag").val();
            var lines = _tags.split('\n');
            for(var i = 0;i < lines.length ; i++){
                if(lines[i] != "" && lines[i].indexOf(' ') == -1){
                    _tag = lines[i];
                    _check_exist = false;
                    $("[name='tag[]']").each(function(){
                        _tag_exist = $(this).val();
                        if(_tag_exist == _tag){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_tag = '<a href="#" class="activity-option-item activity-option-tag"><span>'+_tag+'</span><input type="hidden" name="tag[]" value="'+_tag+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-tag").before(_html_tag);
                    }
                }
            }

            if($("[name='add_tag[]']:checked").length > 0){
                $("[name='add_tag[]']:checked").each(function(){
                    _tag = $(this).val();
                    _check_exist = false;
                    $("[name='tag[]']").each(function(){
                        _tag_exist = $(this).val();
                        if(_tag_exist == _tag){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_tag = '<a href="#" class="activity-option-item activity-option-tag"><span>'+_tag+'</span><input type="hidden" name="tag[]" value="'+_tag+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-tag").before(_html_tag);
                    }
                });
            }
            
            $('#mainModal').modal('toggle');
            self.saveActivity();
        });

        $(document).on("click", ".actionAddTagBlacklist", function(){
            _tags = $(".textarea-tag").val();
            var lines = _tags.split('\n');
            for(var i = 0;i < lines.length ; i++){
                if(lines[i] != "" && lines[i].indexOf(' ') == -1){
                    _tag = lines[i];
                    _check_exist = false;
                    $("[name='tag_blacklist[]']").each(function(){
                        _tag_exist = $(this).val();
                        if(_tag_exist == _tag){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_tag = '<a href="#" class="activity-option-item activity-option-tag"><span>'+_tag+'</span><input type="hidden" name="tag_blacklist[]" value="'+_tag+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-tag-blacklist").before(_html_tag);
                    }
                }
            }

            if($("[name='add_tag[]']:checked").length > 0){
                $("[name='add_tag[]']:checked").each(function(){
                    _tag = $(this).val();
                    _check_exist = false;
                    $("[name='tag_blacklist[]']").each(function(){
                        _tag_exist = $(this).val();
                        if(_tag_exist == _tag){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_tag = '<a href="#" class="activity-option-item activity-option-tag"><span>'+_tag+'</span><input type="hidden" name="tag_blacklist[]" value="'+_tag+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-tag-blacklist").before(_html_tag);
                    }
                });
            }
            
            $('#mainModal').modal('toggle');
            self.saveActivity();
        });

        $(document).on("click", ".actionAddUsername", function(){
            if($("[name='add_username[]']:checked").length > 0){
                $("[name='add_username[]']:checked").each(function(){
                    _username = $(this).val();
                    _username_split = _username.split("|");
                    _check_exist = false;
                    $("[name='username[]']").each(function(){
                        _username_exist = $(this).val();
                        _username_exist_split = _username_exist.split("|");
                        if(_username_exist_split[1] == _username_split[1]){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_username = '<a href="#" class="activity-option-item activity-option-user"><img src="https://avatars.io/instagram/'+_username_split[1]+'" style="margin-right:3px;"><span>'+_username_split[1]+'</span><input type="hidden" name="username[]" value="'+_username+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-username").before(_html_username);
                    }
                });
            }
            
            $('#mainModal').modal('toggle');
            self.saveActivity();
        });

        $(document).on("click", ".actionAddLocation", function(){
            if($("[name='add_location[]']:checked").length > 0){
                $("[name='add_location[]']:checked").each(function(){
                    _location = $(this).val();
                    _location_split = _location.split("|");
                    _check_exist = false;
                    $("[name='location[]']").each(function(){
                        _location_exist = $(this).val();
                        _location_exist_split = _location_exist.split("|");
                        if(_location_exist_split[0] == _location_split[0]){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_location = '<a href="#" class="activity-option-item activity-option-location"><span>'+_location_split[1]+'</span><input type="hidden" name="location[]" value="'+_location+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-location").before(_html_location);
                    }
                });
            }
            
            $('#mainModal').modal('toggle');
            self.saveActivity();
        });

        $(document).on("click", ".actionAddUsernameBlacklist", function(){
            if($("[name='add_username[]']:checked").length > 0){
                $("[name='add_username[]']:checked").each(function(){
                    _username = $(this).val();
                    _username_split = _username.split("|");
                    _check_exist = false;
                    $("[name='username_blacklist[]']").each(function(){
                        _username_exist = $(this).val();
                        _username_exist_split = _username_exist.split("|");
                        if(_username_exist_split[1] == _username_split[1]){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_username = '<a href="#" class="activity-option-item activity-option-user"><img src="https://avatars.io/instagram/'+_username_split[1]+'" style="margin-right:3px;"><span>'+_username_split[1]+'</span><input type="hidden" name="username_blacklist[]" value="'+_username+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-username-blacklist").before(_html_username);
                    }
                });
            }
            
            $('#mainModal').modal('toggle');
            self.saveActivity();         
        });

        $(document).on("click", ".actionAddKeyword", function(){
            _keywords = $(".textarea-keyword").val();
            var lines = _keywords.split('\n');
            for(var i = 0;i < lines.length ; i++){
                if(lines[i] != ""){
                    _keyword = lines[i];
                    _check_exist = false;
                    $("[name='keyword_blacklist[]']").each(function(){
                        _keyword_exist = $(this).val();
                        if(_keyword_exist == _keyword){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _keyword = '<a href="#" class="activity-option-item activity-option-keyword"><span><strike>'+_keyword+'</strike></span><input type="hidden" name="keyword_blacklist[]" value="'+_keyword+'"><span class="activity-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-keyword").before(_keyword);
                    }
                }
            }
            $('#mainModal').modal('toggle');
            self.saveActivity();
        });

        $(document).on("change", ".speedLevel", function(){
            _that = $(this);
            _values = _that.children('option:selected').data('speed');
            $("[name='speed[like]']").val(_values[0]);
            $("[name='speed[comment]']").val(_values[1]);
            $("[name='speed[follow]']").val(_values[2]);
            $("[name='speed[unfollow]']").val(_values[3]);
            $("[name='speed[direct_message]']").val(_values[4]);
            $("[name='speed[repost_media]']").val(_values[5]);
            self.saveActivity();
        });

        $(document).on("change", ".item-speed", function(){
            self.loadSpeedLevel();
        });
        self.loadSpeedLevel();

        //Open Table
        $(document).on("change", ".collapseAction", function(){
            _that = $(this);
            _type = _that.attr("data-type");
            if(_that.is(':checked')) {
                $('#'+_type).collapse("toggle");
            }else{
                $('#'+_type).collapse("hide");
            }
        });

        $(".collapseAction").each(function(index, value){
            _that = $(this);
            _type = _that.attr("data-type");
            if(_that.is(':checked')) {
                $('#'+_type).collapse("toggle");
            }else{
                $('#'+_type).collapse("hide");
            }
        });

        //Activity Filter
        $(document).on("change", ".activityFilterAction", function(){
            _that = $(this);
            _that.parents("form").submit();
        });
        

        //Delete All Item List Activity
        $(document).on("click", ".activityDeleteAllOption", function(){
            $(this).parents(".item").find(".activity-option-item").remove();
            self.saveActivity();
        });
    };

    this.loadSpeedLevel = function(){
        _check_use_speed_default = false;
        $(".speedLevel option").each(function(index, value){
            _like = $("[name='speed[like]']").val();
            _comment = $("[name='speed[comment]']").val();
            _follow = $("[name='speed[follow]']").val();
            _unfollow = $("[name='speed[unfollow]']").val();
            _direct_message = $("[name='speed[direct_message]']").val();
            _repost_media = $("[name='speed[repost_media]']").val();

            _speed_default = JSON.stringify($(this).data("speed"));
            _string_speed = "["+_like+","+_comment+","+_follow+","+_unfollow+","+_direct_message+","+_repost_media+"]";
            if(_string_speed==_speed_default){
                _check_use_speed_default = true;
            }
        });

        if(!_check_use_speed_default){
            $(".speedLevel").val("");
        }
    };

    this.saveActivity = function(){
        var _form           = $( ".activityForm" );
        var _action         = _form.attr("action");
        var _data           = _form.serialize();
        var _data           = _data + '&' + $.param({token:token});
        Main.ajax_post(_form, _action, _data, function(_result){
            if(_result.status == "error"){
                $(".btnActivityStop").before(_result.btnStart).remove();
                $(".activity-proccess").html(_result.iconState);
            }
        });
    };

    this.ScheduleActivity= function(){
        _type_hour = [" AM", " PM"];
        _schedule_selector = $(".day-schedule-selector");
        _days = ["", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        _hours = [12,1,2,3,4,5,6,7,8,9,10,11,12,1,2,3,4,5,6,7,8,9,10,11];
        _schedule_days = $("input[name='schedule_data']").val();
        _schedule_days = _schedule_days!=""?JSON.parse(_schedule_days):[];

        _thead_item = "";
        for (var i = 0; i < _days.length; i++) {
            _thead_item += "<th>"+_days[i]+"</th>";
        }
        _thead = "<tr>"+_thead_item+"</tr>";

        _row_item = "";
        _row_item_count = 0;
        for (var i = 0; i < _hours.length; i++) {

            _row_item_select = "";
            _row_item_select_full = "";
            for (var j = 0; j < 7; j++) {
                _row_item_select_full += "<td><a href='javascript:void(0);' data-day='"+j+"' data-hour='"+i+"' class='item "+($.inArray(i, _schedule_days[j]) != -1?"active":"")+"'></a></td>";
            }

            _row_item += "<tr><td class='hour'>"+_hours[i]+(_row_item_count<12?_type_hour[0]:_type_hour[1])+"</td>"+_row_item_select_full+"</tr>";
            _row_item_count++;
        }

        _table = "<table class='table-day-schedule'>"+_thead+_row_item+"</table>";

        _schedule_selector.html(_table);

        _noneTime = [[],[],[],[],[],[],[]];

        _dayTime = [
            [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
        ];

        _nightTime = [
            [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23]
        ];

        _allTime = [
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
        ];


        $(document).on("click", ".day-schedule-auto a", function(){
            _main = $(this);

            $(".day-schedule-selector .item").each(function(index, value){
                _that = $(this);
                _day = _that.attr("data-day");
                _hour = _that.attr("data-hour");
                _type = _main.attr("data-type");

                switch(_type) {
                    case "all":
                        _data = _allTime;
                        break;

                    case "day":
                        _data = _dayTime;
                        break;

                    case "night":
                        _data = _nightTime;
                        break;

                    default:
                        _data = _noneTime;
                }
                $("input[name='schedule_data']").val(JSON.stringify(_data));
                if($.inArray(parseInt(_hour) , _data[_day]) != -1){
                    _that.addClass("active");
                }else{
                    _that.removeClass("active");
                }
            });
        });


        $(document).on("click", ".day-schedule-selector .item", function(){
            _that = $(this);
            if(_that.hasClass("active")){
                _that.removeClass("active");
            }else{
                _that.addClass("active");
            }
            
            _count = 0;
            _days_selected = [[],[],[],[],[],[],[]];
            $(".day-schedule-selector .item").each(function(index, value){

                if($(this).hasClass("active")){
                    _hour = $(this).attr("data-hour");
                    _days_selected[_count].push(parseInt(_hour));
                }

                if(_count >= 6){
                    _count = 0;
                }else{
                    _count++;
                }
            });

            $("input[name='schedule_data']").val(JSON.stringify(_days_selected));
        });

        $(document).on("click", ".open_schedule_days", function(){
            $('#schedule_days').modal('show');
        });
    }
 
    this.TwoFactorLogin = function(){
        $(".form-verification_code").removeClass("hide");
    };

    this.FinalLogin = function(){
        setTimeout(function(){
            jQuery('[name="submit_popup"]')[0].click();
        },100);
    };

    this.ChallengeRequired = function(){
        $(".form-security_code").removeClass("hide");
    };

    this.loadPreview = function(){
        //Review content
        if($(".post-message").length > 0){
            $(".post-message").data("emojioneArea").on("keyup", function(editor) {
                _data = editor.html();
                if(_data != ""){
                    $(".instagram-app .caption-info").html(_data);
                }else{
                    $(".instagram-app .caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });

            $(".post-message").data("emojioneArea").on("change", function(editor) {
                _data = editor.html();
                if(_data != ""){
                    $(".instagram-app .caption-info").html(_data);
                }else{
                    $(".instagram-app .caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });

            $(".post-message").data("emojioneArea").on("emojibtn.click", function(editor) {
                _data = $(".emojionearea-editor").html();
                if(_data != ""){
                    $(".instagram-app .caption-info").html(_data);
                }else{
                    $(".instagram-app .caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });
        }

        //Load Preview
        setInterval(function(){ 
            _type  = $(".schedule-instagram-type .item.active").data("type");
            _type = ( _type == undefined )?$(".all-post .list-action .active input").val():_type;

            _media = $(".file-manager-list-images .item");
            if(_media.length > 0){
                switch(_type){
                    case "photo":
                        if(_media.length > 1){
                            self.getCarousel();
                            $(".preview-instagram").addClass("hide");
                            $(".preview-instagram-carousel").removeClass("hide");
                        }else{
                            _link     = _media.find("input").val();
                            _link_arr = _link.split(".");
                            if(_current_link != _link){
                                if(_link_arr[_link_arr.length - 1] == "mp4"){
                                    $(".preview-instagram-photo .preview-image").html('<video src="'+_link+'" playsinline="" autoplay="" muted="" loop=""></video>');
                                    $(".preview-instagram-photo .preview-image").css({"background-image": "none"});
                                }else{
                                    $(".preview-instagram-photo .preview-image").css({"background-image": "url("+_link+")"});
                                    $(".preview-instagram-photo .preview-image").html('');
                                }
                                _current_link = _link;
                            }
                            $(".preview-instagram").addClass("hide");
                            $(".preview-instagram-photo").removeClass("hide");
                        }
                        break;

                    case "link":
                        if(_media.length > 1){
                            self.getCarousel();
                            $(".preview-instagram").addClass("hide");
                            $(".preview-instagram-carousel").removeClass("hide");
                        }else{
                            _link     = _media.find("input").val();
                            _link_arr = _link.split(".");
                            if(_current_link != _link){
                                if(_link_arr[_link_arr.length - 1] == "mp4"){
                                    $(".preview-instagram-photo .preview-image").html('<video src="'+_link+'" playsinline="" autoplay="" muted="" loop=""></video>');
                                    $(".preview-instagram-photo .preview-image").css({"background-image": "none"});
                                }else{
                                    $(".preview-instagram-photo .preview-image").css({"background-image": "url("+_link+")"});
                                    $(".preview-instagram-photo .preview-image").html('');
                                }
                                _current_link = _link;
                            }
                            $(".preview-instagram").addClass("hide");
                            $(".preview-instagram-photo").removeClass("hide");
                        }
                        break;

                    case "story":
                        _link     = _media.find("input").val();
                        _link_arr = _link.split(".");
                        if(_current_link != _link){
                            if(_link_arr[_link_arr.length - 1] == "mp4"){
                                $(".preview-instagram-story").html('<video src="'+_link+'" playsinline="" autoplay="" muted="" loop=""></video>');
                            }else{
                                $(".preview-instagram-story").html('<div class="image" style="background-image: url('+_link+');"></div>');
                            }
                            _current_link = _link;
                        }

                        break;

                    case "carousel":
                        self.getCarousel();
                        break;
                }
            }
        }, 1500);
    };

    this.defaultPreview = function(){
        $(".preview-instagram-photo .preview-image").css({"background-image": "none"}).html('');
        $(".preview-instagram-story").html('');
        $(".preview-instagram-carousel .preview-image").html('<div id="preview-carousel" class="preview-carousel carousel slide"></div>');
    };

    this.getCarousel = function(){
        list_images = [];
        $check = true;

        $("input[name='media[]']").each(function( index ) {
            list_images.push($(this).val());
            if(_current_link_carousel.indexOf($(this).val()) == -1 || _current_link_carousel.length != $("input[name='media[]']").length){
                $check = false;
            }
        });

        if($check == false){
            _current_link_carousel = list_images;
            carousel = '<div id="preview-carousel" class="preview-carousel carousel slide" data-ride="carousel"><ol class="carousel-indicators">';
            for (i = 0; i < list_images.length; i++) {
                carousel += '<li data-target="#preview-carousel" data-slide-to="'+i+'" class="'+(i==0?'active':'')+'"></li>';
            }
            carousel += '</ol>';
            carousel += '<div class="carousel-inner">';
            for (i = 0; i < list_images.length; i++) {
                _link_arr = list_images[i].split(".");
                if(_link_arr[_link_arr.length - 1] == "mp4"){
                    carousel += '<div class="item '+(i==0?'active':'')+'"><video src="'+list_images[i]+'" playsinline="" autoplay="" muted="" loop=""></video></div>';
                }else{
                    carousel += '<div class="item '+(i==0?'active':'')+'"><div class="image" style="background-image: url('+list_images[i]+');"></div></div>';
                }
                
            }
            carousel += '</div></div>';

            $(".preview-instagram-carousel .preview-image").html(carousel);
        }
    };
}

Instagram= new Instagram();
$(function(){
    Instagram.init();
});