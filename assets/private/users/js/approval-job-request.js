!function($) {
    "use strict";

    var approval_job_request = function() {
        this.$body = $("body");
        this.$approval_job_request = $("#approval-job-request-table");
        this.$attach_job_element = $("#attach-job-element-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var approval_job_requestTable, attach_job_elementTable;


    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    approval_job_request.prototype.required_fields = function($form) {

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
    approval_job_request.prototype.validate = function($form, $error) {
                            
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

    approval_job_request.prototype.refresh_modal = function() {
        var $button = $('#save-disapprove-btn');
        var $modals = $('#disapprove-job-request-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.billing-title').text('Add New Billing Line');
        $modals.find('.modal-title span.billing-line-job-no').text($("#approval_job_request_no").val());
        $modals.modal('hide');
    },

    /*
    | ---------------------------------
    | # refresh form
    | ---------------------------------
    */
    approval_job_request.prototype.refresh = function($form) {

        
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
    approval_job_request.prototype.swAlert = function($type, $form) {

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
                        $.approval_job_request.refresh($form);
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
                $.approval_job_request.reload();  
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
                        $.approval_job_request.refresh($form);
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # approval_job_request table reload
    | ---------------------------------
    */
    approval_job_request.prototype.reload = function() {
        this.$approval_job_request.bootgrid("reload");   
    },

    /*
    | ---------------------------------
    | # approval_job_request table init
    | ---------------------------------
    */
    approval_job_request.prototype.init = function() {   
                
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
            $.approval_job_request.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });    

        this.$body.on('click', '#save-disapprove-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $button = $(this);
            var $form = $("#disapprove-job-request-form");
            var $errors = $.approval_job_request.validate($form, $error);
            var id = $(".disapprove-id-no").text();
            var $action = base_url + "approval/job-request/disapprove/"+ id + "?reason=" + $('#job_request_module_approval_remarks').val() + "&required=" + $(".required-status").text();

            if($errors != 0) { 
                $.approval_job_request.swAlert('error', $form);
            } else {
                $button.prop('disabled', true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');  
                swal({
                    title: "Do you like to disapprove it now?",
                    text: "The Job Request will be disapproved.",
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

                                setTimeout(function(){ 
                                    $.approval_job_request.reload();   
                                    $.approval_job_request.refresh_modal();
                                    $.approval_job_request.refresh($form);  
                                }, 5000);                                        
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.approval_job_request.swAlert('successful', $form);
                    } else {
                        $button.prop('disabled', false).html("Save changes");
                    }
                });     
            }
        });

        /*
        | ---------------------------------
        | # approval job request table initialized
        | ---------------------------------
        */
        approval_job_requestTable = this.$approval_job_request.bootgrid({
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
                "status" : function(column, row) {
                    if(row.status=="approved"){
                        return "<label class='palette-Light-Green-500 bg labels'>approved</label>";
                    } else if(row.status=="disapproved"){
                        return "<label class='palette-Red-400 bg labels'>disapproved</label>";
                    } else {
                        return "<label class='palette-Yellow-A700 bg labels'>pending</label>";
                    }
                },
                "commands": function(column, row) {
                    return  "<button title=\"approve this\" type=\"button\" class=\"btn btn-icon command-approve waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-thumb-up\"></span></button> "+
                            "<button title=\"disapprove this\" type=\"button\" class=\"btn btn-icon command-disapprove waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-thumb-down\"></span></button> "+
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
            url: base_url + "approval/job-request/lists",
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
        }).on("selected.rs.jquery.bootgrid", function(e, rows)
        {
            
        }).on("deselected.rs.jquery.bootgrid", function(e, rows)
        {

        }).on("loaded.rs.jquery.bootgrid", function (e, rows) {

            /*
            | ---------------------------------
            | # job_order bill delete
            | ---------------------------------
            */
            approval_job_requestTable.find(".command-approve").on("click", function (e) {
                e.preventDefault();
                var id       = $(this).parents('tr').data('row-id'),
                    req      = $(this).parents('tr').find('td:nth-child(5)').text(),
                    req_by   = $(this).parents('tr').find('td:nth-child(6)').text(),
                    mine     = $(this).parents('tr').find('td:nth-child(8)').text(),
                    request  = $(this).parents('tr').find('td:nth-child(9)').text(),
                    required = $(this).parents('tr').find('td:nth-child(10)').text(),
                    status   = $(this).parents('tr').find('td:nth-child(11) label').text(),
                    url      = base_url + "approval/job-request/approve/"+ id + "?request=" + request + "&required=" +required;

                if(status == "pending" && mine == "false" && required != "0")
                {
                    swal({
                        title: "Are you sure?",
                        text:  "The request " + req + " from (" +req_by+ ") with ID "+id+" will be approved.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Approve it!",
                        cancelButtonText: "No, Cancel plx!",
                        closeOnConfirm: false
                    }, function(){
                        
                        $.ajax({
                            type: 'POST',
                            url: url,
                            success: function (data) {
                                console.log(data);
                                swal({
                                    title: "Approved!",
                                    text: "The request " + req + " from (" +req_by+ ") with ID "+id+" has been successfully approved!",
                                    type: "success",
                                    },
                                    function(){                                     
                                        $.approval_job_request.reload();
                                });     
                            },
                        });  

                    });
                }
            });

            /*
            | ---------------------------------
            | # job_order bill delete
            | ---------------------------------
            */
            approval_job_requestTable.find(".command-disapprove").on("click", function (e) {
                e.preventDefault();
                var id       = $(this).parents('tr').data('row-id'),
                    modals   = $("#disapprove-job-request-modal"),
                    req      = $(this).parents('tr').find('td:nth-child(5)').text(),
                    req_by   = $(this).parents('tr').find('td:nth-child(6)').text(),
                    mine     = $(this).parents('tr').find('td:nth-child(8)').text(),
                    request  = $(this).parents('tr').find('td:nth-child(9)').text(),
                    required = $(this).parents('tr').find('td:nth-child(10)').text(),
                    status   = $(this).parents('tr').find('td:nth-child(11) label').text(),
                    url      = base_url + "approval/job-request/disapprove/"+ id + "?required=" + required + "&reason=" + $('#job_request_module_approval_remarks').val();
                    $(".disapprove-id-no").text(id);
                    $(".required-status").text(required);

                if(status == "pending" && mine == "false" && required != "0")
                {   
                    modals.modal('show');
                }
            });

            approval_job_requestTable.find(".command-view").on("click", function (e) {
                e.preventDefault();
                var id   = $(this).parents('tr').data('row-id'),
                request  = $(this).parents('tr').find('td:nth-child(9)').text(),
                    url  = base_url + "approval/job-request/view/"+ id + "/?request=" + request;
                
                window.open(url, '_blank'); 
            });

        }); 
    

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
            url: base_url + "job-element/attach-elements/"+ base_line,
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
        }).on("selected.rs.jquery.bootgrid", function(e, rows)
        {
            
        }).on("deselected.rs.jquery.bootgrid", function(e, rows)
        {

        }).on("loaded.rs.jquery.bootgrid", function (e, rows) {

        });
    },

    //init approval_job_request
    $.approval_job_request = new approval_job_request, $.approval_job_request.Constructor = approval_job_request

}(window.jQuery),

//initializing approval_job_request
function($) {
    "use strict";
    $.approval_job_request.init();
    $.approval_job_request.required_fields();
}(window.jQuery);