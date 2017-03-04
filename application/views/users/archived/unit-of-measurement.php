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
            <table id="archived-unit-of-measurement-table" class="table table-striped table-vmiddle m-b-10">
                <thead>
                     <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                        <th data-column-id="unit-of-measurement-code">Code</th>
                        <th data-column-id="unit-of-measurement-name">Name</th>
                        <th data-column-id="unit-of-measurement-desc">Description</th>    
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
