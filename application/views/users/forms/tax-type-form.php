<form id="tax-type-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Tax Type Code</label>
                    <?php echo form_input($input['tax_type_code']); ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Tax Type Name</label>
                <div class="fg-line">
                    <?php echo form_input($input['tax_type_name']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Tax Type Description</label>
                <div class="fg-line">
                    <?php echo form_input($input['tax_type_description']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
</form>
