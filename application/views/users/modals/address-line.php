<div class="modal fade" id="address-line-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header theme-bg-1">
                <h4 class="modal-title c-white"><span class="address-title">Add New Address Line</span> (<span class="address-line-id-no"></span>)</h4>
            </div>
            <div class="modal-body p-t-25 p-b-0">
                <form id="address-line-form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Province</label>
                                    <?php 
                                        echo 
                                            form_dropdown(
                                                $input['province_attributes'],
                                                $input['province_options'],
                                                $input['province_selected']
                                            ); 
                                    ?>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">City</label>
                                <div class="fg-line">
                                    <?php 
                                        echo 
                                            form_dropdown(
                                                $input['city_attributes'],
                                                $input['city_options'],
                                                $input['city_selected']
                                            ); 
                                    ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Barangay</label>
                                <div class="fg-line">
                                    <?php 
                                        echo 
                                            form_dropdown(
                                                $input['barangay_attributes'],
                                                $input['barangay_options'],
                                                $input['barangay_selected']
                                            ); 
                                    ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Block</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['block']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Street</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['street']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="f-500 m-b-5 c-black">Region</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['region']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer p-b-30 m-t-0 p-t-5">
                <button id="save-address-line-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
                <button id="close-address-line-btn" type="button" class="btn btn-link btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>