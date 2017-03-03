<form id="painting-cost-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Code</label>
                <div class="fg-line">
                    <?php echo form_input($input['code']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Name</label>
                <div class="fg-line">
                    <?php echo form_input($input['name']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Description</label>
                <div class="fg-line">
                    <?php echo form_input($input['description']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Cost</label>
                <div class="fg-line">
                    <?php echo form_input($input['cost']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
</form>
