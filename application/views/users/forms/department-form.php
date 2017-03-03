<form id="department-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Department Code</label>
                <div class="fg-line">
                    <?php echo form_input($input['department_code']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Department Name</label>
                <div class="fg-line">
                    <?php echo form_input($input['department_name']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Department Description</label>
                <div class="fg-line">
                    <?php echo form_input($input['department_description']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
</form>
