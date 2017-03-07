!function($) {
    "use strict";

    var bill_of_materials_category = function() {
        this.$body = $("body")
        this.$bill_of_materials_category = $("#bill-of-materials-category-table");
        this.$archived_bill_of_materials_category = $("#archived-bill-of-materials-category-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var bill_of_materials_categoryTable, archived_bill_of_materials_categoryTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    bill_of_materials_category.prototype.required_fields = function($form) {

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
    bill_of_materials_category.prototype.validate = function($form, $error) {
                            
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
    bill_of_materials_category.prototype.refresh = function($form) {

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
    bill_of_materials_category.prototype.swAlert = function($type, $form) {

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
                        $.bill_of_materials_category.refresh($form);
                        document.location.href = base_url + 'maintenance/bill_of_materials_category/manage';
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # bill_of_materials_category table reload
    | ---------------------------------
    */
    bill_of_materials_category.prototype.reload = function() {
        this.$bill_of_materials_category.bootgrid("reload");   
        this.$archived_bill_of_materials_category.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # bill_of_materials_category image file
    | ---------------------------------
    */
    bill_of_materials_category.prototype.image_file = function() {

        var url  = base_url + "maintenance/bill_of_materials_category/find/"+base_line;

        if($.isNumeric(base_line)){
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = $.parseJSON( data );
                    $(".fileinput").removeClass("fileinput-new").addClass("fileinput-exists");
                    $('.thumbnail').prepend("<img src='"+base_url+"uploads/"+data[0].bill_of_materials_category_logo+"' />");
                },
            });  

        } else {
            $(".fileinput").removeClass("fileinput-exists").addClass("fileinput-new");
            $("#bill_of_materials_category_logo").val(''); 
        }

    },

    /*
    | ---------------------------------
    | # bill_of_materials_category table init
    | ---------------------------------
    */
    bill_of_materials_category.prototype.init = function() {   

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
            $.bill_of_materials_category.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        /*
        | ---------------------------------
        | # bill_of_materials_category save
        | ---------------------------------
        */
        this.$body.on('click', '#save-bill-of-materials-category-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#bill-of-materials-category-form");
            var $errors = $.bill_of_materials_category.validate($form, $error);
            var $action = base_url + "maintenance/bill_of_materials_category/";

            if($errors != 0) { 
                $.bill_of_materials_category.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The bill_of_materials_category's Information will be save to the database.",
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
                                $.bill_of_materials_category.refresh($form);                                 
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.bill_of_materials_category.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # bill_of_materials_category edit
        | ---------------------------------
        */
        this.$body.on('click', '#edit-bill-of-materials-category-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#bill-of-materials-category-form");
            var $errors = $.bill_of_materials_category.validate($form, $error);
            var $action = base_url + "maintenance/bill_of_materials_category/";

            if($errors != 0) { 
                $.bill_of_materials_category.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The bill_of_materials_category's Information will be save to the database.",
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
                                $.bill_of_materials_category.refresh($form);                                 
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.bill_of_materials_category.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # bill_of_materials_category table initialized
        | ---------------------------------
        */
        bill_of_materials_categoryTable = this.$bill_of_materials_category.bootgrid({
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
            url: base_url + "maintenance/bill_of_materials_category/lists",
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
            | # bill_of_materials_category delete
            | ---------------------------------
            */
            bill_of_materials_categoryTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                bill_of_materials_category = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/bill_of_materials_category/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # bill_of_materials_category delete
            | ---------------------------------
            */
            bill_of_materials_categoryTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                bill_of_materials_category = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/bill_of_materials_category/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The bill_of_materials_category (" +bill_of_materials_category+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The bill_of_materials_category (" +bill_of_materials_category+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.bill_of_materials_category.reload();
                            });     
                        },
                    });  

                });
            });

        }); 
        
        /*
        | ---------------------------------
        | # bill_of_materials_category table initialized
        | ---------------------------------
        */
        archived_bill_of_materials_categoryTable = this.$archived_bill_of_materials_category.bootgrid({
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
            url: base_url + "maintenance/bill_of_materials_category/archived-lists",
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
            | # bill_of_materials_category undo
            | ---------------------------------
            */
            archived_bill_of_materials_categoryTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                bill_of_materials_category = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/bill_of_materials_category/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The bill_of_materials_category (" +bill_of_materials_category+ ") with ID "+id+" will be restored from your records.",
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
                                text: "The bill_of_materials_category (" +bill_of_materials_category+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.bill_of_materials_category.reload();
                            });     
                        },
                    });  

                });
            });

        }); 

    },

    //init bill_of_materials_category
    $.bill_of_materials_category = new bill_of_materials_category, $.bill_of_materials_category.Constructor = bill_of_materials_category

}(window.jQuery),

//initializing bill_of_materials_category
function($) {
    "use strict";
    $.bill_of_materials_category.init();
    $.bill_of_materials_category.required_fields();
    $.bill_of_materials_category.image_file();
}(window.jQuery);