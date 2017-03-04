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
            <table id="unit-of-measurement-table" class="table table-striped table-vmiddle m-b-10">
                <thead> 
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                        <th data-column-id="unit-of-measurement-code">Code</th>
                        <th data-column-id="unit-of-measurement-name">Name</th>
                        <th data-column-id="unit-of-measurement-desc">Description</th>
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

<button onClick="location.href='<?php echo base_url(); ?>maintenance/unit-of-measurement/add';" title="Add New Unit of Measurement" class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-plus"></i>
</button>