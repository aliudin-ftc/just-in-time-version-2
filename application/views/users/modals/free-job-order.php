<div class="modal fade" id="free-job-order-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header theme-bg-1">
                <h4 class="modal-title c-white"><span class="billing-title">Add Reason For Free Job Order</span></h4>
            </div>
            <div class="modal-body p-t-25 p-b-0">
                <form id="free-job-order-form" method="post" enctype="multipart/form-data">
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="form-group">
                                <label class="f-500 m-b-5 c-black">JO Reasons</label>
                                <div class="fg-line">
                                    <?php echo form_textarea($input['jo_reasons']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer p-b-30 m-t-0 p-t-5">
                <button id="save-free-job-order-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
            </div>
        </div>
    </div>
</div>