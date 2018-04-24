<div class="step_content">
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['width']; ?>：</div>
        <div class="step_value">
            <input type="text" name="width" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['width']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['height']; ?>：</div>
        <div class="step_value">
            <input type="text" name="height" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['height']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['depth']; ?>：</div>
        <div class="step_value">
            <input type="text" name="depth" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['depth']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['origincountry']; ?>：</div>
        <div class="step_value">
            <input type="text" name="origincountry" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['origincountry']; ?>" />
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['originplace']; ?>：</div>
        <div class="step_value">
            <input type="text" name="originplace" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['originplace']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['assemblycountry']; ?>：</div>
        <div class="step_value">
            <input type="text" name="assemblycountry" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['assemblycountry']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['barcodetype']; ?>：</div>
        <div class="step_value">
            <input type="text" name="barcodetype" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['barcodetype']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['catena']; ?>：</div>
        <div class="step_value">
            <input type="text" name="catena" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['catena']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['isbasicunit']; ?>：</div>
        <div class="step_value">
            <div class="checkbox_items">
                <div class="checkbox_item mr20">
                    <input type="radio" name="isbasicunit" class="ui-radio is_promote" id="isbasicunit_no" value="0" <?php if ($this->_var['goods']['goods_extend']['isbasicunit'] == 0): ?>checked="checked"<?php endif; ?>/>
                    <label for="isbasicunit_no" class="ui-radio-label">否</label> 
                </div>
                <div class="checkbox_item mr0">
                    <input type="radio" name="isbasicunit" class="ui-radio is_promote" id="isbasicunit_yes" value="1" <?php if ($this->_var['goods']['goods_extend']['isbasicunit'] == 1): ?>checked="checked"<?php endif; ?>/>
                    <label for="isbasicunit_yes" class="ui-radio-label">是</label> 
                </div>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['packagetype']; ?>：</div>
        <div class="step_value">
            <input type="text" name="packagetype" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['packagetype']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['grossweight']; ?>：</div>
        <div class="step_value">
            <input type="text" name="grossweight" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['grossweight']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['netweight']; ?>：</div>
        <div class="step_value">
            <input type="text" name="netweight" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['netweight']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['netcontent']; ?>：</div>
        <div class="step_value">
            <input type="text" name="netcontent" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['netcontent']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['licensenum']; ?>：</div>
        <div class="step_value">
            <input type="text" name="licensenum" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['licensenum']; ?>"/>
        </div>
    </div>
    <div class="item">
        <div class="step_label"><?php echo $this->_var['lang']['healthpermitnum']; ?>：</div>
        <div class="step_value">
            <input type="text" name="healthpermitnum" class="text" autocomplete="off" value="<?php echo $this->_var['goods']['goods_extend']['healthpermitnum']; ?>"/>
        </div>
    </div>									
</div>