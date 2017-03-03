<div class="modal fade" id="disapprove-job-request-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="disapprove-job-request-form" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header theme-bg-1">
                    <h4 class="modal-title c-white"><span class="billing-title">Add a reason for disapproving job request</span> (<span class="disapprove-id-no"></span>) <span class="required-status hidden"></span></h4>
                </div>
                <div class="modal-body p-t-25 p-b-0">
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Why Disapproved?</label>
                                <div class="fg-line">
                                    <?php echo form_textarea($input['disapproved_reason']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-b-30 m-t-0 p-t-5">
                    <button id="save-disapprove-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
                    <button id="close-btn" type="button" class="btn btn-link btn-close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>