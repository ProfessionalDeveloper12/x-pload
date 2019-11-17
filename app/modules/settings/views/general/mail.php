<div class="row">
    <div class="col-md-12">
    	<h3 class="head-title"><i class="fa fa-envelope-o"></i> <?=lang('mail')?></h3>

        <div class="lead"> <?=lang('general_settings')?></div>
        <div class="form-group">
            <span class="text"> Email from</span> 
            <input type="text" class="form-control" name="email_from" value="<?=get_option('email_from', '')?>">
        </div>
        <div class="form-group">
            <span class="text"> Your name</span> 
            <input type="text" class="form-control" name="email_name" value="<?=get_option('email_name', '')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('email_protocol')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_email_protocol_mail" name="email_protocol_type" class="filled-in chk-col-red" <?=get_option('email_protocol_type', 'mail')=='mail'?"checked":""?> value="mail">
                <label class="p0 m0" for="md_checkbox_email_protocol_mail">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('mail')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_email_protocol_smpt" name="email_protocol_type" class="filled-in chk-col-red" <?=get_option('email_protocol_type', 'smtp')=='smtp'?"checked":""?> value="smtp">
                <label class="p0 m0" for="md_checkbox_email_protocol_smpt">&nbsp;</label>
                <span class="checkbox-text-right"> SMTP</span>
            </div>
        </div>
        <div class="form_smtp hide"> 
            <div class="form-group">
                <span class="text">  <?=lang('smtp_server')?></span> 
                <input type="text" class="form-control" name="email_smtp_server" value="<?=get_option('email_smtp_server', '')?>">
            </div>
            <div class="form-group">
                <span class="text">  <?=lang('smtp_port')?></span> 
                <input type="text" class="form-control" name="email_smtp_port" value="<?=get_option('email_smtp_port', '')?>">
            </div>
            <div class="form-group">
                <span class="text">  <?=lang('smtp_encryption')?></span> 
                <select name="email_smtp_encryption" class="form-control">
                    <option value="">None</option>
                    <option value="tls" <?=get_option('email_smtp_encryption', '') == "tls"?"selected":""?> >TLS</option>
                    <option value="ssl" <?=get_option('email_smtp_encryption', '') == "ssl"?"selected":""?> >SSL</option>
                </select>
            </div>
            <div class="form-group">
                <span class="text">  <?=lang('smtp_username')?></span> 
                <input type="text" class="form-control" name="email_smtp_username" value="<?=get_option('email_smtp_username', '')?>">
            </div>
            <div class="form-group">
                <span class="text">  <?=lang('smtp_password')?></span> 
                <input type="text" class="form-control" name="email_smtp_password" value="<?=get_option('email_smtp_password', '')?>">
            </div>
        </div>

        <script type="text/javascript">
            $(function(){
                $type = $("[name='email_protocol_type']:checked").val();
                if($type == "smtp"){
                    $(".form_smtp").removeClass("hide");
                }else{
                    $(".form_smtp").addClass("hide");
                }

                $("[name='email_protocol_type']").change(function(){
                    $type = $("[name='email_protocol_type']:checked").val();
                    if($type == "smtp"){
                        $(".form_smtp").removeClass("hide");
                    }else{
                        $(".form_smtp").addClass("hide");
                    }
                }); 
            });
        </script>
        <div class="lead"> <?=lang('email_notifications')?></div>
        <div class="form-group">
            <span class="text"> <?=lang('welcome_email')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_email_welcome_enable" name="email_welcome_enable" class="filled-in chk-col-red" <?=get_option('email_welcome_enable', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_email_welcome_enable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_email_welcome_disable" name="email_welcome_enable" class="filled-in chk-col-red" <?=get_option('email_welcome_enable', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_email_welcome_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('payment_email')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_email_payment_enable" name="email_payment_enable" class="filled-in chk-col-red" <?=get_option('email_payment_enable', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_email_payment_enable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_email_payment_disable" name="email_payment_enable" class="filled-in chk-col-red" <?=get_option('email_payment_enable', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_email_payment_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>

        <div class="lead"> <?=lang('email_template')?></div>
        <h5 class="uc" style="color: #2196f3;"> <?=lang('activation_email')?></h5>
        <div class="form-group">
            <span class="text">  <?=lang('subject')?></span> 
            <input type="text" class="form-control" name="email_activation_subject" value="<?=get_option('email_activation_subject',getEmailTemplate('activate')->subject)?>">
        </div>
        <div class="form-group">
            <span class="text">  <?=lang('content')?></span> 
            <textarea class="form-control" style="height: 100px;" name="email_activation_content"><?=get_option('email_activation_content',getEmailTemplate('activate')->content)?></textarea>
        </div>
        
        <h5 class="uc" style="margin-top: 35px; color: #2196f3;">  <?=lang('new_customers')?> (Welcome email)</h5>
        <div class="form-group">
            <span class="text">  <?=lang('subject')?></span> 
            <input type="text" class="form-control" name="email_new_customers_subject" value="<?=get_option('email_new_customers_subject', getEmailTemplate('welcome')->subject)?>">
        </div>
        <div class="form-group">
            <span class="text">  <?=lang('content')?></span> 
            <textarea class="form-control" style="height: 100px;" name="email_new_customers_content"><?=get_option('email_new_customers_content', getEmailTemplate('welcome')->content)?></textarea>
        </div>

        <h5 class="uc" style="color: #2196f3; margin-top: 35px;"> <?=lang('forgot_password')?></h5>
        <div class="form-group">
            <span class="text">  <?=lang('subject')?></span> 
            <input type="text" class="form-control" name="email_forgot_password_subject" value="<?=get_option('email_forgot_password_subject', getEmailTemplate('forgot_password')->subject)?>">
        </div>
        <div class="form-group">
            <span class="text">  <?=lang('content')?></span> 
            <textarea class="form-control" style="height: 100px;" name="email_forgot_password_content"><?=get_option('email_forgot_password_content', getEmailTemplate('forgot_password')->content)?></textarea>
        </div>

        <h5 class="uc" style="margin-top: 35px; color: #2196f3;">  <?=lang('renewal_reminders')?></h5>
        <div class="form-group">
            <span class="text">  <?=lang('subject')?></span> 
            <input type="text" class="form-control" name="email_renewal_reminders_subject" value="<?=get_option('email_renewal_reminders_subject', getEmailTemplate('reminder')->subject)?>">
        </div>
        <div class="form-group">
            <span class="text">  <?=lang('content')?></span> 
            <textarea class="form-control" style="height: 100px;" name="email_renewal_reminders_content"><?=get_option('email_renewal_reminders_content', getEmailTemplate('reminder')->content)?></textarea>
        </div>

        <h5 class="uc" style="margin-top: 35px; color: #2196f3;"> <?=lang('payment_email')?> </h5>
        <div class="form-group">
            <span class="text">  <?=lang('subject')?></span> 
            <input type="text" class="form-control" name="email_payment_subject" value="<?=get_option('email_payment_subject', getEmailTemplate('payment')->subject)?>">
        </div>
        <div class="form-group">
            <span class="text">  <?=lang('content')?></span> 
            <textarea class="form-control" style="height: 100px;" name="email_payment_content"><?=get_option('email_payment_content', getEmailTemplate('payment')->content)?></textarea>
        </div>

        <?=Modules::run("team/block_email")?>

        <div class="small">
            <?=lang('you_can_use_following_template_tags_within_the_message_template')?>:<br/> 
            {full_name} - <?=lang('displays_the_user_fullname')?>,<br/> 
            {email} - <?=lang('displays_the_user_email')?>,<br/> 
            {days_left} - <?=lang('displays_the_remaining_days')?>,<br/> 
            {expiration_date} - <?=lang('displays_the_expiration_date')?>,<br/> 
            {free_trial} - <?=lang('displays_the_trial_days')?>.
        </div>

    </div>
</div>