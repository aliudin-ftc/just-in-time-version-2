!function($) {
    "use strict";

    var job_request = function() {
        this.$body = $("body")
        this.$job_request = $("#job-request-table");
        this.$archived_job_request = $("#archived-job-request-table");
        this.$job_request_upload = $("#job-request-upload-table");
        this.$available_job_element = $("#available-job-element-table");
        this.$attach_job_element = $("#attach-job-element-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var available_job_elementTable, attach_job_elementTable, archived_job_requestTable, job_requestTable, job_request_uploadTable, job_data = $('#job_request_module_id').val(); 

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    job_request.prototype.required_fields = function($form) {

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
    job_request.prototype.validate = function($form, $error) {
                            
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

    job_request.prototype.refresh_modal = function() {
        var $button = $('#save-billing-line-btn');
        var $modals = $('#billing-line-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.billing-title').text('Add New Billing Line');
        $modals.find('.modal-title span.billing-line-job-no').text($("#job_request_no").val());
        $modals.modal('hide');
    },

    /*
    | ---------------------------------
    | # refresh form
    | ---------------------------------
    */
    job_request.prototype.refresh = function($form) {

        
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
    job_request.prototype.swAlert = function($type, $form) {

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
                        $.job_request.refresh($form);
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
                $.job_request.reload();  
            }, 2000);
        }
        else if($type == "send" && $form == "") 
        {
            setTimeout(function(){     
                swal({   
                    title: "Sweet!",   
                    text: "The information has been sent.",   
                    imageUrl: base_url + "assets/public/img/thumbs-up.png", 
                    timer: 3000,   
                    showConfirmButton: false
                }); 
                $.job_request.reload();  
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

                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # job_request reload selectpicker
    | ---------------------------------
    */
    job_request.prototype.reload_job_request_selectpicker = function (data1, data2) {
        var $job_status = data1;    
        var $job_request = $('#'+data2);
        $job_request.find('option').remove();
        $job_request.selectpicker('refresh');

        $.ajax({
            url: base_url + 'job-request/find-job-request-by-job-status/' + $job_status,
            type: "GET",
            success: function (data) {    
                $job_request.append('<option value="">select job request here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $job_request.append('<option value="'+item.job_request_id+'">'+item.job_request_name+'</option>');  
                }); 
                $job_request.selectpicker('refresh');     
            },
            error: function( jqXhr ) {
                if( jqXhr.status == 400 ) { 
                    var json = $.parseJSON( jqXhr.responseText );
                }
            }
        })
    },

    /*
    | ---------------------------------
    | # job_request reload selectpicker
    | ---------------------------------
    */
    job_request.prototype.reload_job_request_type_selectpicker = function (data1, data2) {
        var $job_request = data1;    
        var $job_request_type = $('#'+data2);
        $job_request_type.find('option').remove();
        $job_request_type.selectpicker('refresh');

        $.ajax({
            url: base_url + 'job-request/find-job-request-type-by-job-request/' + $job_request,
            type: "GET",
            success: function (data) {    
                $job_request_type.append('<option value="">select job request here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $job_request_type.append('<option value="'+item.job_request_type_id+'">'+item.job_request_type_name+'</option>');  
                }); 
                $job_request_type.selectpicker('refresh');     
            },
            error: function( jqXhr ) {
                if( jqXhr.status == 400 ) { 
                    var json = $.parseJSON( jqXhr.responseText );
                }
            }
        })
    },


    /*
    | ---------------------------------
    | # job_request reload selectpicker
    | ---------------------------------
    */
    job_request.prototype.reload_job_request_category_selectpicker = function (data1, data2) {
        var $job_request = data1;    
        var $job_request_category = $('#'+data2);
        $job_request_category.find('option').remove();
        $job_request_category.selectpicker('refresh');

        $.ajax({
            url: base_url + 'job-request/find-job-request-category-by-job-request/' + $job_request,
            type: "GET",
            success: function (data) {    
                $job_request_category.append('<option value="">select job request here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $job_request_category.append('<option value="'+item.job_request_category_id+'">'+item.job_request_category_name+'</option>');  
                }); 
                $job_request_category.selectpicker('refresh');     
            },
            error: function( jqXhr ) {
                if( jqXhr.status == 400 ) { 
                    var json = $.parseJSON( jqXhr.responseText );
                }
            }
        })
    },
    /*
    | ---------------------------------
    | # job_request table reload
    | ---------------------------------
    */
    job_request.prototype.reload = function() {
        this.$job_request.bootgrid("reload");   
        this.$job_request_upload.bootgrid("reload");
        this.$archived_job_request.bootgrid("reload");
        this.$available_job_element.bootgrid("reload");
        this.$attach_job_element.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # job_request table init
    | ---------------------------------
    */
    job_request.prototype.init = function() {   
        
        if(base_module == "add" || base_module == "edit")
        {
            Dropzone.options.myAwesomeDropzone = false;
            Dropzone.autoDiscover = false;

            $('#dropzone').dropzone({
                init: function () {
                    this.on("processing", function(file) {
                       this.options.url = base_url + 'job-request/uploads/'+ job_data;
                    }).on("queuecomplete", function (file, response) {
                        $.job_request.reload();
                    });               
                 }
            });
        }
        /*
        | ---------------------------------
        | # select, input, and textarea on change or keyup remove error
        | ---------------------------------
        */
        this.$body.on('change', 'select, input', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });  
        
        this.$body.on('dp.change', '.date-picker, .time-picker', function (e){
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });
        /*
        | ---------------------------------
        | # job request date
        | ---------------------------------
        */
        this.$body.on('dp.change', '#job_request_module_req_date', function (e) {
            e.preventDefault();
            var current_date = moment(new Date()).format('DD-MMM-YYYY');
            var value_date = $(this).val();

            if(value_date >= current_date)
            {}
            else
            {
                swal({
                    title: "Oops, it's invalid date!",
                    text: "Please choose a present date only.", 
                    type: "warning"
                });
                $(this).val(current_date);
            }
        });

        /*
        | ---------------------------------
        | # job request due date
        | ---------------------------------
        */
        this.$body.on('dp.change', '#job_request_module_due_date', function (e) {
            e.preventDefault();
            var request_date = $('#job_request_module_req_date').val();
            var value_date = $(this).val();

            if(value_date >= request_date)
            {}
            else
            {
                swal({
                    title: "Oops, it's invalid date!",
                    text: "Please choose a date not lesser than request date.", 
                    type: "warning"
                });
                $(this).val(request_date);
            }
        });

        /*
        | ---------------------------------
        | # job request type sequence
        | ---------------------------------
        */
        this.$body.on('change', '#job_request_type_id', function (e) {
            e.preventDefault();
            var id       = $(this).val();
            var job      = $('#job_order_no').val();
            var module   = $('#job_request_module_id').val();
            var url      = base_url + 'job-request/check-job-request-type-sequence/'+ id + '/' + module + '/' + job;
            var sequence = $('#job_request_sequence');

            if(id != "0")
            {
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = $.parseJSON( data );
                        sequence.val(data.sequence);
                    },
                }); 
            }
            else 
            {
                sequence.val('0'); 
            } 

        });

        /*
        | ---------------------------------
        | # when job_status_id has changed
        | ---------------------------------
        */
        this.$body.on('change', '#job_status_id', function (e) {
            e.preventDefault();
            $.job_request.reload_job_request_selectpicker($(this).val(), 'job_request_id');
            $('#job_request_type_id, #job_request_category_id').selectpicker('deselectAll');
        });

        /*
        | ---------------------------------
        | # when job_request_id has changed
        | ---------------------------------
        */
        this.$body.on('change', '#job_request_id', function (e) {
            e.preventDefault();
            $.job_request.reload_job_request_type_selectpicker($(this).val(), 'job_request_type_id');
            $.job_request.reload_job_request_category_selectpicker($(this).val(), 'job_request_category_id');
        });        

        /*
        | ---------------------------------
        | # job request save
        | ---------------------------------
        */
        this.$body.on('click', '#save-job-request-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#job-request-form");
            var $errors = $.job_request.validate($form, $error);
            var $action = base_url + "job-request/";
            var $module = $("#job_request_module_id");
            var $job_order_no = $("#job_order_no").val();
            var $job_request_sequence = $("#job_request_sequence").val();

            if($errors != 0) { 
                $.job_request.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The Job Request's Information will be save to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        if(($module.val() != "none") && ($module.val() != ""))
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'update?job_order_no=' + $job_order_no + '&job_request_sequence= ' + $job_request_sequence + '&module_id=' + $module.val(),
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.job_request.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.job_request.reload();
                                    }, 5000);                             
                                }
                            }); 
                        } 
                        else 
                        {   
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'save?job_order_no=' + $job_order_no + '&job_request_sequence= ' + $job_request_sequence,
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.job_request.swAlert('timer', $form); 
                                    $module.val(data.job_request_module_id);
                                    job_data = data.job_request_module_id;

                                    setTimeout(function(){ 
                                        $('.card.hidden').removeClass('hidden').addClass('zoomInDown animated');
                                        $.job_request.reload();
                                    }, 5000);                             
                                }
                            }); 
                        }
                      
                    }
                });            
            }

        });
    
        /*
        | ---------------------------------
        | # job request upload table initialized
        | ---------------------------------
        */
        job_request_uploadTable = this.$job_request_upload.bootgrid({
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
                    return  "<button title=\"remove this\" type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button> " + 
                            "<button title=\"download this\" type=\"button\" class=\"btn btn-icon command-download waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-download\"></span></button> ";
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
                console.log(request.job_request_module_id = $("#job_request_module_id").val());
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "job-order/manage/job-request/"+ $("#job_order_no").val()+ "/upload-lists/",
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
            | # job request upload table delete
            | ---------------------------------
            */
            job_request_uploadTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    file = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "job-request/delete-uploads/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The Upload File (" +file+ ") with ID "+id+" will be removed from your records.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, Cancel plx!",
                    closeOnConfirm: false
                }, function(){
                    
                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function (data) {
                            console.log(data);
                            swal({
                                title: "Deleted!",
                                text: "The Upload File (" +file+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.job_request.reload();
                            });     
                        },
                    });  

                });
            });


            /*
            | ---------------------------------
            | # job request upload table download
            | ---------------------------------
            */
            job_request_uploadTable.find(".command-download").on("click", function (e) {
                e.preventDefault();

                var id       = $(this).parents('tr').data('row-id'),
                    filename = $(this).parents('tr').find('td:nth-child(3)').text(),
                    file = $(this).parents('tr').find('td:nth-child(5)').text(),
                    url      = base_url + "job-request/download/"+ file;

                swal({
                    title: "Are you sure?",
                    text:  "The File (" +filename+ ") with ID "+id+" will be downloaded.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Download it!",
                    cancelButtonText: "No, Cancel plx!",
                    closeOnConfirm: true
                }, function(){
                    
                    window.location = url;


                });
            });

        });

        /*
        | ---------------------------------
        | # job_request table initialized
        | ---------------------------------
        */
        job_requestTable = this.$job_request.bootgrid({
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
                "state" : function(column, row) {
                    if(row.state=="2"){
                        return "<label class='palette-Yellow-A700 bg labels'>pending</label>";
                    } else if(row.state=="3"){
                        return "<label class='palette-Orange-300 bg labels'>requested</label>";
                    } else if(row.state=="4"){
                        return "<label class='palette-Light-Green-500 bg labels'>served</label>";
                    } else if(row.state=="5"){
                        return "<label class='palette-Red-400 bg labels'>cancelled</label>";
                    } else {
                        return "<label class='palette-Grey-500 bg labels'>saved</label>";
                    }
                },
                "commands": function(column, row) {
                    return  "<button title=\"edit this\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> "+
                            "<button title=\"remove this\" type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button> "+
                            "<button title=\"attach this\" type=\"button\" class=\"btn btn-icon command-attach waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-attachment-alt\"></span></button> "+
                            "<button title=\"send this\" type=\"button\" class=\"btn btn-icon command-send waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-mail-send\"></span></button>";
                },
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
            url: base_url + "job-order/manage/job-request/lists/"+ base_line,
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
            | # job request edit
            | ---------------------------------
            */
            job_requestTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id    = $(this).parents('tr').data('row-id'),
                job_order = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url   = base_url + "job-order/manage/job-request/" + base_line + "/edit/"+id,
                    state = $(this).parents('tr').find('td:nth-child(8)').text();

                if(state != "served")
                {
                    document.location = url;  
                }
                else {
                    swal({
                        title: "Warning",
                        text:  "Unable to process a served Job Request.",
                        type: "warning",
                        confirmButtonText: "Ok",
                        closeOnConfirm: true
                    });
                }
                
            });

            /*
            | ---------------------------------
            | # job request send
            | ---------------------------------
            */
            job_requestTable.find(".command-send").on("click", function (e) {
                e.preventDefault();

                var id           = $(this).parents('tr').data('row-id'),
                job_status       = $(this).parents('tr').find('td:nth-child(3)').text(),
                job_request      = $(this).parents('tr').find('td:nth-child(4)').text(),
                job_request_type = $(this).parents('tr').find('td:nth-child(5)').text(),
                    url          = base_url + "job-request",
                    state        = $(this).parents('tr').find('td:nth-child(8)').text();

                if( (job_request && job_request_type) == 'Estimate' && state == "saved")
                {
                    $.ajax({
                        type: 'POST',
                        url: url + "/check-element/" + base_line + "/" + id,
                        success: function (data) {
                            console.log(data);
                            var data = $.parseJSON( data );
                            console.log(data.counts);
                            if(data.counts > 0)
                            {   
                                swal({
                                    title: "Do you like to send it now?",
                                    text: "The request will be send for approvals.",
                                    type: "info",
                                    confirmButtonText: "Yes, please!",
                                    cancelButtonText: "No, thanks!",
                                    showCancelButton: true,   
                                    closeOnConfirm: false,   
                                    showLoaderOnConfirm: true,
                                }, function(isConfirm){
                                    if (isConfirm) {    

                                        $.ajax({
                                            type: 'POST',
                                            url: url + "/send/" + id,
                                            success: function (data) {
                                                
                                            },
                                        });  

                                        $.job_request.swAlert('send', '');
                                    }
                                });    
                                
                            } 
                            else
                            {
                                swal({
                                    title: "Warning",
                                    text:  "There's no element attached on the request, please add element first first.",
                                    type: "warning",
                                    confirmButtonText: "Ok",
                                    closeOnConfirm: true
                                });
                            }
                        },
                    });     
                }
                /*else {
                    swal({
                        title: "Warning",
                        text:  "Unable to process a served Job Request.",
                        type: "warning",
                        confirmButtonText: "Ok",
                        closeOnConfirm: true
                    });
                }*/
                
            });

            /*
            | ---------------------------------
            | # job request edit
            | ---------------------------------
            */
            job_requestTable.find(".command-attach").on("click", function (e) {
                e.preventDefault();

                var id           = $(this).parents('tr').data('row-id'),
                job_status       = $(this).parents('tr').find('td:nth-child(3)').text(),
                job_request      = $(this).parents('tr').find('td:nth-child(4)').text(),
                job_request_type = $(this).parents('tr').find('td:nth-child(5)').text(),
                    url          = base_url + "job-order/manage/job-request/" + base_line + "/attach/"+id,
                    state        = $(this).parents('tr').find('td:nth-child(8)').text();

                if( (job_request && job_request_type) == 'Estimate' && state == "saved")
                {
                    document.location = url;    
                } else {
                    swal({
                        title: "Warning",
                        text:  "Unable to process, please check the Job Request Information first.",
                        type: "warning",
                        confirmButtonText: "Ok",
                        closeOnConfirm: true
                    });
                }

                
            });

            /*
            | ---------------------------------
            | # job element table delete
            | ---------------------------------
            */
            job_requestTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id    = $(this).parents('tr').data('row-id'),
                    name  = $(this).parents('tr').find('td:nth-child(4)').text(),
                    url   = base_url + "job-request/delete/"+id,
                    state = $(this).parents('tr').find('td:nth-child(8)').text();

                if(state != "served")
                {
                    swal({
                        title: "Are you sure?",
                        text:  "The Job Request (" +name+ ") with ID "+id+" will be cancelled from your records.",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Cancel it!",
                        cancelButtonText: "No, not now!",
                        closeOnConfirm: false
                    }, function(){
                        
                        $.ajax({
                            type: 'POST',
                            url: url,
                            success: function (data) {
                                console.log(data);
                                swal({
                                    title: "Cancelled",
                                    text: "The Job Request (" +name+ ") with ID "+id+" has been moved to archived!",
                                    type: "success",
                                    },
                                    function(){                                     
                                        $.job_request.reload();
                                });     
                            },
                        });  

                    });
                } else {
                    swal({
                        title: "Warning",
                        text:  "Unable to process a served Job Request.",
                        type: "warning",
                        confirmButtonText: "Ok",
                        closeOnConfirm: true
                    });
                }

            });

        }); 


        /*
        | ---------------------------------
        | # archived job request table initialized
        | ---------------------------------
        */
        archived_job_requestTable = this.$archived_job_request.bootgrid({
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
                "state" : function(column, row) {
                    if(row.state=="requested"){
                        return "<label class='palette-Orange-300 bg labels'>requested</label>";
                    } else if(row.state=="served"){
                        return "<label class='palette-Light-Green-500 bg labels'>served</label>";
                    } else if(row.state=="cancelled"){
                        return "<label class='palette-Red-400 bg labels'>cancelled</label>";
                    } else {
                        return "<label class='palette-Grey-500 bg labels'>saved</label>";
                    }
                },
                "commands": function(column, row) {
                    return  "<button title=\"restore this\" type=\"button\" class=\"btn btn-icon command-undo waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-undo\"></span></button> ";
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
            url: base_url + "job-order/manage/job-request/lists/"+ base_module_line + "/archived",
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
            | # job element table delete
            | ---------------------------------
            */
            archived_job_requestTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    name = $(this).parents('tr').find('td:nth-child(4)').text(),
                    url  = base_url + "job-request/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The Job Request (" +name+ ") with ID "+id+" will be restored in your records.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Restore it!",
                    cancelButtonText: "No, Cancel plx!",
                    closeOnConfirm: false
                }, function(){
                    
                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function (data) {
                            console.log(data);
                            swal({
                                title: "Restored!",
                                text: "The Job Request (" +name+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.job_request.reload();
                            });     
                        },
                    });  

                });
            });

        });



        /*
        | ---------------------------------
        | # job request save
        | ---------------------------------
        */
        this.$body.on('click', '#save-attach-element-btn', function (e) {
            e.preventDefault();
            var $action = base_url + "job-request/save-elements/" + base_line;
            var $selected = '&elements='+$("#available-job-element-table").bootgrid("getSelectedRows");
            
            swal({
                title: "Do you like to save it now?",
                text: "The attached Job Elements will be saved to Job Request.",
                type: "info",
                confirmButtonText: "Yes, please!",
                cancelButtonText: "No, thanks!",
                showCancelButton: true,   
                closeOnConfirm: false,   
                showLoaderOnConfirm: true,
            }, function(isConfirm){
                if (isConfirm) {  

                    $.ajax({
                        type: "GET",
                        url: $action,
                        data: $selected,
                        success: function (data) {   
                            var data = $.parseJSON(data);

                            console.log(data);
                            $.job_request.swAlert('timer', 'avaialbe-element'); 

                            setTimeout(function(){ 
                                $.job_request.reload();
                            }, 5000);                            
                        }
                    }); 
                  
                }
            });      

        });

        var selectedGroupRowCount = [];
        /*
        | ---------------------------------
        | # available element table initialized
        | ---------------------------------
        */
        available_job_elementTable = this.$available_job_element.bootgrid({
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
                console.log(request.job_order_no = $('#job_order_no').val());
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "job-element/available-elements/"+ base_line,
            keepSelection: true,
            selection: true,
            multiSelect: true,
            caseSensitive: false,
        }).on("selected.rs.jquery.bootgrid", function(e, rows)
        {
            
            selectedGroupRowCount.push(rows);
            console.log(selectedGroupRowCount);
            if( selectedGroupRowCount.length > 0 )
            {
                $('.d-btn1').addClass('show');
            } else {
                $('.d-btn1').removeClass('show');
            }

            var _selectedRows = available_job_elementTable.bootgrid('getSelectedRows');
            console.log('selected: '+_selectedRows);
            console.log('_selectedRows:'+_selectedRows.length);
            if( _selectedRows.length > 0 )
            {
                $('.d-btn1').addClass('show');
            }

        }).on("deselected.rs.jquery.bootgrid", function(e, rows)
        {
            selectedGroupRowCount.splice(-1, 1);
            console.log(selectedGroupRowCount);
            if( selectedGroupRowCount.length > 0 )
            {
                $('.d-btn1').addClass('show');
            } else {
                $('.d-btn1').removeClass('show');
            }

            var _selectedRows = available_job_elementTable.bootgrid('getSelectedRows');
            console.log('selected: '+_selectedRows);
            console.log('_selectedRows:'+_selectedRows.length);
            if( _selectedRows.length <= 0 )
            { 
                $('.d-btn1').removeClass('show');
            }

        }).on("loaded.rs.jquery.bootgrid", function (e, rows) {

        });

        /*
        | ---------------------------------
        | # available element table initialized
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
                    return  "<button title=\"remove this\" type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button> ";
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

            /*
            | ---------------------------------
            | # job request upload table delete
            | ---------------------------------
            */
            attach_job_elementTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id      = $(this).parents('tr').find('td:nth-child(1)').text(),
                    elem = $(this).parents('tr').find('td:nth-child(2)').text(),
                    url     = base_url + "job-request/delete-element/" + base_line;

                swal({
                    title: "Are you sure?",
                    text:  "The attached Job Element (" +elem+ ") with ID "+id+" will be removed from Job Request.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Remove it!",
                    cancelButtonText: "No, Cancel plx!",
                    closeOnConfirm: false
                }, function(){
                    
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: '&elements=' + id,
                        success: function (data) {
                            console.log(data);
                            swal({
                                title: "Removed!",
                                text: "The attached Job Element (" +elem+ ") with ID "+id+" has been successfully removed!",
                                type: "success",
                                },
                                function(){                                     
                                    $.job_request.reload();
                            });     
                        },
                    });  

                });
            });

        });

    },

    //init job_request
    $.job_request = new job_request, $.job_request.Constructor = job_request

}(window.jQuery),

//initializing job_request
function($) {
    "use strict";
    $.job_request.init();
    $.job_request.required_fields();
}(window.jQuery);