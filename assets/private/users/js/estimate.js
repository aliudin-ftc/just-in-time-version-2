!function($) {
    "use strict";

    var estimate = function() {
        this.$body = $("body");
        this.$estimate_planner = $("#estimate-planner-table");
        this.$cost_estimate = $("#cost-estimate-table");
        this.$attach_job_element = $("#attach-job-element-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var estimate_plannerTable, cost_estimateTable, attach_job_elementTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    estimate.prototype.required_fields = function($form) {

        $.each(this.$body.find(".form-group"), function(){
            
            if($(this).hasClass('required')) {
                $(this).find('label').append('<span class="pull-right c-red">*</span>');            
                $(this).find("input[type='text'], select, textarea").addClass('required');
            }   

        });

    },    

    /*
    | ---------------------------------
    | # validate form
    | ---------------------------------
    */
    estimate.prototype.validate = function($form, $error) {
                            
        $.each($form.find("input[type='text'], select, textarea"), function(){
               
            if ($(this).attr("name") === undefined || $(this).attr("name") === null) {

            } else { 
                if($(this).hasClass("required")){
                    if($(this).is("[multiple]")){
                        if( !$(this).val() ){
                            $(this).closest(".form-group").addClass("has-error").find(".help-block").text("this field is required.");
                            $error++;
                        }
                    } else if($(this).val()=="" || $(this).val()=="0"){
                        if(!$(this).is("select")) {
                            $(this).closest(".form-group").addClass("has-error").find(".help-block").text("this field is required.");
                            $error++;
                        } else {
                            $(this).closest(".form-group").addClass("has-error").find(".help-block").text("this field is required.");
                            $error++;                                          
                        }
                    } 
                }
            }

        });
        return $error;

    }, 

    estimate.prototype.refresh_modal = function() {
        var $button = $('#save-assign-estimate-btn');
        var $modals = $('#assign-estimate-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.billing-title').text('Add New Estimator for Job Request');
        $modals.modal('hide');
    },

    /*
    | ---------------------------------
    | # refresh form
    | ---------------------------------
    */
    estimate.prototype.refresh = function($form) {

        
        $.each($form.find("input[type='text'], select, textarea"), function(){
            
            if ($(this).attr("name") === undefined || $(this).attr("name") === null) {

            } else {
                if($(this).is("[multiple]")){
                    if( $(this).val() ){
                        $(this).selectpicker('deselectAll').closest(".form-group").removeClass("has-error").find(".help-block").text("");
                    }
                } else if( $(this).val()!="" ){
                    if(!$(this).is("select")) {                        
                        $(this).val("").closest(".form-group").removeClass("has-error").find(".help-block").text("");
                    } else {
                        $(this).val("").closest(".form-group").removeClass("has-error").find(".help-block").text("");
                        $(this).selectpicker('val', '0')
                    }
                }
                
            }

        });
    },

    /*
    | ---------------------------------
    | # sweet alert promp
    | ---------------------------------
    */
    estimate.prototype.swAlert = function($type, $form) {

        if($type == "error" && $form != "") 
        {   
            swal({
                title: "Oops...",
                text: "Something went wrong! \nPlease fill the required fields to continue..",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true
            }, function(isConfirm){ 

                if (isConfirm) {     
                   $('body, .header-title').stop().animate({
                        scrollTop: $($form).offset().top - 100
                    }, 1500, 'easeInOutExpo');
                } 

            });
        }
        else if($type == "success" && $form != "") 
        {
            setTimeout(function(){     
                swal({   
                    title: "Sweet!",   
                    text: "The information has been saved.",   
                    imageUrl: base_url + "assets/public/img/thumbs-up.png", 
                    timer: 3000,   
                    showConfirmButton: true,
                    confirmButtonText: "Done",
                },  function(isConfirm){
                    if (isConfirm) {
                        $.estimate.refresh($form);
                        document.location.href = base_url + 'job-order/manage';
                    }
                });                   
            }, 2000);
        }
        else if($type == "timer" && $form != "") 
        {
            setTimeout(function(){     
                swal({   
                    title: "Sweet!",   
                    text: "The information has been saved.",   
                    imageUrl: base_url + "assets/public/img/thumbs-up.png", 
                    timer: 3000,   
                    showConfirmButton: false
                }); 
                $.estimate.reload();  
            }, 2000);
        }
        else if($type == "successful" && $form != "") 
        {
            setTimeout(function(){     
                swal({   
                    title: "Sweet!",   
                    text: "The information has been saved.",   
                    imageUrl: base_url + "assets/public/img/thumbs-up.png", 
                    timer: 3000,   
                    showConfirmButton: true,
                    confirmButtonText: "Done",
                },  function(isConfirm){
                    if (isConfirm) {
                        $.estimate.refresh($form);
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # estimate table reload
    | ---------------------------------
    */
    estimate.prototype.reload = function() {
        this.$estimate_planner.bootgrid("reload");    
    },

    /*
    | ---------------------------------
    | # estimate table init
    | ---------------------------------
    */
    estimate.prototype.init = function() {   
                
        /*
        | ---------------------------------
        | # select, input, and textarea on change or keyup remove error
        | ---------------------------------
        */
        this.$body.on('change', 'select, input', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        this.$body.on('click', '#close-btn', function (e) {
            e.preventDefault();
            var $form = $(this).closest("form");
            $.estimate.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });    

        /*
        | ---------------------------------
        | # assign estimate save
        | ---------------------------------
        */
        this.$body.on('click', '#save-assign-estimate-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $button = $(this);
            var $form = $("#assign-estimate-form");
            var $errors = $.estimate.validate($form, $error);
            var $action = base_url + "estimates/planner/assign/" + $(".assign-id-no").text();

            if($errors != 0) { 
                $.estimate.swAlert('error', $form);
            } else {
                $button.prop('disabled', true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');  
                swal({
                    title: "Do you like to assign it now?",
                    text: "The selected estimator will be assigned to the job request.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        $.ajax({
                            type: $form.attr("method"),
                            url: $action,
                            data: $form.serialize(),
                            beforeSend: function(){
                                                               
                            },
                            success: function (data) {   
                                var data = $.parseJSON(data);   

                                $.estimate.swAlert('timer', $form); 

                                setTimeout(function(){ 
                                    $.estimate.reload();   
                                    $.estimate.refresh_modal();
                                    $.estimate.refresh($form);  
                                }, 5000);                                        
                            },
                            complete: function (data) {
                                
                            }
                        });

                    } else {
                        $button.prop('disabled', false).html("Save changes");
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # estimate planner table initialized
        | ---------------------------------
        */
        estimate_plannerTable = this.$estimate_planner.bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-chevron-down',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-chevron-up'
            },
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
            formatters: {
                "commands": function(column, row) {
                    return  "<button title=\"assign this\" type=\"button\" class=\"btn btn-icon command-assign waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-mail-reply transformY\"></span></button> "+
                            "<button title=\"view this\" type=\"button\" class=\"btn btn-icon command-view waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-search\"></span></button> ";
                }     
            },
            ajax: true,
            ajaxSettings: {
                method: "POST",
                cache: false
            },         
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            },

            requestHandler: function (request)
            {
                console.log(request);
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "estimates/planner/lists",
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
        }).on("selected.rs.jquery.bootgrid", function(e, rows)
        {
            
        }).on("deselected.rs.jquery.bootgrid", function(e, rows)
        {

        }).on("loaded.rs.jquery.bootgrid", function (e, rows) {

            estimate_plannerTable.find(".command-assign").on("click", function (e) {
                e.preventDefault();
                var id     = $(this).parents('tr').data('row-id'),
                    name   = $(this).parents('tr').find('td:nth-child(5)').text(),
                    assign = $.trim($(this).parents('tr').find('td:nth-child(8)').text()),
                    modals = $("#assign-estimate-modal");
                    $(".assign-id-no").text(id);

                if(assign == "")
                {
                    modals.modal('show');
                }
            });

            estimate_plannerTable.find(".command-view").on("click", function (e) {
                e.preventDefault();
                var id   = $(this).parents('tr').data('row-id'),
                    url  = base_url + "estimates/job-request/view/"+ id + "/?request=4";
                
                window.open(url, '_blank'); 
            });

        }); 


        /*
        | ---------------------------------
        | # cost estimate table initialized
        | ---------------------------------
        */
        cost_estimateTable = this.$cost_estimate.bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-chevron-down',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-chevron-up'
            },
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
            formatters: {
                "commands": function(column, row) {
                    return  "<button title=\"estimate this\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> "+
                            "<button title=\"view this\" type=\"button\" class=\"btn btn-icon command-view waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-search\"></span></button> "+
                            "<button title=\"send this\" type=\"button\" class=\"btn btn-icon command-send waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-mail-send\"></span></button>";
                }     
            },
            ajax: true,
            ajaxSettings: {
                method: "POST",
                cache: false
            },         
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            },

            requestHandler: function (request)
            {
                console.log(request);
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "estimates/cost-estimate/lists",
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
        }).on("selected.rs.jquery.bootgrid", function(e, rows)
        {
            
        }).on("deselected.rs.jquery.bootgrid", function(e, rows)
        {

        }).on("loaded.rs.jquery.bootgrid", function (e, rows) {

            cost_estimateTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();
                var id   = $(this).parents('tr').data('row-id'),
                    url  = base_url + "estimates/cost-estimate/edit/"+ id ;                                    
                window.open(url, '_blank'); 
            });

        });


        this.$body.on('click', '.btn-pause, .btn-start', function (e) {
            e.preventDefault();
            $(this).toggleClass('btn-pause btn-start')
            $(this).find('.fa').toggleClass('fa-pause fa-play');
            
            if($(this).hasClass('btn-start')){
               
            } else {

            }

        });

        /*
        | ---------------------------------
        | # attach-element table initialized
        | ---------------------------------
        */
        attach_job_elementTable = this.$attach_job_element.bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-chevron-down',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-chevron-up'
            },
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
            formatters: {
                "commands": function(column, row) {
                    return  "<button title=\"estimate this\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> ";
                }    
            },
            ajax: true,
            ajaxSettings: {
                method: "POST",
                cache: false
            },         
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            },

            requestHandler: function (request)
            {
                console.log(request);
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "estimates/attach-elements/"+ base_line,
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
        }).on("selected.rs.jquery.bootgrid", function(e, rows)
        {
            
        }).on("deselected.rs.jquery.bootgrid", function(e, rows)
        {

        }).on("loaded.rs.jquery.bootgrid", function (e, rows) {


            attach_job_elementTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();
                var id   = $(this).parents('tr').data('row-id'),
                    url  = base_url + "estimates/cost-estimate/edit/"+ id ;                                    
            
                if ( $( ".btn-pause" ).length ) {
                    alert('exist');
                }

            });

            

        });
    },

    //init estimate
    $.estimate = new estimate, $.estimate.Constructor = estimate

}(window.jQuery),

//initializing estimate
function($) {
    "use strict";
    $.estimate.init();
    $.estimate.required_fields();
}(window.jQuery);