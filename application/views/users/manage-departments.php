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
            <table id="customer-table" class="table table-striped table-vmiddle m-b-10">
                <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                        <th data-column-id="name">Name</th>
                        <th data-column-id="business-unit">Business Unit</th>
                        <th data-column-id="account-executive">AE</th>
                        <th data-column-id="credit-limit">Credit Limit</th>     
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

<button onClick="location.href='<?php echo base_url(); ?>maintenance/departments/add';" title="Add New Customer" class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-plus"></i>
</button>