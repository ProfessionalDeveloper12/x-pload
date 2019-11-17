<div id="load_popup_modal_contant" class="" role="dialog">
    <div class="modal-dialog modal-lg">
        <form action="<?=BASE?>instagram/post/ajax_search_media" data-type-message="text" data-content="instagram-search-content" data-result="html" data-async role="form" class="actionForm" role="form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><i class="fa fa-search"></i> <?=lang('search_instagram_media')?></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control" name="keyword" placeholder="<?=lang('please_enter_keywork')?>">
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control" name="type">
                            <option value="tag"><?=lang('tag')?></option>
                            <option value="username"> <?=lang('username')?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn mb-1 btn-primary btn-block"><span class="fa fa-search"></span> <?=lang('search')?></button>
                    </div>
                </div>
                <div class="instagram-search-content">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("close")?></button>
            </div>
        </div>
        </form>
    </div>
</div>