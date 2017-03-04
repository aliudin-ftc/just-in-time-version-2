<div class="modal fade" id="billing-line-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header theme-bg-1">
                <h4 class="modal-title c-white"><span class="billing-title">Add New Billing Line</span> (<span class="billing-line-job-no"></span>)</h4>
            </div>
            <div class="modal-body p-t-25 p-b-0">
                <form id="billing-line-form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="text-uppercase m-t-0">Billing Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Bill to</label>
                                    <?php 
                                        echo 
                                            form_dropdown(
                                                $input['bill_to_attributes'],
                                                $input['bill_to_options'],
                                                $input['bill_to_selected']
                                            ); 
                                    ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Discount</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['billing_discount']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Billing Quantity</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['billing_quantity']); ?>
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
                                                $input['job_uom_attributes'],
                                                $input['job_uom_options'],
                                                $input['job_uom_selected']
                                            ); 
                                    ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer p-b-30 m-t-0 p-t-5">
                <button id="save-billing-line-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
                <button id="close-billing-line-btn" type="button" class="btn btn-link btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>