<div class="row">
    <div class="col-sm-12">
        <h4 class="job-header"><strong>General Information</strong></h4>
        <input type="text" class="hidden" id="resources_id" name="resources_id" value="<?php echo (isset($template['page']['views'])) ? $template['page']['views'] : '' ; ?>"/>
    </div>
</div>   
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Firstname</label>
            <div class="fg-line">
                <?php echo form_input($input['employee_fname']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Middlename</label>
            <div class="fg-line">
                <?php echo form_input($input['employee_mname']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Lastname</label>
            <div class="fg-line">
                <?php echo form_input($input['employee_lname']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Gender</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['gender_attributes'],
                        $input['gender_options'],
                        $input['gender_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Department</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['department_attributes'],
                        $input['department_options'],
                        $input['department_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Level</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['level_attributes'],
                        $input['level_options'],
                        $input['level_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Local Mail</label>
            <div class="fg-line">
                <?php echo form_input($input['local_mail']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">TIN</label>
            <div class="fg-line">
                <?php echo form_input($input['tin']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Barcode</label>
            <div class="fg-line">
                <?php echo form_input($input['barcode']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Interest</label>
            <div class="fg-line">
                <?php echo form_textarea($input['interest']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <p class="f-500 c-black m-b-20">Profile Picture</p>
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
            <div class="m-t-10 m-b-10">
                <span class="btn btn-info btn-file theme-bg-1">
                    <span class="fileinput-new">Add Logo</span>
                    <span class="fileinput-exists">Change</span>
                    <input type="file" id="resources_logo" name="resources_logo" value="<?php echo $input['resources_file']; ?>">
                </span>
                <a href="#" class="btn btn-danger theme-bg-2 fileinput-exists" data-dismiss="fileinput">Remove</a>
            </div>
        </div>
    </div>
</div>