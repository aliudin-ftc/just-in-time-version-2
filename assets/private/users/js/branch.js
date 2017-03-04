!function($) {
    "use strict";

    var branch = function() {
        this.$body = $("body")
        this.$branch = $("#branch-table");
        this.$archived_branch = $("#archived-branch-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var branchTable, archived_branchTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    branch.prototype.required_fields = function($form) {

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
    branch.prototype.validate = function($form, $error) {
                            
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
    branch.prototype.refresh = function($form) {

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
    branch.prototype.swAlert = function($type, $form) {

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
                        $.branch.refresh($form);
                        document.location.href = base_url + 'maintenance/branch/manage';
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # branch table reload
    | ---------------------------------
    */
    branch.prototype.reload = function() {
        this.$branch.bootgrid("reload");   
        this.$archived_branch.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # branch image file
    | ---------------------------------
    */
    branch.prototype.image_file = function() {

        var url  = base_url + "maintenance/branch/find/"+base_line;

        if($.isNumeric(base_line)){
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = $.parseJSON( data );
                    $(".fileinput").removeClass("fileinput-new").addClass("fileinput-exists");
                    $('.thumbnail').prepend("<img src='"+base_url+"uploads/"+data[0].branch_logo+"' />");
                },
            });  

        } else {
            $(".fileinput").removeClass("fileinput-exists").addClass("fileinput-new");
            $("#branch_logo").val(''); 
        }

    },

    /*
    | ---------------------------------
    | # branch table init
    | ---------------------------------
    */
    branch.prototype.init = function() {   

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
            $.branch.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        /*
        | ---------------------------------
        | # branch save
        | ---------------------------------
        */
        this.$body.on('click', '#save-branch-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#branch-form");
            var $errors = $.branch.validate($form, $error);
            var $action = base_url + "maintenance/branch/";

            if($errors != 0) { 
                $.branch.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The branch's Information will be save to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        $.ajax({
                            type: "GET",//$form.attr("method"),
                            url: $action + "save",
                            data: $form.serialize(),
                            beforeSend: function(){
                                $.branch.refresh($form);                                 
                            },
                            success: function (data) {                                    
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.branch.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # branch edit
        | ---------------------------------
        */
        this.$body.on('click', '#edit-branch-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#branch-form");
            var $errors = $.branch.validate($form, $error);
            var $action = base_url + "maintenance/branch/";   

            if($errors != 0) { 
                $.branch.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The branch's Information will be save to the database.",
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
                                $.branch.refresh($form);                                 
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.branch.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # branch table initialized
        | ---------------------------------
        */
        branchTable = this.$branch.bootgrid({
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
            url: base_url + "maintenance/branch/lists",
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
            | # branch delete
            | ---------------------------------
            */
            branchTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                branch = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/branch/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # branch delete
            | ---------------------------------
            */
            branchTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                branch = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/branch/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The branch (" +branch+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The branch (" +branch+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.branch.reload();
                            });     
                        },
                    });  

                });
            });

        }); 
        
        /*
        | ---------------------------------
        | # branch table initialized
        | ---------------------------------
        */
        archived_branchTable = this.$archived_branch.bootgrid({
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
            url: base_url + "maintenance/branch/archived-lists",
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
            | # branch undo
            | ---------------------------------
            */
            archived_branchTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                branch = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/branch/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The branch (" +branch+ ") with ID "+id+" will be restored from your records.",
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
                                text: "The branch (" +branch+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.branch.reload();
                            });     
                        },
                    });  

                });
            });

        }); 

    },

    //init branch
    $.branch = new branch, $.branch.Constructor = branch

}(window.jQuery),

//initializing branch
function($) {
    "use strict";
    $.branch.init();
    $.branch.required_fields();
    $.branch.image_file();
}(window.jQuery);