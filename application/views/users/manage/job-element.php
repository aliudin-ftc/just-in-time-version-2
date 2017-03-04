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
            <table id="job-element-table" class="table table-striped table-vmiddle m-b-10">
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

<button onClick="location.href='<?php echo base_url(); ?>job-order/manage/edit/<?php echo $this->uri->segment($this->uri->total_segments()); ?>';" title="Back to Job Order" class="btn btn-float theme-bg-2 m-btn d-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-arrow-left"></i>
</button>

<button onClick="location.href='<?php echo base_url(); ?>job-order/manage/job-element/<?php echo $this->uri->segment($this->uri->total_segments()); ?>/add';" title="Add New Job Order" class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-plus"></i>
</button>