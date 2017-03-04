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
            <table id="archived-job-element-table" class="table table-striped table-vmiddle m-b-10">
                <thead>
                    <tr>
                        <th data-column-id="job-element-id" data-identifier="true">ID</th>
                        <th data-column-id="job-prod-sub">Product &amp; Sub Category</th>
                        <th data-column-id="job-req-mod">Job Request No.</th>
                        <th data-column-id="job-element-name">Element Name</th>
                        <th data-column-id="job-element-size">Font X Deoth X Height</th>
                        <th data-column-id="job-element-pack">Packing Instructions</th>      
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