<div class="modal fade" id="contact-line-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header theme-bg-1">
                <h4 class="modal-title c-white"><span class="contact-title">Add New Contact Line</span> (<span class="contact-line-id-no"></span>)</h4>
            </div>
            <div class="modal-body p-t-25 p-b-0">
                <form id="contact-line-form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="f-500 m-b-5 c-black">Phone</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['phone_number']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Mobile</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['mobile_number']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="f-500 m-b-5 c-black">Fax</label>
                                <div class="fg-line">
                                    <?php echo form_input($input['fax_number']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer p-b-30 m-t-0 p-t-5">
                <button id="save-contact-line-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
                <button id="close-contact-line-btn" type="button" class="btn btn-link btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>