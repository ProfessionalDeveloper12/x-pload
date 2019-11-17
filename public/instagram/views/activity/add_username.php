<div id="load_popup_modal_contant" class="instagram-app" role="dialog">
    <div class="modal-dialog modal-md">
        <form action="<?=cn("instagram/activity/search/username/".segment(5))?>" data-type-message="text" data-redirect="<?=cn("account_manager")?>" data-content="box-search-username-content" data-result="html" data-async role="form" class="form-horizontal actionForm" role="form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><i class="ft-user"></i> <?=lang('Add_usernames')?></div>
            </div>
            <div class="modal-body m15">
                <div class="row">
                    <div class="col-sm-12 mb15">
                        <div class="input-group input-group-with-gap">
                            <input type="text" name="k" class="form-control input-icon input-icon-tag js-inp-search" maxlength="100" placeholder=" <?=lang('username')?>" autofocus="">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-plain btn-success js-btn-search">  <?=lang('search')?></button>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-12 box-search-username-content">
                        <div class="dataTables_empty"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary actionAddUsername"><?=lang('add')?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("close")?></button>
            </div>
        </div>
        </form>
    </div>
</div>
users
<script type="text/javascript">
    $(function(){
        $(document).on("click", ".ig-hide-tag-option-2", function(){ 
            $(".ig-tag-option-2").removeClass("hide");  
            $(".ig-tag-option-1").addClass("hide"); 
        });
        $(document).on("click", ".ig-hide-tag-option-1", function(){ 
            $(".ig-tag-option-2").addClass("hide"); 
            $(".ig-tag-option-1").removeClass("hide"); 
        });
    });
</script>