<section id="content">
    <div class="container">

        <div class="c-header">
            <?php $this->load->view('users/widgets/breadcrumb'); ?>
        </div>

        <form id="resources-form" method="post" enctype="multipart/form-data">
            
            <div class="card inner-layer">
                <div class="card-header">
                    <?php $this->load->view('users/widgets/page-header'); ?>
                </div>

                <div class="card-body card-padding p-b-13">
                    <?php $this->load->view('users/forms/employee-form'); ?>               
                </div>
            </div> 
        </form>  
        
            <div class="card p-b-13">
                <div class="card-header">
                    <h4 class="job-header m-b-0">                   
                        <strong>Address Information</strong>
                    </h4>
                    <button id="address-line-button" data-toggle="modal" href="#address-line-modal" class="pull-right btn theme-bg-1 waves-effect">
                        Add New
                    </button>                           
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="address-table" class="table table-striped table-vmiddle m-b-10">
                        <thead>
                            <tr>
                                <th data-column-id="address-id" data-type="numeric" data-identifier="true">Address ID</th>
                                <th data-column-id="address-province">Province</th>
                                <th data-column-id="address-city">City</th>
                                <th data-column-id="address-brgy">Barangay</th>
                                <th data-column-id="address-street">Street</th>
                                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card p-b-13">
                <div class="card-header">
                    <h4 class="job-header m-b-0">                   
                        <strong>Contact Information</strong>
                    </h4>
                    <button id="contact-line-button" data-toggle="modal" href="#contact-line-modal" class="pull-right btn theme-bg-1 waves-effect">
                        Add New
                    </button>                           
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="contact-table" class="table table-striped table-vmiddle m-b-10">
                        <thead>
                            <tr>
                                <th data-column-id="contact-id" data-type="numeric" data-identifier="true">Contact ID</th>
                                <th data-column-id="contact-phone">Phone Number</th>
                                <th data-column-id="contact-mobile">Mobile Number</th>
                                <th data-column-id="contact-fax">Fax Number</th>
                                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card p-b-13">
                <div class="card-header">
                    <h4 class="job-header m-b-0">                   
                        <strong>Outgoing Information</strong>
                    </h4>
                    <button id="outgoing-line-button" data-toggle="modal" href="#outgoing-line-modal" class="pull-right btn theme-bg-1 waves-effect">
                        Add New
                    </button>                           
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="outgoing-table" class="table table-striped table-vmiddle m-b-10">
                        <thead>
                            <tr>
                                <th data-column-id="outgoing-id" data-type="numeric" data-identifier="true">Outgoing ID</th>
                                <th data-column-id="outgoing-email">Email</th>
                                <th data-column-id="outgoing-desc">Description</th>
                                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>               

    </div><!--container-->
</section><!--content-->

<button onClick="location.href='<?php echo base_url(); ?>resources/employee/manage';" id="back-employee-btn" title="Back to Manage employees"  class="btn btn-float theme-bg-2 m-btn d-btn waves-effect waves-circle waves-float">
    <i class="zmdi zmdi-arrow-left"></i>
</button>

<button id="save-resources-btn" title="Save Employee"  class="btn btn-float theme-bg-1 m-btn waves-effect waves-circle waves-float">
    <i class="fa fa-floppy-o"></i>
</button>

<?php $this->load->view('users/modals/address-line'); ?> 
<?php $this->load->view('users/modals/contact-line'); ?> 
<?php $this->load->view('users/modals/outgoing-line'); ?> 