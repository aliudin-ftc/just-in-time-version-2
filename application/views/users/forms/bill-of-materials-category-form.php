<form id="bill-of-materials-category-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Bill of Materials Category Code</label>
                <div class="fg-line">
                    <?php echo form_input($input['bill_of_materials_category_code']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Bill of Materials Category Name</label>
                <div class="fg-line">
                    <?php echo form_input($input['bill_of_materials_category_name']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Bill of Materials Category Description</label>
                <div class="fg-line">
                    <?php echo form_input($input['bill_of_materials_category_description']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
</form>
