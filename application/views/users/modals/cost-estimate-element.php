<div class="modal fade" id="cost-estimate-element-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="cost-estimate-element-form" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header theme-bg-1">
                    <h4 class="modal-title c-white"><span class="element-title">Add Estimate for Job Element</span> (<span class="element-id-no"></span>)</h4>
                </div>
                <div class="modal-body p-t-25 p-b-0">
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="panel-group" role="tablist" aria-multiselectable="true" id="cost-estimate-panel">
                                <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="heading-direct-materials">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#direct-materials-panel" aria-expanded="true" aria-controls="direct-materials-panel">
                                                Direct Materials
                                                <span class="direct-materials-price pull-right prices">
                                                20.20
                                                </span>
                                            </a>

                                        </h4>
                                    </div>
                                    <div id="direct-materials-panel" class="collapse in" role="tabpanel" aria-labelledby="heading-direct-materials">
                                        <div class="panel-body">
                                            <button id="powder-plastic-coat-line-button" class="pull-right btn theme-bg-1 waves-effect ">
                                                Add New
                                            </button>
                                            <h4 class="m-t-0 m-b-15 theme-color">Which powder / plastic coat to be used?</h4>
                                            <div class="table-responsive">
                                                <table id="direct-materials-powder-plastic-coat-table" class="expand-padding-t-b table table-striped table-vmiddle">
                                                    <thead>
                                                        <tr>
                                                            <th data-identifier="true" data-column-id="item-id">ID</th>
                                                            <th data-column-id="item">Item</th>
                                                            <th data-column-id="item-sq-in">Gram / Sq. In.</th>
                                                            <th data-column-id="item-sq-unit">Sq. In. / Unit</th>
                                                            <th data-column-id="item_price_sq" data-formatter="price">Price / Sq. In.</th>
                                                            <th data-column-id="item_cost" data-formatter="cost">Coating Cost</th> 
                                                            <th data-column-id="item_costs">Cost</th> 
                                                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <h4 class="m-t-0 m-b-15 theme-color">Which paint to be used?</h4>
                                            <div class="table-responsive">
                                                <table id="direct-materials-paint-table" class="expand-padding-t-b table table-striped table-vmiddle">
                                                    <thead>
                                                        <tr>
                                                            <th data-identifier="true" data-column-id="job-element-id">ID</th>
                                                            <th data-column-id="job-prod-sub">Item</th>
                                                            <th data-column-id="job-element-name">Gram / Sq. In.</th>
                                                            <th data-column-id="job-element-qty">Sq. In. / Unit</th>
                                                            <th data-column-id="job-element-size">Price / Sq. In.</th>
                                                            <th data-column-id="job-element-pack">Coating Cost</th> 
                                                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="heading-labor">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#labor-panel" aria-expanded="false" aria-controls="labor-panel">
                                                Labor (In-house and Direct)
                                                <span class="labor-price pull-right prices">
                                                20.20
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="labor-panel" class="collapse" role="tabpanel" aria-labelledby="heading-labor">
                                        <div class="panel-body">                                 
                                            <?php foreach ($input_section as $row) { ?>
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-group <?php  echo ($row == end($input_section)) ? 'm-b-0' : 'm-b-25'; ?>">
                                                            <label class="f-500 m-b-5 c-black"><?php echo $row['name']; ?></label>
                                                            <div class="fg-line">
                                                                <?php echo form_input($row); ?>
                                                            </div>
                                                            <small class="help-block"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group <?php  echo ($row == end($input_section)) ? 'm-b-0' : 'm-b-25'; ?>">
                                                            <label class="f-500 m-b-5 c-black full-width text-right"><?php echo $row['name']; ?> Total Cost</label>
                                                            <div class="fg-line">
                                                                <input type="text" name="<?php echo $row["name"]; ?>_disabled" value="" id="<?php echo $row["name"]; ?>_disabled" class="text-right form-control input-md numeric" disabled="disabled">
                                                            </div>
                                                            <small class="help-block"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="heading-machine">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#machine-panel" aria-expanded="false" aria-controls="machine-panel">
                                                Machine
                                                <span class="machine-price pull-right prices">
                                                20.20
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="machine-panel" class="collapse" role="tabpanel" aria-labelledby="heading-machine">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt machineum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer machinee wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus machinee sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="heading-consumables">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#consumables-panel" aria-expanded="false" aria-controls="consumables-panel">
                                                Consumables
                                                <span class="consumables-price pull-right prices">
                                                20.20
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="consumables-panel" class="collapse" role="tabpanel" aria-labelledby="heading-consumables">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="heading-reject-allowances">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#reject-allowances-panel" aria-expanded="false" aria-controls="reject-allowances-panel">
                                                Reject Allowances
                                                <span class="reject-allowances-price pull-right prices">
                                                20.20
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="reject-allowances-panel" class="collapse" role="tabpanel" aria-labelledby="heading-reject-allowances">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="heading-reject-allowances">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-parent="#accordion" href="#reject-allowances-panel" aria-expanded="false" aria-controls="reject-allowances-panel">
                                                <span class="m-l-30 total-price pull-right prices">
                                                20.20
                                                </span>
                                                <span class="pull-right">
                                                Total
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="modal-footer p-b-30 m-t-0 p-t-15">
                    <button id="save-cost-estimate-element-btn" type="button" class="btn btn-link theme-bg-1 c-white">Save changes</button>
                    <button id="close-btn" type="button" class="btn btn-link btn-close m-r-10" data-dismiss="modal">Close</button>
                </div>
            </div>
        <form>
    </div>
</div>