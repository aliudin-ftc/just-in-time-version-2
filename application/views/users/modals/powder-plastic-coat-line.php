<div class="modal fade" id="powder-plastic-coat-line-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header theme-bg-1">
                    <h4 class="modal-title c-white"><span class="powder-plastic-coat-title">Add New Powder Plastic Coat Direct Materials</span> (<span class="powder-plastic-coat-line-id-no"></span>)</h4>
                </div>
                <div class="modal-body p-t-25 p-b-0"> 
                    <form id="powder-plastic-coat-form" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Powder Plastic Coat</label>
                                    <?php 
                                        echo 
                                            form_dropdown(
                                                $input_direct_materials['powder_plastic_coat_attributes'],
                                                $input_direct_materials['powder_plastic_coat_options'],
                                                $input_direct_materials['powder_plastic_coat_selected']
                                            ); 
                                    ?>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Max Coated Volume</label>
                                    <?php 
                                        echo 
                                            form_dropdown(
                                                $input_direct_materials['max_coated_volume_attributes'],
                                                $input_direct_materials['max_coated_volume_options'],
                                                $input_direct_materials['max_coated_volume_selected']
                                            ); 
                                    ?>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">  
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Sq. In / Unit</label>
                                <div class="fg-line">
                                    <?php echo form_input($input_direct_materials['item_sq_in_unit']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group required">
                                <label class="f-500 m-b-5 c-black">Sq. In / Unit Price</label>
                                <div class="fg-line">
                                    <?php echo form_input($input_direct_materials['item_costs']); ?>
                                </div>
                                <small class="help-block"></small>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer p-b-30 m-t-0 p-t-5">
                    <button id="save-powder-plastic-coat-line-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
                    <button id="close-powder-plastic-coat-line-btn" type="button" class="btn btn-link btn-close m-r-10" data-dismiss="modal">Close</button>
                </div>
            </div>
    </div>
</div>