function CommonModule(){
    var self     = this;
    var overplay = $(".loading-overplay");

    this.init= function(){
        if($(".instagram-app").length > 0){
            self.searchTarget();
            self.start();
            self.commonModule();
        }

        _url = window.location.href;
        _url = _url.split("?id=");
        if(_url.length == 2){
            $('[data-ids="'+_url[1]+'"]').trigger("click");
            $('[data-ids="'+_url[1]+'"] a').trigger("click");
        }
    };

    this.start = function(){
        $('.select-account-list').vtdropdown();
    }
    this.commonModule = function(){
        $(document).on('click', '.select-account-item', function(){
            $(".common-module-content").removeClass('dataTables_empty');
            overplay.show();
            _that    = $(this);
            _ids     = _that.data('ids');
            _action  = _that.data('url');
            _data    = $.param({token:token, ids:_ids});
            $.post(_action, _data, function(_result){
                overplay.hide();
                if(_result.length <= 200){
                    _result = jQuery.parseJSON(_result);
                    if(_result.status == 'error'){
                        $(".common-module-content").html('');
                    }
                }else{
                    history.pushState(null, '', _action.replace("/content/", "?id="));
                    $(".common-module-content").html(_result);
                }
            })
        })

        $(document).on("click", ".module-content .setting-log", function(){
            _that    = $(this);
            _that.addClass('active');
            _action  = _that.data('url');
            _type    = _that.data('type');
            _data    = $.param({token:token});
            $.post(_action, _data, function(_result){
                $(".ajax-module-log-list").html('');
                if(_result.length <= 200){
                    _result = jQuery.parseJSON(_result);
                    if(_result.status == 'error'){
                        $(".ajax-module-log-list").html('');
                    }
                }else{
                  $(".ajax-module-log-list").html(_result);
                }
            })

        })
    }

    this.searchTarget = function(){

        $(document).on("click", ".search-target-button-x", function(){
            _that = $(this);
            _that.parents("a").remove();
            return false;
        });
        // choose search target type
        $(document).on("click", ".search-target-type .item", function(){
            _that = $(this);
            _type = _that.data("type");
            switch(_type){
                case "hashtag":
                    $('.target-hashtag').removeClass('hide');
                    $('.target-location').addClass('hide');
                    $('.target-username').addClass('hide');
                    break;

                case "location":
                    $('.target-hashtag').addClass('hide');
                    $('.target-location').removeClass('hide');
                    $('.target-username').addClass('hide');
                    break;

                case "username":
                    $('.target-hashtag').addClass('hide');
                    $('.target-location').addClass('hide');
                    $('.target-username').removeClass('hide');
                    break;

            };
            _that.addClass("active");
            _that.siblings().removeClass("active");
            _that.siblings().find("input").removeAttr('checked');
            _that.find("input").attr('checked','checked');
            $(".preview-instagram").addClass("hide");
            $(".preview-instagram-"+_type).removeClass("hide");

        });
        //SearchAddTag
        $(document).on("click",".actionSearchAddTag",function(){
            //by enter directly
            _tags = $(".textarea-tag").val();
            if(typeof _tags === 'string'){
                _tagsArray = _tags.split('\n');
                for (var i = 0; i < _tagsArray.length; i++) {
                    _tagsArray[i]
                    if(_tagsArray[i] != '' && _tagsArray[i].indexOf(' ') == -1){
                        _check_exist = false;
                        _tag = _tagsArray[i];
                        $("[name='tag[]']").each(function(){
                            _tag_exist = $(this).val();
                            if(_tag_exist == _tag){
                                _check_exist = true;
                            }
                        })
                        if(!_check_exist){
                            _html_tag = '<a href="#" class="activity-option-item activity-option-tag"><span>#'+_tag+'</span><input type="hidden" name="tag[]" value="'+_tag+'"><span class="search-target-button-x"><i class="ft-x"></i></span></a>';
                            $(".target-add-tag").before(_html_tag);
                        }
                    }
                }
            }
            //by search
            if($("[name='add_tag[]']:checked").length >0 ){
                $("[name='add_tag[]']:checked").each(function(){
                    _tag = $(this).val();
                    _check_exist = false;
                    $("[name='tag[]']").each(function(){
                        _tag_exist = $(this).val();
                        if(_tag_exist == _tag){
                            _check_exist = true;
                        }
                    })
                    if (!_check_exist) {
                        _html_tag = '<a href="#" class="activity-option-item activity-option-tag"><span>#'+_tag+'</span><input type="hidden" name="tag[]" value="'+_tag+'"><span class="search-target-button-x"><i class="ft-x"></i></span></a>';
                        $(".target-add-tag").before(_html_tag);
                    }
                })
            };
            $('#mainModal').modal('toggle');
        })
        // SearchAddLocations
        $(document).on("click",".actionSearchAddLocation",function(){
            if($("[name='add_location[]']:checked").length > 0){
                $("[name='add_location[]']:checked").each(function(){
                    _location = $(this).val();
                    _locationArray = _location.split("|");
                    _check_exist = false;
                    $("[name='location[]']").each(function(){
                        _location_exist = $(this).val();
                        __location_existArray = _location_exist.split("|");
                        if (__location_existArray[1] == _locationArray[1]) {
                            _check_exist = true;
                        }
                    })
                    if(!_check_exist){
                        _html_location = '<a href="#" class="activity-option-item activity-option-location"><span>'+_locationArray[1]+'</span><input type="hidden" name="location[]" value="'+_location+'"><span class="search-target-button-x"><i class="ft-x"></i></span></a>';
                        $(".target-add-location").before(_html_location);
                    }
                })
            }
            $("#mainModal").modal('toggle');
        })
        // SearchAddUsername
        $(document).on("click",".actionSearchAddUsername",function(){
            if($("[name='add_username[]']:checked").length > 0){
                $("[name='add_username[]']:checked").each(function(){
                    _username = $(this).val();
                    _usernameArray = _username.split("|");
                    _check_exist = false;
                    $("[name='username[]']").each(function(){
                        _username_exist = $(this).val();
                        _username_existArray = _username_exist.split("|");
                        if(_username_existArray[1] == _usernameArray[1]){
                            _check_exist = true;
                        }
                    });

                    if(!_check_exist){
                        _html_username = '<a href="#" class="activity-option-item activity-option-user"><img src="https://avatar.stackposts.com/?u='+_usernameArray[1]+'" style="margin-right:3px;"><span>@'+_usernameArray[1]+'</span><input type="hidden" name="username[]" value="'+_username+'"><span class="search-target-button-x"><i class="ft-x"></i></span></a>';
                        $(".target-add-username").before(_html_username);
                    }
                });
            }
            
            $('#mainModal').modal('toggle');

        })
        // SearchAddComment
        $(document).on("click", ".actionSearchAddComment", function(){
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
                        _comment = '<a href="#" class="activity-option-item activity-option-comment"><span>'+_comment+'</span><input type="hidden" name="comment[]" value="'+_comment+'"><span class="search-target-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-comment").before(_comment);
                    }
                }
            }
            $('#mainModal').modal('toggle');
        });

        // SearchAddUsernameBlacklist
        $(document).on("click", ".actionSearchAddUsernameBlacklist", function(){
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
                        _html_username = '<a href="#" class="activity-option-item activity-option-user"><img src="https://avatar.stackposts.com/?u='+_username_split[1]+'" style="margin-right:3px;"><span>'+_username_split[1]+'</span><input type="hidden" name="username_blacklist[]" value="'+_username_split[1]+'"><span class="search-target-button-x"><i class="ft-x"></i></span></a>';
                        $(".target-add-username-blacklist").before(_html_username);
                    }
                });
            }
            
            $('#mainModal').modal('toggle');
        });

        // actionSearchAddDirectMessage
        $(document).on("click", ".actionSearchAddDirectMessage", function(){
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
                        _direct_message = '<a href="#" class="activity-option-item activity-option-comment"><span>'+_direct_message+'</span><input type="hidden" name="direct_message[]" value="'+_direct_message+'"><span class="search-target-button-x"><i class="ft-x"></i></span></a>';
                        $(".activity-add-direct-message").before(_direct_message);
                    }
                }
            }
            $('#mainModal').modal('toggle');
        });

        //Delete All Item List Activity
        $(document).on("click", ".ModuleDeleteAllOption", function(){
            $(this).parents(".item").find(".activity-option-item").remove();
        });

    }


}

CommonModule = new CommonModule();
$(function(){
    CommonModule.init();
});
