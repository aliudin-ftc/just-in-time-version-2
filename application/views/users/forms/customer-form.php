<form id="customer-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Name</label>
                <div class="fg-line">
                    <?php echo form_input($input['customer_name']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Description</label>
                <div class="fg-line">
                    <?php echo form_input($input['customer_description']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Code</label>
                <div class="fg-line">
                    <?php echo form_input($input['customer_code']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Business Unit</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['business_unit_attributes'],
                            $input['business_unit_options'],
                            $input['business_unit_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Accounting Executive</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['resources_attributes'],
                            $input['resources_options'],
                            $input['resources_selected']
                        );  
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Business Style</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['business_style_attributes'],
                            $input['business_style_options'],
                            $input['business_style_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Tax Type</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['tax_type_attributes'],
                            $input['tax_type_options'],
                            $input['tax_type_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Document Type</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['document_type_attributes'],
                            $input['document_type_options'],
                            $input['document_type_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Tier</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['tier_attributes'],
                            $input['tier_options'],
                            $input['tier_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">TIN</label>
                <div class="fg-line">
                    <?php echo form_input($input['customer_tin']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Credit Limit</label>
                <div class="fg-line">
                    <?php echo form_input($input['customer_credit_limit']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Credit Note</label>
                <div class="fg-line">
                    <?php echo form_input($input['customer_credit_note']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">        
        <div class="col-sm-6">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Delivery Guidelines</label>
                <div class="fg-line">
                    <?php echo form_textarea($input['customer_delivery_guidelines']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Remarks</label>
                <div class="fg-line">
                    <?php echo form_textarea($input['customer_remarks']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <p class="f-500 c-black m-b-20">Logo</p>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                <div class="m-t-10 m-b-10">
                    <span class="btn btn-info btn-file theme-bg-1">
                        <span class="fileinput-new">Add Logo</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" id="customer_logo" name="customer_logo" value="<?php echo $input['customer_file']; ?>">
                    </span>
                    <a href="#" class="btn btn-danger theme-bg-2 fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
    </div>
</form>
