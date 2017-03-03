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
            <table id="cost-estimate-table" class="table table-striped table-vmiddle m-b-10">
                <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                        <th data-column-id="time-sent">Time Sent</th>
                        <th data-column-id="job-no">Job No (Name)</th>
                        <th data-column-id="request-no">Request No.</th>
                        <th data-column-id="agent">Account Executive</th>
                        <th data-column-id="customer">Customer</th>   
                        <th data-column-id="status">Satus</th>   
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

<?php $this->load->view('users/modals/assign-estimate'); ?> 