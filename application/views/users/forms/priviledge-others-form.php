<div class="row">
    <div class="col-sm-12">
        <h4 class="job-header"><strong>Select Priviledges</strong></h4>
        <span class="help-block checkbox-priviledge m-l-30" style="display:inline"></span>
    </div>
</div>   
<div class="row">
    <?php foreach ($input['modules'] as $key => $module) { ?>
        <div class="col-sm-6 layers">
            <div class="checkbox m-b-15">
                <label>
                    <input class="mods" name="priviledges[]" id="priviledges" type="checkbox" <?php echo ($module['checked'] == 1) ? "checked='checked'" : ""; ?> value="<?php echo $module['modules_id'].','.'mods'; ?>">
                    <i class="input-helper"></i>
                    <?php echo $module['modules_name']; ?>
                </label>
            </div>

            <?php if( ($module['modules_id'] !=  1) && ($module['modules_id'] !=  2) ) { ?>
            <?php foreach ($module['modules'] as $keys => $value) { ?>
                <div class="p-l-30 checkbox m-b-15 subs">
                    <label>
                        <input class="subs" name="priviledges[]" id="priviledges" type="checkbox" <?php echo ($value['checked'] == 1) ? "checked='checked'" : ""; ?> value="<?php echo $module['modules_id'].','.$value['sub_modules_id']; ?>">
                        <i class="input-helper"></i>
                        <?php echo $value['sub_modules_name']; ?>
                    </label>
                </div>
            <?php } } ?>
        </div>
    <?php } ?>
</div>