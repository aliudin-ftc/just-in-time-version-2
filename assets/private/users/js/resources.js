!function($) {
    "use strict";

    var resources = function() {
        this.$body = $("body")
        this.$resources = $("#resources-table");
        this.$archived_resources = $("#archived-resources-table");
        this.$address = $("#address-table");
        this.$contact = $("#contact-table");
        this.$outgoing = $("#outgoing-table");
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var resourcesTable, archived_resourcesTable, addressTable, contactTable, outgoingTable;

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    resources.prototype.required_fields = function($form) {

        $.each(this.$body.find(".form-group"), function(){
            
            if($(this).hasClass('required')) {
                $(this).find('label').append('<span class="pull-right c-red">*</span>');            
                $(this).find("input[type='text'], input[type='email'], select, textarea").addClass('required');
            }   

        });

    },    

    resources.prototype.testEmail = function ($email) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test($email);
    }

    /*
    | ---------------------------------
    | # validate form
    | ---------------------------------
    */
    resources.prototype.validate = function($form, $error) {
                            
        $.each($form.find("input[type='text'], input[type='email'], select, textarea"), function(){
               
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
                    } else if($(this).is("input[type='email']")){
                        if(!$.resources.testEmail($(this).val()))
                        {
                            $(this).closest(".form-group").addClass("has-error").find(".help-block").text("this is not a valid email.");
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
    resources.prototype.refresh = function($form) {

        $form.find('select').selectpicker('deselectAll');
        $.each($form.find("input[type='text'], input[type='email'], select, textarea"), function(){
            
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
    resources.prototype.swAlert = function($type, $form) {

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
            }, 2000);
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
                    }
                });                   
            }, 2000);
        }

    },

    /*
    | ---------------------------------
    | # modal line employee refresh
    | ---------------------------------
    */
    resources.prototype.refresh_modal_address = function() {
        var $button = $('#save-address-line-btn');
        var $modals = $('#address-line-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.address-title').text('Add New Address Line');
        $modals.find('.modal-title span.address-line-id-no').text("Employee ID "+$("#resources_id").val());
        $modals.modal('hide');
        $('#province_id, #city_id, #barangay_id').selectpicker('val', 0);
    },

    /*
    | ---------------------------------
    | # modal line contact refresh
    | ---------------------------------
    */
    resources.prototype.refresh_modal_contact = function() {
        var $button = $('#save-contact-line-btn');
        var $modals = $('#contact-line-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.contact-title').text('Add New Contact Line');
        $modals.find('.modal-title span.contact-line-id-no').text("Employee ID "+$("#resources_id").val());
        $modals.modal('hide');
    },

    /*
    | ---------------------------------
    | # modal line outgoing refresh
    | ---------------------------------
    */
    resources.prototype.refresh_modal_outgoing = function() {
        var $button = $('#save-outgoing-line-btn');
        var $modals = $('#outgoing-line-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.contact-title').text('Add New Outgoing Line');
        $modals.find('.modal-title span.contact-line-id-no').text("Employee ID "+$("#resources_id").val());
        $modals.modal('hide');
    },

    /*
    | ---------------------------------
    | # job_request reload selectpicker
    | ---------------------------------
    */
    resources.prototype.reload_city_selectpicker = function (data1, data2) {
        var $province = data1;    
        var $city = $('#'+data2);
        var $region = $('#region');
        $city.find('option').remove();
        $city.selectpicker('refresh');
        $('#city_id, #barangay_id').selectpicker('val', 0);

        $.ajax({
            url: base_url + 'resources/find-city-by-province/' + $province,
            type: "GET",
            success: function (data) {    
                $city.append('<option value="">select city here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $city.append('<option value="'+item.city_id+'">'+item.city_name+'</option>');  
                }); 
                $city.selectpicker('refresh');
                $region.val('NCR');     
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
    resources.prototype.reload_barangay_selectpicker = function (data1, data2) {
        var $city = data1;    
        var $barangay = $('#'+data2);
        $barangay.find('option').remove();
        $barangay.selectpicker('refresh');

        $.ajax({
            url: base_url + 'resources/find-barangay-by-city/' + $city,
            type: "GET",
            success: function (data) {    
                $barangay.append('<option value="">select barangay here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $barangay.append('<option value="'+item.barangay_id+'">'+item.barangay_name+'</option>');  
                }); 
                $barangay.selectpicker('refresh'); 
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
    | # resources table reload
    | ---------------------------------
    */
    resources.prototype.reload = function() {
        this.$resources.bootgrid("reload");   
        this.$archived_resources.bootgrid("reload");
        this.$address.bootgrid("reload");   
        this.$contact.bootgrid("reload");   
        this.$outgoing.bootgrid("reload"); 
    },

    /*
    | ---------------------------------
    | # resources image file
    | ---------------------------------
    */
    resources.prototype.image_file = function() {

        var url  = base_url + "resources/"+ base_category +"/find/" + base_line;

        if($.isNumeric(base_line)){
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = $.parseJSON( data );
                    $(".fileinput").removeClass("fileinput-new").addClass("fileinput-exists");
                    $('.thumbnail').prepend("<img src='"+base_url+"uploads/"+data[0].resources_logo+"' />");
                },
            });  

        } else {
            $(".fileinput").removeClass("fileinput-exists").addClass("fileinput-new");
            $("#resources_logo").val(''); 
        }

    },

    /*
    | ---------------------------------
    | # resources table init
    | ---------------------------------
    */
    resources.prototype.init = function() {   

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
            $.resources.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });

        /*
        | ---------------------------------
        | # when province_id has changed
        | ---------------------------------
        */
        this.$body.on('change', '#province_id', function (e) {
            e.preventDefault();
            $.resources.reload_city_selectpicker($(this).val(), 'city_id');
            $('#city_id, #barangay_id').selectpicker('val', 0);
        });

        /*
        | ---------------------------------
        | # when city_id has changed
        | ---------------------------------
        */
        this.$body.on('change', '#city_id', function (e) {
            e.preventDefault();
            $.resources.reload_barangay_selectpicker($(this).val(), 'barangay_id');
            $('#barangay_id').selectpicker('val', 0);
        });


        /*
        | ---------------------------------
        | # resources save
        | ---------------------------------
        */
        this.$body.on('click', '#save-resources-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#resources-form");
            var $errors = $.resources.validate($form, $error);
            var $action = base_url + "resources/" +base_category+ "/";
            var $res_id = $('#resources_id').val();

            if(base_module_line == 'edit'){
                if($('#resources_logo').val()){
                    var inputfile = $('#resources_logo').get(0).files[0].name;    
                }
                else if($('#resouces_logo').attr('value') != "") {
                    var inputfile = $('#resources_logo').attr('value') + '&old=true';
                } 
                else {
                    var inputfile = '';
                }
            } else {
                if($('#resources_logo').val()){
                    var inputfile = $('#resources_logo').get(0).files[0].name;    
                }
                else {
                    var inputfile = '';
                }  
            }

            if($errors != 0) { 
                $.resources.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The Employee's Information will be save to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        if($("#resources_id").val() != "")
                        {   
                            if($('#resources_logo').val()){
                                
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
                                url: $action + "update/"+ $res_id +"?filename="+inputfile,
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);                                          
                                    $.resources.reload();                                          
                                },
                                complete: function (data) {
                                    $.resources.swAlert('success', $form);
                                }
                            });
                        } 
                        else 
                        {   
                            if($('#resources_logo').val()){
                                
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
                                success: function (data) {   
                                    var data = $.parseJSON(data); 
                                    $("#resources_id").val(data.resources_id);
                                    $('#address-line-button').removeClass('hidden').addClass('zoomInDown animated');
                                    $('#contact-line-button').removeClass('hidden').addClass('zoomInDown animated');
                                    $('#outgoing-line-button').removeClass('hidden').addClass('zoomInDown animated');
                                    $.resources.reload();     
                                    //$.resources.refresh_modal();         
                                },
                                complete: function (data) {
                                    $.resources.swAlert('success', $form);
                                }
                            });
                        }                        
                    }
                });            
            }

        });
    
        /*
        | ---------------------------------
        | # close address line modal
        | ---------------------------------
        */
        this.$body.on('click', '#close-address-line-btn', function (e) {
            e.preventDefault();            
            var $form = $('#address-line-form');
            $.resources.refresh($form);
            $.resources.refresh_modal_address();            
        });

        /*
        | ---------------------------------
        | # add new address line
        | ---------------------------------
        */
        this.$body.on('click','#address-line-button', function (e) {
            e.preventDefault();
            var $res = $('#resources_id').val();
            var $modals = $('#address-line-modal');
            $('.address-line-id-no').html('Employee ID '+$res);
            $.resources.refresh_modal_address();
        });

        /*
        | ---------------------------------
        | # address line save
        | ---------------------------------
        */
        this.$body.on('click', '#save-address-line-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $modals = $(this).closest('.modal');
            var $error = 0;
            var $form = $('#address-line-form');
            var $errors = $.resources.validate($form, $error);            
            var $action = base_url + "resources/" + base_category + "/";
            var $modals_title = $modals.find('.modal-title span.address-title').text();
            var $modals_no = $modals.find('.modal-title span.address-line-id-no').text(); 
            
            if($errors != 0) { 
                $.resources.swAlert('error', $form);
            } else {
                $button.prop('disabled', true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');  
                swal({
                    title: "Are you sure?",
                    text: "The information will be permanently save to your records.",
                    type: "warning",
                    confirmButtonText: "Yes, Save it!",
                    cancelButtonText: "No, Cancel plx!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {   
                        
                        if($modals_title == 'Add New Address Line')
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'save-address?resources_id=' + $("#resources_id").val(),
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.resources.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.resources.reload();
                                        $.resources.refresh_modal_address();
                                        $.resources.refresh($form);
                                    }, 5000);              
                                                                           
                                }
                            }); 
                        } else {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'update-address?address_no=' + $modals_no,
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.resources.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.resources.reload();
                                        $.resources.refresh_modal_address();
                                        $.resources.refresh($form);
                                    }, 5000);              
                                                                           
                                }
                            }); 
                        }
                        
                                                           
                    } else {
                        $button.prop('disabled', false).html("Save changes");
                    }
                });      
            }

        });

        /*
        | ---------------------------------
        | # close contact line modal
        | ---------------------------------
        */
        this.$body.on('click', '#close-contact-line-btn', function (e) {
            e.preventDefault();            
            var $form = $('#contact-line-form');
            $.resources.refresh($form);
            $.resources.refresh_modal_contact();            
        });

        /*
        | ---------------------------------
        | # add new contact line
        | ---------------------------------
        */
        this.$body.on('click','#contact-line-button', function (e) {
            e.preventDefault();
            var $res = $('#resources_id').val();
            var $modals = $('#contact-line-modal');
            $('.contact-line-id-no').html('Employee ID '+$res);
            $.resources.refresh_modal_contact();
        });

        /*
        | ---------------------------------
        | # contact line save
        | ---------------------------------
        */
        this.$body.on('click', '#save-contact-line-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $modals = $(this).closest('.modal');
            var $error = 0;
            var $form = $('#contact-line-form');
            var $errors = $.resources.validate($form, $error);            
            var $action = base_url + "resources/" + base_category + "/";
            var $modals_title = $modals.find('.modal-title span.contact-title').text();
            var $modals_no = $modals.find('.modal-title span.contact-line-id-no').text(); 
            
            if($errors != 0) { 
                $.resources.swAlert('error', $form);
            } else {
                $button.prop('disabled', true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');  
                swal({
                    title: "Are you sure?",
                    text: "The information will be permanently save to your records.",
                    type: "warning",
                    confirmButtonText: "Yes, Save it!",
                    cancelButtonText: "No, Cancel plx!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {   
                        
                        if($modals_title == 'Add New Contact Line')
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'save-contact?resources_id=' + $("#resources_id").val(),
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.resources.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.resources.reload();
                                        $.resources.refresh_modal_contact();
                                        $.resources.refresh($form);
                                    }, 5000);              
                                                                           
                                }
                            }); 
                        } else {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'update-contact?contact_no=' + $modals_no,
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.resources.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.resources.reload();
                                        $.resources.refresh_modal_contact();
                                        $.resources.refresh($form);
                                    }, 5000);              
                                                                           
                                }
                            }); 
                        }
                        
                                                           
                    } else {
                        $button.prop('disabled', false).html("Save changes");
                    }
                });      
            }

        });

        /*
        | ---------------------------------
        | # close outgoing line modal
        | ---------------------------------
        */
        this.$body.on('click', '#close-outgoing-line-btn', function (e) {
            e.preventDefault();            
            var $form = $('#outgoing-line-form');
            $.resources.refresh($form);
            $.resources.refresh_modal_outgoing();            
        });

        /*
        | ---------------------------------
        | # add new outgoing line
        | ---------------------------------
        */
        this.$body.on('click','#outgoing-line-button', function (e) {
            e.preventDefault();
            var $res = $('#resources_id').val();
            var $modals = $('#outgoing-line-modal');
            $('.outgoing-line-id-no').html('Employee ID '+$res);
            $.resources.refresh_modal_outgoing();
        });

        /*
        | ---------------------------------
        | # outgoing line save
        | ---------------------------------
        */
        this.$body.on('click', '#save-outgoing-line-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $modals = $(this).closest('.modal');
            var $error = 0;
            var $form = $('#outgoing-line-form');
            var $errors = $.resources.validate($form, $error);            
            var $action = base_url + "resources/" + base_category + "/";
            var $modals_title = $modals.find('.modal-title span.outgoing-title').text();
            var $modals_no = $modals.find('.modal-title span.outgoing-line-id-no').text(); 
            
            if($errors != 0) { 
                $.resources.swAlert('error', $form);
            } else {
                $button.prop('disabled', true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');  
                swal({
                    title: "Are you sure?",
                    text: "The information will be permanently save to your records.",
                    type: "warning",
                    confirmButtonText: "Yes, Save it!",
                    cancelButtonText: "No, Cancel plx!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {   
                        
                        if($modals_title == 'Add New Outgoing Line')
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'save-outgoing?resources_id=' + $("#resources_id").val(),
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.resources.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.resources.reload();
                                        $.resources.refresh_modal_outgoing();
                                        $.resources.refresh($form);
                                    }, 5000);              
                                                                           
                                }
                            }); 
                        } else {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'update-outgoing?outgoing_no=' + $modals_no,
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.resources.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.resources.reload();
                                        $.resources.refresh_modal_outgoing();
                                        $.resources.refresh($form);
                                    }, 5000);              
                                                                           
                                }
                            }); 
                        }
                        
                                                           
                    } else {
                        $button.prop('disabled', false).html("Save changes");
                    }
                });      
            }

        });

        /*
        | ---------------------------------
        | # resources table initialized
        | ---------------------------------
        */
        resourcesTable = this.$resources.bootgrid({
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
            url: base_url + "resources/" + base_category + "/lists",
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
            | # resources delete
            | ---------------------------------
            */
            resourcesTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                resources = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "resources/" + base_category + "/edit/"+id;

                document.location = url;    
                
            });

            /*
            | ---------------------------------
            | # resources delete
            | ---------------------------------
            */
            resourcesTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                resources = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "resources/" + base_category + "/delete/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The "+ base_category +" (" +resources+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The "+ base_category +" (" +resources+ ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.resources.reload();
                            });     
                        },
                    });  

                });
            });

        }); 
        
        /*
        | ---------------------------------
        | # resources table initialized
        | ---------------------------------
        */
        archived_resourcesTable = this.$archived_resources.bootgrid({
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
            url: base_url + "maintenance/resources/archived-lists",
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
            | # resources undo
            | ---------------------------------
            */
            archived_resourcesTable.find(".command-undo").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                resources = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "resources/" + base_category + "/undo/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The " + base_category + " (" +resources+ ") with ID "+id+" will be restored from your records.",
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
                                text: "The " + base_category + " (" +resources+ ") with ID "+id+" has been successfully restored!",
                                type: "success",
                                },
                                function(){                                     
                                    $.resources.reload();
                            });     
                        },
                    });  

                });
            });

        }); 

        /*
        | ---------------------------------
        | # address table initialized
        | ---------------------------------
        */
        addressTable = this.$address.bootgrid({
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
                console.log(request.resources_id = $('#resources_id').val());
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "resources/address-lists",
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
            | # address edit
            | ---------------------------------
            */
            addressTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    modals = $('#address-line-modal'),
                    bill = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "resources/" + base_category + "/edit-address/" +id;   

                    $.ajax({
                        type: 'POST',
                        url: url,
                        beforeSend: function(){

                        },
                        success: function (data) {   
                            
                            var address_line = $.parseJSON(data);   

                            var _form = $('#address-line-form');

                            modals.modal('show');
                            modals.find('.modal-title span.address-title').text('Edit Address Line ID No.');
                            modals.find('.modal-title span.address-line-id-no').text(id);

                            $.resources.reload_city_selectpicker(address_line[0].province_id, 'city_id');
                            $.resources.reload_barangay_selectpicker(address_line[0].city_id, 'barangay_id');
                            
                            setTimeout(function(){ 
                                $.each(address_line, function (key, value) {      

                                    if (value === undefined || value === null) 
                                    {

                                    } 
                                    else 
                                    {                    
                                        $.each(value, function(key1, value1) {
                                            
                                            var $fields = _form.find('[name=' + key1 + ']');

                                            if($fields.is("select")){ 
                                                $fields.selectpicker('val',value1)
                                            } else {
                                                $fields.val(value1);
                                            }             

                                        }); //each 
                                    } //else
                                    
                                }); //each
                            }, 100);

                        } //success

                    }); //ajax
                
            }); //end edit

            /*
            | ---------------------------------
            | # address delete
            | ---------------------------------
            */
            addressTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                prov = $(this).parents('tr').find('td:nth-child(3)').text(),
                city = $(this).parents('tr').find('td:nth-child(4)').text(),
                    url  = base_url + "resources/" + base_category + "/del-address/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The Address (" +prov+ " " +city+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The Address (" + prov + ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.resources.reload();
                            });     
                        },
                    });  

                });
            }); //end delete

        }); 

        /*
        | ---------------------------------
        | # contact table initialized
        | ---------------------------------
        */
        contactTable = this.$contact.bootgrid({
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
                console.log(request.resources_id = $('#resources_id').val());
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "resources/contact-lists",
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
            | # contact edit
            | ---------------------------------
            */
            contactTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    modals = $('#contact-line-modal'),
                    bill = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "resources/" + base_category + "/edit-contact/" +id;   

                    $.ajax({
                        type: 'POST',
                        url: url,
                        beforeSend: function(){

                        },
                        success: function (data) {   
                            
                            var contact_line = $.parseJSON(data);   

                            var _form = $('#contact-line-form');

                            modals.modal('show');
                            modals.find('.modal-title span.contact-title').text('Edit contact Line ID No.');
                            modals.find('.modal-title span.contact-line-id-no').text(id);

                            $.each(contact_line, function (key, value) {      

                                if (value === undefined || value === null) 
                                {

                                } 
                                else 
                                {                    
                                    $.each(value, function(key1, value1) {
                                        
                                        var $fields = _form.find('[name=' + key1 + ']');

                                        if($fields.is("select")){ 
                                            $fields.selectpicker('val',value1)
                                        } else {
                                            $fields.val(value1);
                                        }             

                                    }); //each 
                                } //else
                                
                            }); 

                        } //success

                    }); //ajax
                
            }); //end edit

            /*
            | ---------------------------------
            | # contact delete
            | ---------------------------------
            */
            contactTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                mobile = $(this).parents('tr').find('td:nth-child(4)').text(),
                    url  = base_url + "resources/" + base_category + "/del-contact/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The contact (mobile: " +mobile+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The contact (mobile: " + mobile + ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.resources.reload();
                            });     
                        },
                    });  

                });
            }); //end delete

        });

        /*
        | ---------------------------------
        | # contact table initialized
        | ---------------------------------
        */
        outgoingTable = this.$outgoing.bootgrid({
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
                console.log(request.resources_id = $('#resources_id').val());
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "resources/outgoing-lists",
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
            | # outgoing edit
            | ---------------------------------
            */
            outgoingTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    modals = $('#outgoing-line-modal'),
                    bill = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "resources/" + base_category + "/edit-outgoing/" +id;   

                    $.ajax({
                        type: 'POST',
                        url: url,
                        beforeSend: function(){

                        },
                        success: function (data) {   
                            
                            var outgoing_line = $.parseJSON(data);   

                            var _form = $('#outgoing-line-form');

                            modals.modal('show');
                            modals.find('.modal-title span.outgoing-title').text('Edit Outgoing Line ID No.');
                            modals.find('.modal-title span.outgoing-line-id-no').text(id);

                            $.each(outgoing_line, function (key, value) {      

                                if (value === undefined || value === null) 
                                {

                                } 
                                else 
                                {                    
                                    $.each(value, function(key1, value1) {
                                        
                                        var $fields = _form.find('[name=' + key1 + ']');

                                        if($fields.is("select")){ 
                                            $fields.selectpicker('val',value1)
                                        } else {
                                            $fields.val(value1);
                                        }             

                                    }); //each 
                                } //else
                                
                            }); 

                        } //success

                    }); //ajax
                
            }); //end edit
            
            /*
            | ---------------------------------
            | # contact delete
            | ---------------------------------
            */
            outgoingTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var  id = $(this).parents('tr').data('row-id'),
                  email = $(this).parents('tr').find('td:nth-child(4)').text(),
                    url = base_url + "resources/" + base_category + "/del-outgoing/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The outgoing (email: " +email+ ") with ID "+id+" will be removed from your records.",
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
                                text: "The outgoing (email: " + email + ") with ID "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.resources.reload();
                            });     
                        },
                    });  

                });
            }); //end delete

        });

    },

    //init resources
    $.resources = new resources, $.resources.Constructor = resources

}(window.jQuery),

//initializing resources
function($) {
    "use strict";
    $.resources.init();
    $.resources.required_fields();
    $.resources.image_file();
}(window.jQuery);