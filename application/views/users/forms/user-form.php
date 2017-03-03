<form id="user-form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="job-header"><strong>General Information</strong></h4>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">User</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['resources_attributes'],
                            $input['resources_options'],
                            $input['resources_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Priviledge</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['priviledge_attributes'],
                            $input['priviledge_options'],
                            $input['priviledge_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Username</label>
                <div class="fg-line">
                    <?php echo form_input($input['username']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Password
                </label>
                <span class="pull-right">
                    <a href="javascript:;" class="show-password">
                        show <i class="zmdi zmdi-eye"></i>
                    </a>
                </span>
                <div class="fg-line">
                    <?php echo form_input($input['password']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Secret Question</label>
                <?php 
                    echo 
                        form_dropdown(
                            $input['secret_question_attributes'],
                            $input['secret_question_options'],
                            $input['secret_question_selected']
                        ); 
                ?>
                <small class="help-block"></small>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group required">
                <label class="f-500 m-b-5 c-black">Secret Password 
                </label>
                <span class="pull-right">
                    <a href="javascript:;" class="show-password">
                        show <i class="zmdi zmdi-eye"></i>
                    </a>
                </span>
                <div class="fg-line">
                    <?php echo form_input($input['secret_password']); ?>
                </div>
                <small class="help-block"></small>
            </div>
        </div>
    </div>
</form>