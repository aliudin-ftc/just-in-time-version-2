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
            <table id="archived-job-request-table" class="table table-striped table-vmiddle m-b-10">
                <thead>
                    <tr>
                        <th data-column-id="job-request-id" data-identifier="true">ID</th>
                        <th data-column-id="job-status">Status</th>
                        <th data-column-id="job-request">Request</th>
                        <th data-column-id="job-request-type">Request Type</th>
                        <th data-column-id="job-sequence">Sequence</th>
                        <th data-column-id="job-endorsed">Endorsed</th>
                        <th data-column-id="state" data-formatter="state">STATE</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>

    </div>
</section>