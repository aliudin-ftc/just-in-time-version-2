<section id="content">
    <div class="container">
        <div class="c-header">
            <?php $this->load->view('users/widgets/breadcrumb'); ?>
        </div>

        <div class="card inner-layer p-b-13">
            <div class="card-header">
                <?php $this->load->view('users/widgets/page-header'); ?>
            </div>

            <div class="table-responsive">
            <table id="job-order-table" class="table table-striped table-vmiddle m-b-10">
                <thead>
                    <tr>
                        <th data-column-id="job-no" data-identifier="true">Job No</th>
                        <th data-column-id="job-name">Job Name</th>
                        <th data-column-id="job-customer">Customer</th>
                        <th data-column-id="job-ae">AE</th>
                        <th data-column-id="job-qty">Qty</th>
                        <th data-column-id="job-uom">Uom</th>      
                        <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>

    </div>
</section>

<button onClick="location.href='<?php echo base_url(); ?>job-order/manage/add';" title="Add New Job Order" class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-plus"></i>
</button>