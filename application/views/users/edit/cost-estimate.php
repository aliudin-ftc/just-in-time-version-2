<section id="content">
    <div class="container">

        <div class="c-header">
            <?php $this->load->view('users/widgets/breadcrumb'); ?>
        </div>
        
        <div class="card inner-layer">
            <div class="card-header">
                <?php $this->load->view('users/widgets/page-header'); ?>
            </div>

            <div class="card-body card-padding p-b-13">
                <?php $this->load->view('users/forms/job-request-form'); ?>
            </div>
        </div>

        <div class="card card-padding">
            <div class="card-header">
                <h2 class="m-b-0">
                    Job Request Elements                             
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="attach-job-element-table" class="expand-padding-t-b table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th data-identifier="true" data-column-id="job-element-id">ID</th>
                            <th data-column-id="job-prod-sub">Product &amp; Sub Category</th>
                            <th data-column-id="job-element-name">Element Name</th>
                            <th data-column-id="job-element-qty">Quantity</th>
                            <th data-column-id="job-element-size">Font X Deoth X Height</th>
                            <th data-column-id="job-element-pack">Packing Instructions</th> 
                            <th data-column-id="job-element-price">Unit &amp; Total Cost</th> 
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
</section>

<button id="save-job-request-btn" title="click to unlock the form" class="btn btn-pause btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-lock"></i>
</button>

<?php $this->load->view('users/modals/powder-plastic-coat-line'); ?> 
<?php $this->load->view('users/modals/cost-estimate-element'); ?>