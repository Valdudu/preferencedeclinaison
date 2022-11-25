<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <h2>Préférences de disponibilité</h2>
        </div>
        <div class="col-md-12">
            <label class="form-control-label">Comportement si rupture de stock</label>     
            <div id="form_step3_out_of_stock"><div class="radio">                                          
                <label class=""><input type="radio" id="form_step3_out_of_stock_0" name="pref_{$id_product_attribute}" value="0" {if $combination == 0} checked="checked" {/if}>
                    Refuser les commandes
                </label>
            </div>
            <div class="radio">                                          
                <label class=""><input type="radio" id="form_step3_out_of_stock_1" name="pref_{$id_product_attribute}" value="1" {if $combination == 1} checked="checked" {/if}>
                    Accepter les commandes
                </label>
            </div>
            <div class="radio">                                          
                <label class=""><input type="radio" id="form_step3_out_of_stock_2" name="pref_{$id_product_attribute}" value="2" {if $combination == 2} checked="checked" {/if}>
                    Utiliser le comportement parent
                </label>
            </div>
        </div>
    </div>
</div>