
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
            <label class="f-500 m-b-5 c-black">Entry Date &amp; By </label>
            <div class="fg-line disabled">
                <input type="text" class="form-control" value="25-Oct-2016 (A. Macalawi)" disabled="">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Is it free Job Order?</label>
            <div class="fg-line job-free" id="free-job-order-popover" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="<?= ($free_job_order['reasons']=='') ? 'none' : $free_job_order['reasons']; ?>" title="" data-original-title="Why Free?">
                <label class="radio radio-inline m-r-20">
                    <input type="radio" name="free_job_order" value="Yes" <?= ($free_job_order['free']=='Yes') ? 'checked' : ''; ?>>
                    <i class="input-helper"></i>
                    Yes
                </label>
                <label class="radio radio-inline m-r-20">
                    <input type="radio" name="free_job_order" value="No" <?= ($free_job_order['free']== 'No' || $free_job_order['free']== '') ? 'checked' : ''; ?>>
                    <i class="input-helper"></i>
                    No
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Job Type</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['job_type_attributes'],
                        $input['job_type_options'],
                        $input['job_type_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Job Name</label>
            <div class="fg-line">
                <?php echo form_input($input['job_order_name']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Job Status</label>
            <div class="fg-line disabled">
                <?php echo form_input($input['job_status']); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Customer</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['customer_attributes'],
                        $input['customer_options'],
                        $input['customer_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
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
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Account Executive</label>
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
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Project Manage By</label>
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
            <label class="f-500 m-b-5 c-black">Contact Person</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['contact_person_attributes'],
                        $input['contact_person_options'],
                        $input['contact_person_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div> 
    <div class="col-sm-4">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Job Order Tags</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['job_order_tags_attributes'],
                        $input['job_order_tags_options'],
                        $input['job_order_tags_selected']
                    ); 
            ?>
        </div>
    </div>
</div>
<div class="row">        
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Job Quantity</label>
            <div class="fg-line">
                <?php echo form_input($input['job_quantity']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label class="f-500 m-b-5 c-black">Unit of Measurement</label>
            <?php 
                echo 
                    form_dropdown(
                        $input['unit_of_measurement_attributes'],
                        $input['unit_of_measurement_options'],
                        $input['unit_of_measurement_selected']
                    ); 
            ?>
            <small class="help-block"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Materials</label>
            <div class="fg-line">
                <?php echo form_textarea($input['job_order_materials_description']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="f-500 m-b-5 c-black">Instructions</label>
            <div class="fg-line">
                <?php echo form_textarea($input['job_order_instructions_description']); ?>
            </div>
            <small class="help-block"></small>
        </div>
    </div>
</div>    
