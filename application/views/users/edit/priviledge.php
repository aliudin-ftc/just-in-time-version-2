<section id="content">
    <div class="container">

        <div class="c-header">
            <?php $this->load->view('users/widgets/breadcrumb'); ?>
        </div>

            <form id="priviledge-form" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <?php $this->load->view('users/widgets/page-header'); ?>
                    </div>

                    <div class="card-body card-padding p-b-13">
                        <?php $this->load->view('users/forms/priviledge-form'); ?>
                    </div>
                </div>    

                <div class="card">
                    <div class="card-body card-padding p-b-13">
                        <?php $this->load->view('users/forms/priviledge-others-form'); ?>
                    </div>
                </div>
            </form>          

    </div><!--container-->
</section><!--content-->

<button onClick="location.href='<?php echo base_url(); ?>maintenance/priviledge/manage';" id="back-priviledge-btn" title="Back to Manage priviledges"  class="btn btn-float theme-bg-2 m-btn d-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-arrow-left"></i>
</button>

<button id="edit-priviledge-btn" title="Save priviledge"  class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="fa fa-floppy-o"></i>
</button>