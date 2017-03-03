<form id="job-request-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
            <input type="text" class="hidden" id="job_request_module_id" name="job_request_module_id" value="<?php echo (isset($template['page']['request_no'])) ? $template['page']['request_no'] : 'none' ; ?>"/>
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
                <label class="f-500 m-b-5 c-black">Job Status</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['job_status_attributes'],
                            $input['job_status_options'],
                            $input['job_status_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Job Request</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['job_request_attributes'],
                            $input['job_request_options'],
                            $input['job_request_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Job Request Type</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['job_request_type_attributes'],
                            $input['job_request_type_options'],
                            $input['job_request_type_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Job Request Sequence Number</label>
                <input type="text" name="job_request_sequence" value="<?php echo (isset($template['page']['sequence_no'])) ? $template['page']['sequence_no'] : '0' ; ?>" id="job_request_sequence" class="form-control input-md" disabled="disabled" placeholder="insert job order no here">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Job Request Category</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['job_request_category_attributes'],
                            $input['job_request_category_options'],
                            $input['job_request_category_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Job Request Quantity</label>
                <div class="fg-line">
                    <?php echo form_input($input['job_request_quantity']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Endorsed To</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['job_request_endorsed_to_attributes'],
                            $input['job_request_endorsed_to_options'],
                            $input['job_request_endorsed_to_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Job Request Date</label>
                <div class="fg-line">
                    <?php echo form_input($input['job_request_date']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Job Due Date</label>
                <div class="fg-line">
                    <?php echo form_input($input['job_request_due_date']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">        
        <div class="col-sm-6">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Instructions</label>
                <div class="fg-line">
                    <?php echo form_textarea($input['job_request_instructions']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Attachments</label>
                <div class="fg-line">
                    <?php echo form_textarea($input['job_request_attachments']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>  
</form>