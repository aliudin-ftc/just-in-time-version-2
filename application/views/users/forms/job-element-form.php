<div class="row">
    <div class="col-sm-12">
        <h4 class="job-header"><strong>General Information</strong></h4>
    </div>
</div>   
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Job Number</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_order_no']); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Job Name</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_order_name']); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Job Element No.</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_element_no']); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Product Category</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['product_category_attributes'],
                        $input['product_category_options'],
                        $input['product_category_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Sub Category</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['sub_category_attributes'],
                        $input['sub_category_options'],
                        $input['sub_category_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Packing Instructions</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['packing_instructions_attributes'],
                        $input['packing_instructions_options'],
                        $input['packing_instructions_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Elements Name</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_elements_name']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Quantity</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_elements_quantity']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Font Size</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_elements_font_size']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Unit Of Measurement</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['job_elements_font_uom_attributes'],
                        $input['job_elements_font_uom_options'],
                        $input['job_elements_font_uom_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Depth Size</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_elements_depth_size']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Unit Of Measurement</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['job_elements_depth_uom_attributes'],
                        $input['job_elements_depth_uom_options'],
                        $input['job_elements_depth_uom_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Height Size</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_elements_height_size']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Unit Of Measurement</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['job_elements_height_uom_attributes'],
                        $input['job_elements_height_uom_options'],
                        $input['job_elements_height_uom_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Delivery Location</label>
            <div class="fg-line">
                <?php echo form_textarea($input['job_elements_delivery_location']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Remarks</label>
            <div class="fg-line">
                <?php echo form_textarea($input['job_elements_remarks']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
</div>   