<section id="content">
    <div class="container">

        <div class="c-header">
            <?php $this->load->view('users/widgets/breadcrumb'); ?>
        </div>

        <form id="job-order-form" method="post" enctype="multipart/form-data">
            <div class="card inner-layer">
                <div class="card-header">
                    <?php $this->load->view('users/widgets/page-header'); ?>
                </div>

                <div class="card-body card-padding p-b-13">
                    <?php $this->load->view('users/forms/job-order-form'); ?> 
                </div>
            </div>

            <div class="card p-b-13">
                <div class="card-header">
                    <h4 class="job-header m-b-0">                   
                        <strong>Billing Information</strong>
                    </h4>
                    <button id="job-order-billing-line-button" data-toggle="modal" href="#delivery-packing-line-modal" class="pull-right btn theme-bg-1 waves-effect <?php echo $template["method"]=='Edit' ? '' : 'hidden'; ?>">
                        Add New Billing Line
                    </button>                           
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="job-order-bill-table" class="table table-striped table-vmiddle m-b-10">
                        <thead>
                            <tr>
                                <th data-column-id="job-order-bill-id" data-type="numeric" data-identifier="true">Bill No</th>
                                <th data-column-id="job-order-bill-to">Bill to</th>
                                <th data-column-id="job-order-bill-qty">Billing Quantity</th>
                                <th data-column-id="job-order-bill-uom">Unit of Measurement</th>
                                <th data-column-id="job-order-bill-dc">Discount</th>
                                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <?php $this->load->view('users/forms/job-order-others-form'); ?> 
            </div>
        </form>
        
    </div>
</section>

<button onClick="location.href='<?php echo base_url(); ?>job-order/manage';" title="Back to Job Order" class="btn btn-float theme-bg-2 m-btn d-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-arrow-left"></i>
</button>

<button id="save-job-order-btn" title="Save Job Order" class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="fa fa-floppy-o"></i>
</button>

<?php $this->load->view('users/modals/billing-line'); ?> 
<?php $this->load->view('users/modals/free-job-order'); ?> 