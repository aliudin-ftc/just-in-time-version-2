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
                    <?php echo form_input($this->Customer_Model->form_input_attributes('customer_name', $info)); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Description</label>
                <div class="fg-line">
                    <?php echo form_input($this->Customer_Model->form_input_attributes('customer_description', $info)); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Code</label>
                <div class="fg-line">
                    <?php echo form_input($this->Customer_Model->form_input_attributes('customer_code', $info)); ?>
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
                            $this->Business_Unit_Model->form_select_attributes('business_unit_id'), 
                            $this->Business_Unit_Model->form_select_options('business_unit'),
                            $this->Business_Unit_Model->form_selected_options($info)
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
                            $this->Resources_Model->form_select_attributes('resources_id'), 
                            $this->Resources_Model->form_select_options('account executive'),
                            $this->Resources_Model->form_selected_options($info)
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
                            $this->Business_Style_Model->form_select_attributes('business_style_id'), 
                            $this->Business_Style_Model->form_select_options('business_style'),
                            $this->Business_Style_Model->form_selected_options($info)
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
                            $this->Tax_Type_Model->form_select_attributes('tax_type_id'), 
                            $this->Tax_Type_Model->form_select_options('tax_type'),
                            $this->Tax_Type_Model->form_selected_options($info)
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
                            $this->Document_Type_Model->form_select_attributes('document_type_id'), 
                            $this->Document_Type_Model->form_select_options('document_type'),
                            $this->Document_Type_Model->form_selected_options($info)
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
                            $this->Tier_Model->form_select_attributes('tier_id'), 
                            $this->Tier_Model->form_select_options('tier'),
                            $this->Tier_Model->form_selected_options($info)
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
                    <?php echo form_input($this->Customer_Model->form_input_attributes('customer_tin', $info)); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Credit Limit</label>
                <div class="fg-line">
                    <?php echo form_input($this->Customer_Model->form_input_numeric_attributes('customer_credit_limit', $info)); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Credit Note</label>
                <div class="fg-line">
                    <?php echo form_input($this->Customer_Model->form_input_attributes('customer_credit_note', $info)); ?>
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
                    <?php echo form_textarea($this->Customer_Model->form_textarea_attributes('customer_delivery_guidelines', $info)); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Remarks</label>
                <div class="fg-line">
                    <?php echo form_textarea($this->Customer_Model->form_textarea_attributes('customer_remarks', $info)); ?>
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
                        <input type="file" id="customer_logo" name="customer_logo" value="<?php echo $this->Customer_Model->form_file($info); ?>">
                    </span>
                    <a href="#" class="btn btn-danger theme-bg-2 fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
    </div>
</form>
