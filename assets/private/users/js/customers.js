!function($) {
    "use strict";

    var customer = function() {
        this.$body = $("body")
        this.$customer = $("#customer-table");
        this.$archived_customer = $("#archived-customer-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var customerTable, archived_customerTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    customer.prototype.required_fields = function($form) {

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
    customer.prototype.validate = function($form, $error) {
                            
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

    /*
    | ---------------------------------
    | # refresh form
    | ---------------------------------
    */
    customer.prototype.refresh = function($form) {

        $(".selectpicker").selectpicker('deselectAll');
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
    customer.prototype.swAlert = function($type, $form) {

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
                        $.customer.refresh($form);
                        document.location.href = base_url + 'maintenance/customer/manage';
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # customer table reload
    | ---------------------------------
    */
    customer.prototype.reload = function() {
        this.$customer.bootgrid("reload");   
        this.$archived_customer.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # customer image file
    | ---------------------------------
    */
    customer.prototype.image_file = function() {

        var url  = base_url + "maintenance/customer/find/"+base_line;

        if($.isNumeric(base_line)){
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = $.parseJSON( data );
                    $(".fileinput").removeClass("fileinput-new").addClass("fileinput-exists");
                    $('.thumbnail').prepend("<img src='"+base_url+"uploads/"+data[0].customer_logo+"' />");
                },
            });  

        } else {
            $(".fileinput").removeClass("fileinput-exists").addClass("fileinput-new");
            $("#customer_logo").val(''); 
        }

    },

    /*
    | ---------------------------------
    | # customer table init
    | ---------------------------------
    */
    customer.prototype.init = function() {   

        /*
        | ---------------------------------
        | # local variables
        | ---------------------------------
        */ 
        var files;    
        $('input[type=file]').on('change', prepareUpload);    
        function prepareUpload(event)
        {
          files = event.target.files;
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

        this.$body.on('click', '#close-btn', function (e) {
            e.preventDefault();
            var $form = $(this).closest("form");
            $.customer.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        /*
        | ---------------------------------
        | # customer save
        | ---------------------------------
        */
        this.$body.on('click', '#save-customer-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#customer-form");
            var $errors = $.customer.validate($form, $error);
            var $action = base_url + "maintenance/customer/";

            if($('#customer_logo').val()){
                var inputfile = $('#customer_logo').get(0).files[0].name;    
            } else {
                var inputfile = '';
            }    

            if($errors != 0) { 
                $.customer.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The Customer's Information will be save to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        if($('#customer_logo').val()){
                                
                            var data = new FormData();
                            $.each(files, function(key, value)
                            {
                                data.append(key, value);
                            });     

                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + "uploads?files",
                                data: data,
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    console.log(data);                       
                                }
                            });   

                        }

                        $.ajax({
                            type: $form.attr("method"),
                            url: $action + "save?filename="+inputfile,
                            data: $form.serialize(),
                            beforeSend: function(){
                                $.customer.refresh($form);                                 
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.customer.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # customer edit
        | ---------------------------------
        */
        this.$body.on('click', '#edit-customer-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#customer-form");
            var $errors = $.customer.validate($form, $error);
            var $action = base_url + "maintenance/customer/";

            if($('#customer_logo').val()){
                var inputfile = $('#customer_logo').get(0).files[0].name;    
            }
            else if($('#customer_logo').attr('value') != "") {
                var inputfile = $('#customer_logo').attr('value') + '&old=true';
            } 
            else {
                var inputfile = '';
            }    

            if($errors != 0) { 
                $.customer.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The Customer's Information will be save to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        if($('#customer_logo').val()){
                                
                            var data = new FormData();
                            $.each(files, function(key, value)
                            {
                                data.append(key, value);
                            });     

                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + "uploads?files",
                                data: data,
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    console.log(data);                       
                                }
                            });   

                        }

                        $.ajax({
                            type: $form.attr("method"),
                            url: $action + "update/"+base_line+"?filename="+inputfile,
                            data: $form.serialize(),
                            beforeSend: function(){
                                $.customer.refresh($form);                                 
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.customer.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # customer table initialized
        | ---------------------------------
        */
        customerTable = this.$customer.bootgrid({
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
            url: base_url + "maintenance/customer/lists",
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
            | # customer delete
            | ---------------------------------
            */
            customerTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                customer = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/customer/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # customer delete
            | ---------------------------------
            */
            customerTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                customer = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/customer/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The customer (" +customer+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The customer (" +customer+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.customer.reload();
                            });     
                        },
                    });  

                });
            });

        }); 
        
        /*
        | ---------------------------------
        | # customer table initialized
        | ---------------------------------
        */
        archived_customerTable = this.$archived_customer.bootgrid({
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
            url: base_url + "maintenance/customer/archived-lists",
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
            | # customer undo
            | ---------------------------------
            */
            archived_customerTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                customer = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/customer/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The customer (" +customer+ ") with ID "+id+" will be restored from your records.",
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
                                text: "The customer (" +customer+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.customer.reload();
                            });     
                        },
                    });  

                });
            });

        }); 

    },

    //init customer
    $.customer = new customer, $.customer.Constructor = customer

}(window.jQuery),

//initializing customer
function($) {
    "use strict";
    $.customer.init();
    $.customer.required_fields();
    $.customer.image_file();
}(window.jQuery);