<div class="card-body card-padding p-b-13">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="m-t-0 job-header"><strong>Other Information</strong></h4>
        </div>
    </div>
    <div class="row">                                
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Brand</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['brand_attributes'],
                            $input['brand_options'],
                            $input['brand_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Account</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['account_attributes'],
                            $input['account_options'],
                            $input['account_selected']
                        ); 
                ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="f-500 m-b-5 c-black">Branch</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['branch_attributes'],
                            $input['branch_options'],
                            $input['branch_selected']
                        ); 
                ?>
            </div>
        </div>
    </div>  
    <div class="row">                                
        <div class="col-sm-4">
            <div class="form-group">
            <label class="f-500 m-b-5 c-black">Purchase Order No.</label>
                <div class="fg-line">
                    <?php echo form_input($input['job_order_po_no']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label class="f-500 m-b-5 c-black">Purchase Order Date</label>
                <div class="fg-line">
                    <?php echo form_input($input['job_order_po_date']); ?>
                </div>
            </div>
        </div>                                                
        <div class="col-sm-4">
            <div class="form-group">
            <label class="f-500 m-b-5 c-black">Job Order Barcode</label>
                <div class="fg-line">
                    <?php echo form_input($input['job_order_barcode']); ?>
                </div>
            </div>
        </div>
    </div>
</div> 