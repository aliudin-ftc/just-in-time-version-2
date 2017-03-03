<div class="modal fade" id="assign-estimate-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="assign-estimate-form" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header theme-bg-1">
                    <h4 class="modal-title c-white"><span class="billing-title">Assign Estimator for Job Request</span> (<span class="assign-id-no"></span>)</h4>
                </div>
                <div class="modal-body p-t-25 p-b-0">
                    <div class="row">
                       <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Assign to</label>
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
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Start Date &amp; Time</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['job_request_module_assigned_start_date']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Remarks</label>
                                <div class="fg-line">
                                    <?php echo form_textarea($input['job_request_module_assigned_remarks']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-b-30 m-t-0 p-t-5">
                    <button id="save-assign-estimate-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
                    <button id="close-btn" type="button" class="btn btn-link btn-close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>