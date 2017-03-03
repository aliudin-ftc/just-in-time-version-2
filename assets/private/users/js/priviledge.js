!function($) {
    "use strict";

    var priviledge = function() {
        this.$body = $("body")
        this.$priviledge = $("#priviledge-table");
        this.$archived_priviledge = $("#archived-priviledge-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var priviledgeTable, archived_priviledgeTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    priviledge.prototype.required_fields = function($form) {

        $.each(this.$body.find(".form-group"), function(){
            
            if($(this).hasClass('required')) {
                $(this).find('label').append('<span class="pull-right c-red">*</span>');            
                $(this).find("input[type='text'], input[type='password'], select, textarea").addClass('required');
            }   

        });

    },    

    /*
    | ---------------------------------
    | # validate form
    | ---------------------------------
    */
    priviledge.prototype.validate = function($form, $error) {
                            
        $.each($form.find("input[type='text'], input[type='password'], select, textarea"), function(){
               
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

        var atLeastOneIsChecked = false;
        $('input:checkbox').each(function () {
            if ($(this).is(':checked')) {
                atLeastOneIsChecked = true;
            }
        });

        if(atLeastOneIsChecked == false) {
            $error++;
            $('.checkbox-priviledge').text('please select 1 or more modules.');
        } else {
            $('.checkbox-priviledge').text('');
        }

        return $error;

    },    

    /*
    | ---------------------------------
    | # refresh form
    | ---------------------------------
    */
    priviledge.prototype.refresh = function($form) {

        $(".selectpicker").selectpicker('deselectAll');
        $.each($form.find("input[type='text'], input[type='password'],  select, textarea"), function(){
            
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
    priviledge.prototype.swAlert = function($type, $form) {

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
                        $.priviledge.refresh($form);
                        document.location.href = base_url + 'maintenance/priviledge/manage';
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # priviledge checkboxes on change
    | ---------------------------------
    */
    priviledge.prototype.checkboxes = function() {
        var atLeastOneIsChecked = false;
        $('input:checkbox').each(function () {
            if ($(this).is(':checked')) {
                atLeastOneIsChecked = true;
            }
        });

        if(atLeastOneIsChecked == false) {
            $('.checkbox-priviledge').text('please select 1 or more modules.');
        }
    },

    /*
    | ---------------------------------
    | # priviledge table reload
    | ---------------------------------
    */
    priviledge.prototype.reload = function() {
        this.$priviledge.bootgrid("reload");   
        this.$archived_priviledge.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # priviledge table init
    | ---------------------------------
    */
    priviledge.prototype.init = function() {   

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
            $.priviledge.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        /*
        | ---------------------------------
        | # priviledge modules clicked
        | ---------------------------------
        */
        this.$body.on('click', '.mods', function (e) {
            var parent = $(this).closest('.layers')
            var val = $(this).prop("checked");
            $.priviledge.checkboxes();

            if (val) {
                parent.find('.subs').prop("checked", true);
            } else {
                parent.find('.subs').prop("checked", false);  
            }
        });

        /*
        | ---------------------------------
        | # priviledge sub modules clicked
        | ---------------------------------
        */
        this.$body.on('click', '.subs', function (e) {
            $.priviledge.checkboxes();
        });

        /*
        | ---------------------------------
        | # priviledge save
        | ---------------------------------
        */
        this.$body.on('click', '#save-priviledge-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#priviledge-form");
            var $errors = $.priviledge.validate($form, $error);
            var $action = base_url + "maintenance/priviledge/";

            
            if($errors != 0) { 
                $.priviledge.swAlert('error', $form);
            } else {

                  
                swal({
                    title: "Do you like to save it now?",
                    text: "The priviledge's Information will be save to the database.",
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
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.priviledge.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # priviledge edit
        | ---------------------------------
        */
        this.$body.on('click', '#edit-priviledge-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#priviledge-form");
            var $errors = $.priviledge.validate($form, $error);
            var $action = base_url + "maintenance/priviledge/";

            if($errors != 0) { 
                $.priviledge.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The priviledge's Information will be save to the database.",
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
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.priviledge.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # priviledge table initialized
        | ---------------------------------
        */
        priviledgeTable = this.$priviledge.bootgrid({
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
            url: base_url + "maintenance/priviledge/lists",
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
            | # priviledge delete
            | ---------------------------------
            */
            priviledgeTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                priviledge = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/priviledge/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # priviledge delete
            | ---------------------------------
            */
            priviledgeTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                priviledge = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/priviledge/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The priviledge (" +priviledge+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The priviledge (" +priviledge+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.priviledge.reload();
                            });     
                        },
                    });  

                });
            });

        }); 
        
        /*
        | ---------------------------------
        | # priviledge table initialized
        | ---------------------------------
        */
        archived_priviledgeTable = this.$archived_priviledge.bootgrid({
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
            url: base_url + "maintenance/priviledge/archived-lists",
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
            | # priviledge undo
            | ---------------------------------
            */
            archived_priviledgeTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                priviledge = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/priviledge/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The priviledge (" +priviledge+ ") with ID "+id+" will be restored from your records.",
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
                                text: "The priviledge (" +priviledge+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.priviledge.reload();
                            });     
                        },
                    });  

                });
            });

        }); 

    },

    //init priviledge
    $.priviledge = new priviledge, $.priviledge.Constructor = priviledge

}(window.jQuery),

//initializing priviledge
function($) {
    "use strict";
    $.priviledge.init();
    $.priviledge.required_fields();
}(window.jQuery);