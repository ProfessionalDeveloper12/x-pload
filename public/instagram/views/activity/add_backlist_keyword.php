<div id="load_popup_modal_contant" class="" role="dialog">
    <div class="modal-dialog modal-md">
        <form action="javascript:void(0);" data-type-message="text" data-redirect="<?=cn("account_manager")?>" data-async role="form" class="form-horizontal" role="form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><i class="fa fa-comments"></i> <?=lang('Add_keyword_backlist')?></div>
            </div>
            <div class="modal-body m15">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb15"> 
                            <?=lang('Add_multiple_keywords_at_the_same_time_by_using_new_line_as_delimiter')?>
                        </div>
                        <textarea class="form-control textarea-keyword" rows="5"></textarea>                    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary actionAddKeyword"><?=lang('add')?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("close")?></button>
            </div>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        alert(11);
        Main.emojioneArea();
    });
</script>