<div class="row">
    <div class="col-sm-12">
        <h4 class="job-header"><strong>Contact Person Information</strong></h4>
    </div>
</div>   
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Firstname</label>
            <div class="fg-line">
                <?php echo form_input($input['contact_person_firstname']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Middlename</label>
            <div class="fg-line">
                <?php echo form_input($input['contact_person_middlename']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Lastname</label>
            <div class="fg-line">
                <?php echo form_input($input['contact_person_lastname']); ?>
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
                        $input['contact_person_gender_attributes'],
                        $input['contact_person_gender_options'],
                        $input['contact_person_gender_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Position</label>
            <div class="fg-line">
                <?php echo form_input($input['contact_person_position']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Birthdate</label>
            <div class="fg-line">
                <?php echo form_input($input['contact_person_birthdate']); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">        
    <div class="col-sm-6">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Interest</label>
            <div class="fg-line">
                <?php echo form_textarea($input['contact_person_interest']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Remarks</label>
            <div class="fg-line">
                <?php echo form_textarea($input['contact_person_remarks']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
</div>