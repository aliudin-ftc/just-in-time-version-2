<form id="powder-plastic-coat-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Code</label>
                <div class="fg-line">
                    <?php echo form_input($input['powder_plastic_coat_code']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Name</label>
                <div class="fg-line">
                    <?php echo form_input($input['powder_plastic_coat_name']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Description</label>
                <div class="fg-line">
                    <?php echo form_input($input['powder_plastic_coat_description']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Weighted Average</label>
                <div class="fg-line">
                    <?php echo form_input($input['powder_plastic_coat_weighted_ave']); ?>
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
</form>
