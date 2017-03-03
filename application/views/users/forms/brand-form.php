<form id="brand-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Customer Name</label>
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
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Brand Name</label>
                <div class="fg-line">
                    <?php echo form_input($input['brand_name']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Brand Description</label>
                <div class="fg-line">
                    <?php echo form_input($input['brand_description']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
</form>
