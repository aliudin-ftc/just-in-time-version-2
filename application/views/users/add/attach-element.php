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
                <?php $this->load->view('users/forms/attach-job-request-form'); ?>
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
                    <table id="attach-job-element-table" class="table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th data-column-id="job-element-id">ID</th>
                            <th data-column-id="job-prod-sub">Product &amp; Sub Category</th>
                            <th data-column-id="job-element-name">Element Name</th>
                            <th data-column-id="job-element-size">Font X Deoth X Height</th>
                            <th data-column-id="job-element-pack">Packing Instructions</th> 
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                        </tr>
                    </thead>
                    <tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-padding">
            <div class="card-header">
                <h2 class="m-b-0">
                    Available Elements                             
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="available-job-element-table" class="table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th data-column-id="job-element-id" data-identifier="true">ID</th>
                            <th data-column-id="job-prod-sub">Product &amp; Sub Category</th>
                            <th data-column-id="job-element-name">Element Name</th>
                            <th data-column-id="job-element-size">Font X Deoth X Height</th>
                            <th data-column-id="job-element-pack">Packing Instructions</th>      
                        </tr>
                    </thead>
                    <tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</section>

<button id="save-attach-element-btn" title="Attach Element" class="btn btn-float theme-bg-1 m-btn d-btn d-btn1 waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-attachment-alt"></i>
</button>

<button onClick="location.href='<?php echo base_url(); ?>job-order/manage/job-request/<?php echo $template['page']['views']; ?>';" id="back-job-request-btn" title="Back to Job Requests" class="btn btn-float theme-bg-2 m-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-arrow-left"></i>
</button>

