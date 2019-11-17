<div class="row">
    <div class="col-md-12">
        <h3 class="head-title"><i class="ft-credit-card"></i> <?=lang('payment')?></h3>

        <span class="text"> <?=lang('environment')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_payment_environment_enable" name="payment_environment" class="filled-in chk-col-red" <?=get_option('payment_environment', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_payment_environment_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('live')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_payment_environment_disable" name="payment_environment" class="filled-in chk-col-red" <?=get_option('payment_environment', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_payment_environment_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('sandbox')?></span>
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('currency')?></span> 
            <select name="payment_currency" class="form-control">
                <option value="USD" <?=get_option('payment_currency', 'USD')=="USD"?"selected":""?>>USD</option>
                <option value="AUD" <?=get_option('payment_currency', 'USD')=="AUD"?"selected":""?>>AUD</option>
                <option value="CAD" <?=get_option('payment_currency', 'USD')=="CAD"?"selected":""?>>CAD</option>
                <option value="EUR" <?=get_option('payment_currency', 'USD')=="EUR"?"selected":""?>>EUR</option>
                <option value="ILS" <?=get_option('payment_currency', 'USD')=="ILS"?"selected":""?>>ILS</option>
                <option value="NZD" <?=get_option('payment_currency', 'USD')=="NZD"?"selected":""?>>NZD</option>
                <option value="RUB" <?=get_option('payment_currency', 'USD')=="RUB"?"selected":""?>>RUB</option>
                <option value="SGD" <?=get_option('payment_currency', 'USD')=="SGD"?"selected":""?>>SGD</option>
                <option value="SEK" <?=get_option('payment_currency', 'USD')=="SEK"?"selected":""?>>SEK</option>
                <option value="BRL" <?=get_option('payment_currency', 'USD')=="BRL"?"selected":""?>>BRL</option>
                <option value="MXN" <?=get_option('payment_currency', 'USD')=="MXN"?"selected":""?>>MXN</option>
                <option value="THB" <?=get_option('payment_currency', 'USD')=="THB"?"selected":""?>>THB</option>
                <option value="JPY" <?=get_option('payment_currency', 'USD')=="JPY"?"selected":""?>>JPY</option>
                <option value="MYR" <?=get_option('payment_currency', 'USD')=="MYR"?"selected":""?>>MYR</option>
                <option value="PHP" <?=get_option('payment_currency', 'USD')=="PHP"?"selected":""?>>PHP</option>
                <option value="TWD" <?=get_option('payment_currency', 'USD')=="TWD"?"selected":""?>>TWD</option>
                <option value="CZK" <?=get_option('payment_currency', 'USD')=="CZK"?"selected":""?>>CZK</option>
                <option value="PLN" <?=get_option('payment_currency', 'USD')=="PLN"?"selected":""?>>PLN</option>
                <option value="VND" <?=get_option('payment_currency', 'USD')=="VND"?"selected":""?>>VND</option>
                <option value="GBP" <?=get_option('payment_currency', 'USD')=="GBP"?"selected":""?>>GBP</option>
                <option value="CHF" <?=get_option('payment_currency', 'USD')=="CHF"?"selected":""?>>CHF</option>
                <option value="NGN" <?=get_option('payment_currency', 'USD')=="NGN"?"selected":""?>>NGN</option>
                <option value="HUF" <?=get_option('payment_currency', 'USD')=="HUF"?"selected":""?>>HUF</option>
                
            </select>
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('symbol')?></span> 
            <input type="text" class="form-control" name="payment_symbol" value="<?=get_option('payment_symbol', '$')?>">
        </div>

        <?=Modules::run("payment/block_payments", "block_settings")?>
    </div>
</div>