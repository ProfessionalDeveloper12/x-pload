<div class="lead"> <?=lang('auto_activity')?></div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div>
                <div class="pure-checkbox grey mr15 mb15">
                    <?=lang("save_log_within_day")?>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <select class="form-control" name="igac_save_log">
                        <?php for ($i=0; $i <= 365; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_save_log', 7)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <span class="small info"><?=lang('Set_zero_to_unlimited')?></span>
            </div>
        </div>
    </div>

	<div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_to_do')?></p>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="hidden" name="igac_enable_like" value="0">
                <input type="checkbox" id="md_checkbox_igac_enable_like" name="igac_enable_like" class="filled-in chk-col-red" <?=get_option('igac_enable_like', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_igac_enable_like">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('likes')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="hidden" name="igac_enable_comment" value="0">
                <input type="checkbox" id="md_checkbox_igac_enable_comment" name="igac_enable_comment" class="filled-in chk-col-red" <?=get_option('igac_enable_comment', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_igac_enable_comment">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('comments')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="hidden" name="igac_enable_follow" value="0">
                <input type="checkbox" id="md_checkbox_igac_enable_follow" name="igac_enable_follow" class="filled-in chk-col-red" <?=get_option('igac_enable_follow', 0)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_igac_enable_follow">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('follows')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="hidden" name="igac_enable_unfollow" value="0">
                <input type="checkbox" id="md_checkbox_igac_enable_unfollow" name="igac_enable_unfollow" class="filled-in chk-col-red" <?=get_option('igac_enable_unfollow', 0)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_igac_enable_unfollow">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('unfollows')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="hidden" name="igac_enable_direct_message" value="0">
                <input type="checkbox" id="md_checkbox_igac_enable_direct_message" name="igac_enable_direct_message" class="filled-in chk-col-red" <?=get_option('igac_enable_direct_message', 0)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_igac_enable_direct_message">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('direct_messages')?></span>
            </div>
        </div>
	</div>

    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_target')?></p>
            <div>
                <div class="pure-checkbox grey mr15 mb15">
                    <input type="hidden" name="igac_target_tag" value="0">
                    <input type="checkbox" id="md_checkbox_igac_target_tag" name="igac_target_tag" class="filled-in chk-col-red" <?=get_option('igac_target_tag', 1)==1?"checked":""?> value="1">
                    <label class="p0 m0" for="md_checkbox_igac_target_tag">&nbsp;</label>
                    <span class="checkbox-text-right"> <?=lang('tags')?></span>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <input type="hidden" name="igac_target_location" value="0">
                    <input type="checkbox" id="md_checkbox_igac_target_location" name="igac_target_location" class="filled-in chk-col-red" <?=get_option('igac_target_location', 0)==1?"checked":""?> value="1">
                    <label class="p0 m0" for="md_checkbox_igac_target_location">&nbsp;</label>
                    <span class="checkbox-text-right"> <?=lang('locations')?></span>
                </div><br/>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Followers')?></span>
                    <select class="form-control" name="igac_target_follower">
                        <option value="" <?=get_option('igac_target_follower', "")==""?"selected":""?>>-</option>
                        <option value="user" <?=get_option('igac_target_follower', "")=="user"?"selected":""?>><?=lang('usernames')?></option>
                        <option value="me" <?=get_option('igac_target_follower', "")=="me"?"selected":""?>><?=lang('My_account')?></option>
                        <option value="all" <?=get_option('igac_target_follower', "")=="all"?"selected":""?>><?=lang('all')?></option>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Followings')?></span>
                    <select class="form-control" name="igac_target_following">
                        <option value="" <?=get_option('igac_target_following', "")==""?"selected":""?>>-</option>
                        <option value="user" <?=get_option('igac_target_following', "")=="user"?"selected":""?>><?=lang('usernames')?></option>
                        <option value="me" <?=get_option('igac_target_following', "")=="me"?"selected":""?>><?=lang('My_account')?></option>
                        <option value="all" <?=get_option('igac_target_following', "")=="all"?"selected":""?>><?=lang('all')?></option>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Likers')?></span>
                    <select class="form-control" name="igac_target_liker">
                        <option value="" <?=get_option('igac_target_liker', "")==""?"selected":""?>>-</option>
                        <option value="user" <?=get_option('igac_target_liker', "")=="user"?"selected":""?>><?=lang('Usernames_posts')?></option>
                        <option value="me" <?=get_option('igac_target_liker', "")=="me"?"selected":""?>><?=lang('My_posts')?></option>
                        <option value="all" <?=get_option('igac_target_liker', "")=="all"?"selected":""?>><?=lang('all')?></option>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Commenters')?></span>
                    <select class="form-control" name="igac_target_commenter">
                        <option value="" <?=get_option('igac_target_commenter', "")==""?"selected":""?>>-</option>
                        <option value="user" <?=get_option('igac_target_commenter', "")=="user"?"selected":""?>><?=lang('Usernames_posts')?></option>
                        <option value="me" <?=get_option('igac_target_commenter', "")=="me"?"selected":""?>><?=lang('My_posts')?></option>
                        <option value="" <?=get_option('igac_target_commenter', "")=="all"?"selected":""?>><?=lang('all')?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_speed')?></p>
            <div>
                <div class="pure-checkbox grey mr15 mb15" style="width: 57px;">
                    <strong><?=lang('Level')?></strong>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <select class="form-control" name="igac_speed_level">
                        <option value="slow" <?=get_option('igac_speed_level', "normal")=="slow"?"selected":""?>><?=lang('Slow')?></option>
                        <option value="normal" <?=get_option('igac_speed_level', "normal")=="normal"?"selected":""?>><?=lang('Normal')?></option>
                        <option value="fast" <?=get_option('igac_speed_level', "normal")=="fast"?"selected":""?>><?=lang('Fast')?></option>
                    </select>
                </div>
            </div>
            <div>
                <div class="pure-checkbox grey mr15 mb15" style="width: 57px;">
                    <strong><?=lang('Slow')?></strong>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Likes/hour')?></span>
                    <select class="form-control" name="igac_speed_slow_like">
                        <?php for ($i=1; $i <= 60; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_slow_like', 2)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Comments/hour')?></span>
                    <select class="form-control" name="igac_speed_slow_comment">
                        <?php for ($i=1; $i <= 20; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_slow_comment', 3)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Follows/hour')?></span>
                    <select class="form-control" name="igac_speed_slow_follow">
                        <?php for ($i=1; $i <= 40; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_slow_follow', 3)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Unfollows/hour')?></span>
                    <select class="form-control" name="igac_speed_slow_unfollow">
                        <?php for ($i=1; $i <= 40; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_slow_unfollow', 3)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Direct_messages/hour')?></span>
                    <select class="form-control" name="igac_speed_slow_direct_message">
                        <?php for ($i=1; $i <= 20; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_slow_direct_message', 1)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Repost_medias/day')?></span>
                    <select class="form-control" name="igac_speed_slow_repost_media">
                        <?php for ($i=1; $i <= 20; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_slow_repost_media', 1)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div>
                <div class="pure-checkbox grey mr15 mb15" style="width: 57px;">
                    <strong><?=lang('Normal')?></strong>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Likes/hour')?></span>
                    <select class="form-control" name="igac_speed_normal_like">
                        <?php for ($i=1; $i <= 60; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_normal_like', 4)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Comments/hour')?></span>
                    <select class="form-control" name="igac_speed_normal_comment">
                        <?php for ($i=1; $i <= 20; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_normal_comment', 4)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Follows/hour')?></span>
                    <select class="form-control" name="igac_speed_normal_follow">
                        <?php for ($i=1; $i <= 40; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_normal_follow', 5)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Unfollows/hour')?></span>
                    <select class="form-control" name="igac_speed_normal_unfollow">
                        <?php for ($i=1; $i <= 40; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_normal_unfollow', 5)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Direct_messages/hour')?></span>
                    <select class="form-control" name="igac_speed_normal_direct_message">
                        <?php for ($i=1; $i <= 20; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_normal_direct_message', 2)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Repost_medias/day')?></span>
                    <select class="form-control" name="igac_speed_normal_repost_media">
                        <?php for ($i=1; $i <= 5; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_normal_repost_media', 2)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div>
                <div class="pure-checkbox grey mr15 mb15" style="width: 57px;">
                    <strong><?=lang('Fast')?></strong>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Likes/hour')?></span>
                    <select class="form-control" name="igac_speed_fast_like">
                        <?php for ($i=1; $i <= 60; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_fast_like', 6)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Comments/hour')?></span>
                    <select class="form-control" name="igac_speed_fast_comment">
                        <?php for ($i=1; $i <= 20; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_fast_comment', 5)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Follows/hour')?></span>
                    <select class="form-control" name="igac_speed_fast_follow">
                        <?php for ($i=1; $i <= 40; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_fast_follow', 7)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Unfollows/hour')?></span>
                    <select class="form-control" name="igac_speed_fast_unfollow">
                        <?php for ($i=1; $i <= 40; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_fast_unfollow', 7)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Direct_messages/hour')?></span>
                    <select class="form-control" name="igac_speed_fast_direct_message">
                        <?php for ($i=1; $i <= 20; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_fast_direct_message', 3)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-checkbox grey mr15 mb15">
                    <span> <?=lang('Repost_medias/day')?></span>
                    <select class="form-control" name="igac_speed_fast_repost_media">
                        <?php for ($i=1; $i <= 5; $i++) {?>
                        <option value="<?=$i?>" <?=get_option('igac_speed_fast_repost_media', 3)==$i?"selected":""?>><?=$i?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang("Default_filter")?></p>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="hidden" name="igac_enable_filter" value="0">
                <input type="checkbox" id="md_checkbox_igac_enable_filter" name="igac_enable_filter" class="filled-in chk-col-red" <?=get_option('igac_enable_filter', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_igac_enable_filter">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang("Enable")?></span>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_repost_media_caption')?></p>
            <div>
                <textarea class="form-control" rows="5" name="igac_repost_media"><?=get_option('igac_repost_media', '{{caption}}')?></textarea>

                <ul class="small" style="padding-left: 20px; padding-top: 10px;">
                    <li style="list-style: disc outside;"><?=lang("you_can_use_following_variables_in_the_caption_desc_note")?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_comments')?></p>
            <div>
                <textarea class="form-control" rows="5" name="igac_comments"><?=get_option('igac_comments', "Made my day\nTotally rocks!\nVery nice\nVery sweet :)\nThis is great\nSo cool\nFascinating one\nNeat-o!\nGorgeous! Love it!\nThe cutest\nBreathtaking one\nThis is awesome :)\nOutstanding one!\nWhoopee!\nMy Goodness\nThis is awesome!")?></textarea>

                <ul class="small" style="padding-left: 20px; padding-top: 10px;">
                    <li style="list-style: disc outside;"><?=lang("Add_multiple_comments_at_the_same_time_by_using_new_line_as_delimiter_You_also_can_use_spintax_spinning_format_in_your_comments")?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_direct_messages')?></p>
            <div>
                <textarea class="form-control" rows="5" name="igac_direct_messages"><?=get_option('igac_direct_messages', "Hello {{username}}, How are you?\nHi {{username}}, How are you today?\nHi {{username}}, Hey, how's it going?\nHello {{username}}, What's up?")?></textarea>

                <ul class="small" style="padding-left: 20px; padding-top: 10px;">
                    <li style="list-style: disc outside;"><?=lang("you_can_use_following_variables_in_the_messages_desc_note")?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_tags')?></p>
            <div>
                <textarea class="form-control" rows="5" name="igac_tags"><?=get_option('igac_tags', "author\nvacation\ninstaart\nnature\ntasty\nmasterpiece\ncreative\nbestoftheday\npretty\nsiblings\nclouds\npage\nthrowbackthursday\ncuddle\ninstafollow\nlovely\nshoutout\ncute\ndraw")?></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_tags_blacklist')?></p>
            <div>
                <textarea class="form-control" rows="5" name="igac_tags_blacklist"><?=get_option('igac_tags_blacklist', "sex\nxxx\nfuckyou\nvideoxxx\nnude")?></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <p class="text"> <?=lang('Default_keywords_blacklist')?></p>
            <div>
                <textarea class="form-control" rows="5" name="igac_keywords_blacklist"><?=get_option('igac_keywords_blacklist', "sex\nfuck now\nnude")?></textarea>
            </div>
        </div>
    </div>
</div>