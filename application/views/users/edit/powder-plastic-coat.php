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
                    <?php $this->load->view('users/forms/powder-plastic-coat-form'); ?>
                </div>
            </div>              

    </div><!--container-->
</section><!--content-->

<button onClick="location.href='<?php echo base_url(); ?>maintenance/powder-plastic-coat/manage';" id="back-powder-plastic-coat-btn" title="Back to Manage powder-plastic-coats"  class="btn btn-float theme-bg-2 m-btn d-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-arrow-left"></i>
</button>

<button id="edit-powder-plastic-coat-btn" title="Save powder-plastic-coat"  class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="fa fa-floppy-o"></i>
</button>