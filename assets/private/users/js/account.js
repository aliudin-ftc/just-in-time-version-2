!function($) {
    "use strict";

    var account = function() {
        this.$body = $("body")
        this.$account = $("#account-table");
        this.$archived_account = $("#archived-account-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var accountTable, archived_accountTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    account.prototype.required_fields = function($form) {

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
    account.prototype.validate = function($form, $error) {
                            
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
    account.prototype.refresh = function($form) {

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
    account.prototype.swAlert = function($type, $form) {

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
                        $.account.refresh($form);
                        document.location.href = base_url + 'maintenance/account/manage';
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # account table reload
    | ---------------------------------
    */
    account.prototype.reload = function() {
        this.$account.bootgrid("reload");   
        this.$archived_account.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # account image file
    | ---------------------------------
    */
    account.prototype.image_file = function() {

        var url  = base_url + "maintenance/account/find/"+base_line;

        if($.isNumeric(base_line)){
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = $.parseJSON( data );
                    $(".fileinput").removeClass("fileinput-new").addClass("fileinput-exists");
                    $('.thumbnail').prepend("<img src='"+base_url+"uploads/"+data[0].account_logo+"' />");
                },
            });  

        } else {
            $(".fileinput").removeClass("fileinput-exists").addClass("fileinput-new");
            $("#account_logo").val(''); 
        }

    },

    /*
    | ---------------------------------
    | # account table init
    | ---------------------------------
    */
    account.prototype.init = function() {   

        /*
        | ---------------------------------
        | # local variables
        | ---------------------------------
        */ 
        
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
            $.account.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        /*
        | ---------------------------------
        | # account save
        | ---------------------------------
        */
        this.$body.on('click', '#save-account-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#account-form");
            var $errors = $.account.validate($form, $error);
            var $action = base_url + "maintenance/account/";

            if($errors != 0) { 
                $.account.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The account's Information will be save to the database.",
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
                            url: $action + "save",
                            data: $form.serialize(),
                            beforeSend: function(){
                                $.account.refresh($form);                                 
                            },
                            success: function (data) {                                    
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.account.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # account edit
        | ---------------------------------
        */
        this.$body.on('click', '#edit-account-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#account-form");
            var $errors = $.account.validate($form, $error);
            var $action = base_url + "maintenance/account/";

            if($errors != 0) { 
                $.account.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The account's Information will be save to the database.",
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
                            url: $action + "update/"+base_line,
                            data: $form.serialize(),
                            beforeSend: function(){
                                $.account.refresh($form);                                 
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.account.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # account table initialized
        | ---------------------------------
        */
        accountTable = this.$account.bootgrid({
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
            url: base_url + "maintenance/account/lists",
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
            | # account delete
            | ---------------------------------
            */
            accountTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                account = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/account/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # account delete
            | ---------------------------------
            */
            accountTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                account = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/account/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The account (" +account+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The account (" +account+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.account.reload();
                            });     
                        },
                    });  

                });
            });

        }); 
        
        /*
        | ---------------------------------
        | # account table initialized
        | ---------------------------------
        */
        archived_accountTable = this.$archived_account.bootgrid({
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
            url: base_url + "maintenance/account/archived-lists",
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
            | # account undo
            | ---------------------------------
            */
            archived_accountTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                account = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/account/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The account (" +account+ ") with ID "+id+" will be restored from your records.",
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
                                text: "The account (" +account+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.account.reload();
                            });     
                        },
                    });  

                });
            });

        }); 

    },

    //init account
    $.account = new account, $.account.Constructor = account

}(window.jQuery),

//initializing account
function($) {
    "use strict";
    $.account.init();
    $.account.required_fields();
    $.account.image_file();
}(window.jQuery);