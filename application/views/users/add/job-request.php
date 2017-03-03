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
        
        <div class="card card-padding hidden">
            <div class="card-header">
                <h2 class="m-b-0">
                    Job Request Uploads                             
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="job-request-upload-table" class="table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th data-column-id="file-no" data-type="numeric" data-identifier="true">File No</th>
                            <th data-column-id="file-name">File Name</th>
                            <th data-column-id="file-format">File Format</th>
                            <th data-column-id="file-url">File Url</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                        </tr>
                    </thead>
                    <tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-padding hidden">
            <div class="card-header">
                <h2>Upload Files</h2>
            </div>
            <div class="card-body card-padding">
                <form action="/some-url" class="dropzone job-request-uploads" id="dropzone">
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                </form>
            </div>
        </div>
        
    </div>
</section>

<button onClick="location.href='<?php echo base_url(); ?>job-order/manage/job-request/<?php echo $template['page']['views']; ?>';" id="back-job-request-btn" title="Back to Job Requests" class="btn btn-float theme-bg-2 m-btn d-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-arrow-left"></i>
</button>

<button id="save-job-request-btn" title="Save Job Request" class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="fa fa-floppy-o"></i>
</button>