!function($) {
    "use strict";

    var job_element = function() {
        this.$body = $("body")
        this.$job_element = $("#job-element-table");
        this.$archived_job_element = $("#archived-job-element-table");
        this.$job_element_upload = $("#job-element-upload-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var archived_job_elementTable, job_elementTable, job_element_uploadTable, job_data = $('#job_elements_id').val(); 

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    job_element.prototype.required_fields = function($form) {

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
    job_element.prototype.validate = function($form, $error) {
                            
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

    job_element.prototype.refresh_modal = function() {
        var $button = $('#save-billing-line-btn');
        var $modals = $('#billing-line-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.billing-title').text('Add New Billing Line');
        $modals.find('.modal-title span.billing-line-job-no').text($("#job_element_no").val());
        $modals.modal('hide');
    },

    /*
    | ---------------------------------
    | # refresh form
    | ---------------------------------
    */
    job_element.prototype.refresh = function($form) {

        
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
    job_element.prototype.swAlert = function($type, $form) {

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
                        $.job_element.refresh($form);
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
                $.job_element.reload();  
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
    | # job_element table reload
    | ---------------------------------
    */
    job_element.prototype.reload = function() {
        this.$job_element.bootgrid("reload");   
        this.$job_element_upload.bootgrid("reload");
        this.$archived_job_element.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # job_element table init
    | ---------------------------------
    */
    job_element.prototype.init = function() {   
        
        if(base_module == "add" || base_module == "edit")
        {
            Dropzone.options.myAwesomeDropzone = false;
            Dropzone.autoDiscover = false;

            $('#dropzone').dropzone({
                init: function () {
                    this.on("processing", function(file) {
                       this.options.url = base_url + 'job-element/uploads/'+ job_data;
                    }).on("queuecomplete", function (file, response) {
                        $.job_element.reload();
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

        /*
        | ---------------------------------
        | # job request save
        | ---------------------------------
        */
        this.$body.on('click', '#save-job-element-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#job-element-form");
            var $errors = $.job_element.validate($form, $error);
            var $action = base_url + "job-element/";
            var $elements = $("#job_elements_id");
            var $job_order_no = $("#job_order_no").val();
            var $job_element_sequence = $("#job_element_sequence").val();

            if($errors != 0) { 
                $.job_element.swAlert('error', $form);
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

                        if(($elements.val() != "none") && ($elements.val() != ""))
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'update?job_order_no=' + $job_order_no + '&elements_id=' + $elements.val(),
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.job_element.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.job_element.reload();
                                    }, 5000);                             
                                }
                            }); 
                        } 
                        else 
                        {   
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'save?job_order_no=' + $job_order_no,
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.job_element.swAlert('timer', $form); 
                                    $elements.val(data.job_elements_id);
                                    job_data = data.job_elements_id;

                                    setTimeout(function(){ 
                                        $('.card.hidden.card-padding').removeClass('hidden').addClass('zoomInDown animated');
                                        $.job_element.reload();
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
        job_element_uploadTable = this.$job_element_upload.bootgrid({
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
                console.log(request.job_elements_id = $("#job_elements_id").val());
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "job-order/manage/job-element/"+ $("#job_order_no").val()+ "/upload-lists/",
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
            job_element_uploadTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    file = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "job-element/delete-uploads/"+id;

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
                                    $.job_element.reload();
                            });     
                        },
                    });  

                });
            });

            /*
            | ---------------------------------
            | # job element upload table download
            | ---------------------------------
            */
            job_element_uploadTable.find(".command-download").on("click", function (e) {
                e.preventDefault();

                var id       = $(this).parents('tr').data('row-id'),
                    filename = $(this).parents('tr').find('td:nth-child(3)').text(),
                    file = $(this).parents('tr').find('td:nth-child(5)').text(),
                    url      = base_url + "job-element/download/"+ file;

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
        | # job_element table initialized
        | ---------------------------------
        */
        job_elementTable = this.$job_element.bootgrid({
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
                    return  "<button title=\"edit this\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> "+
                            "<button title=\"remove this\" type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
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
            url: base_url + "job-order/manage/job-element/lists/"+ base_line,
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
            | # job element table edit
            | ---------------------------------
            */
            job_elementTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                job_order = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "job-order/manage/job-element/" + base_line + "/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # job element table delete
            | ---------------------------------
            */
            job_elementTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    name = $(this).parents('tr').find('td:nth-child(5)').text(),
                    url  = base_url + "job-element/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The Job Element (" +name+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The Job Element (" +name+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.job_element.reload();
                            });     
                        },
                    });  

                });
            });

        }); 


        /*
        | ---------------------------------
        | # archived job request table initialized
        | ---------------------------------
        */
        archived_job_elementTable = this.$archived_job_element.bootgrid({
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
            url: base_url + "job-order/manage/job-element/lists/"+ base_module_line + "/archived",
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
            archived_job_elementTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    name = $(this).parents('tr').find('td:nth-child(5)').text(),
                    url  = base_url + "job-element/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The Job Element (" +name+ ") with ID "+id+" will be restored in your records.",
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
                                text: "The Job Element (" +name+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.job_element.reload();
                            });     
                        },
                    });  

                });
            });

        });

    },

    //init job_element
    $.job_element = new job_element, $.job_element.Constructor = job_element

}(window.jQuery),

//initializing job_element
function($) {
    "use strict";
    $.job_element.init();
    $.job_element.required_fields();
}(window.jQuery);