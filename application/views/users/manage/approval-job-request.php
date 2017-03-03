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
            <table id="approval-job-request-table" class="table table-striped table-vmiddle m-b-10">
                <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                        <th data-column-id="date-sent">Time Sent</th>
                        <th data-column-id="job-no">Job No</th>
                        <th data-column-id="job-request">Request &amp; Type &amp; Sequence</th>
                        <th data-column-id="job-request-by">Request By</th>
                        <th data-column-id="approved-by" data-formatter="approved-by">Approved By</th> 
                        <th data-column-id="approved-mine" data-formatter="approve-mine">Approved Mine</th> 
                        <th data-column-id="req">Request</th> 
                        <th data-column-id="required">Required</th>
                        <th data-column-id="status" data-formatter="status">Status</th>  
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

<?php $this->load->view('users/modals/disapprove-job-request'); ?> 
