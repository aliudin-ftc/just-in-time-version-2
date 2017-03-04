!function($) {
    "use strict";

    var brand = function() {
        this.$body = $("body")
        this.$brand = $("#brand-table");
        this.$archived_brand = $("#archived-brand-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var brandTable, archived_brandTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    brand.prototype.required_fields = function($form) {

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
    brand.prototype.validate = function($form, $error) {
                            
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
    brand.prototype.refresh = function($form) {

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
    brand.prototype.swAlert = function($type, $form) {

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
                        $.brand.refresh($form);
                        document.location.href = base_url + 'maintenance/brand/manage';
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # brand table reload
    | ---------------------------------
    */
    brand.prototype.reload = function() {
        this.$brand.bootgrid("reload");   
        this.$archived_brand.bootgrid("reload");
    },

    /*
    | ---------------------------------
    | # brand image file
    | ---------------------------------
    */
    brand.prototype.image_file = function() {

        var url  = base_url + "maintenance/brand/find/"+base_line;

        if($.isNumeric(base_line)){
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = $.parseJSON( data );
                    $(".fileinput").removeClass("fileinput-new").addClass("fileinput-exists");
                    $('.thumbnail').prepend("<img src='"+base_url+"uploads/"+data[0].brand_logo+"' />");
                },
            });  

        } else {
            $(".fileinput").removeClass("fileinput-exists").addClass("fileinput-new");
            $("#brand_logo").val(''); 
        }

    },

    /*
    | ---------------------------------
    | # brand table init
    | ---------------------------------
    */
    brand.prototype.init = function() {   

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
            $.brand.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        /*
        | ---------------------------------
        | # brand save
        | ---------------------------------
        */
        this.$body.on('click', '#save-brand-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#brand-form");
            var $errors = $.brand.validate($form, $error);
            var $action = base_url + "maintenance/brand/";

            if($errors != 0) { 
                $.brand.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The brand's Information will be save to the database.",
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
                                $.brand.refresh($form);                                 
                            },
                            success: function (data) {                                    
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.brand.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # brand edit
        | ---------------------------------
        */
        this.$body.on('click', '#edit-brand-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#brand-form");
            var $errors = $.brand.validate($form, $error);
            var $action = base_url + "maintenance/brand/";

            if($('#brand_logo').val()){
                var inputfile = $('#brand_logo').get(0).files[0].name;    
            }
            else if($('#brand_logo').attr('value') != "") {
                var inputfile = $('#brand_logo').attr('value') + '&old=true';
            } 
            else {
                var inputfile = '';
            }    

            if($errors != 0) { 
                $.brand.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The brand's Information will be save to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        if($('#brand_logo').val()){
                                
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
                                $.brand.refresh($form);                                 
                            },
                            success: function (data) {   

                                //var data = $.parseJSON(data);                                          
                                                                       
                            },
                            complete: function (data) {
                                
                            }
                        });

                        $.brand.swAlert('success', $form);
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # brand table initialized
        | ---------------------------------
        */
        brandTable = this.$brand.bootgrid({
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
            url: base_url + "maintenance/brand/lists",
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
            | # brand delete
            | ---------------------------------
            */
            brandTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                brand = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/brand/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # brand delete
            | ---------------------------------
            */
            brandTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                brand = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/brand/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The brand (" +brand+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The brand (" +brand+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.brand.reload();
                            });     
                        },
                    });  

                });
            });

        }); 
        
        /*
        | ---------------------------------
        | # brand table initialized
        | ---------------------------------
        */
        archived_brandTable = this.$archived_brand.bootgrid({
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
            url: base_url + "maintenance/brand/archived-lists",
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
            | # brand undo
            | ---------------------------------
            */
            archived_brandTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                brand = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "maintenance/brand/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The brand (" +brand+ ") with ID "+id+" will be restored from your records.",
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
                                text: "The brand (" +brand+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.brand.reload();
                            });     
                        },
                    });  

                });
            });

        }); 

    },

    //init brand
    $.brand = new brand, $.brand.Constructor = brand

}(window.jQuery),

//initializing brand
function($) {
    "use strict";
    $.brand.init();
    $.brand.required_fields();
    $.brand.image_file();
}(window.jQuery);