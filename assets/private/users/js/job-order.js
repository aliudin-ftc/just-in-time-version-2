!function($) {
    "use strict";

    var job_order = function() {
        this.$body = $("body")
        this.$job_order = $("#job-order-table");
        this.$archived_job_order = $("#archived-job-order-table");
        this.$job_order_bill = $("#job-order-bill-table");
        this.$job_no = $("#job_order_no").val();
        this.$customer_id = $("#customer_id").val();
        this.$business_unit = $("#business_unit_id").val();
    };

    /*
    | ---------------------------------
    | # global variables
    | ---------------------------------
    */
    var job_orderTable, job_order_billTable, archived_job_orderTable, job_number = 'none';

    /*
    | ---------------------------------
    | # required fields
    | ---------------------------------
    */
    job_order.prototype.required_fields = function($form) {

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
    job_order.prototype.validate = function($form, $error) {
                            
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

    job_order.prototype.refresh_modal = function() {
        var $button = $('#save-billing-line-btn');
        var $modals = $('#billing-line-modal');
        $button.prop('disabled', false).html("Save changes");
        $modals.find('.modal-title span.billing-title').text('Add New Billing Line');
        $modals.find('.modal-title span.billing-line-job-no').text($("#job_order_no").val());
        $modals.modal('hide');
    },

    /*
    | ---------------------------------
    | # refresh form
    | ---------------------------------
    */
    job_order.prototype.refresh = function($form) {

        
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
    job_order.prototype.swAlert = function($type, $form) {

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
                        $.job_order.refresh($form);
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
                $.job_order.reload();  
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
    | # job_order table reload
    | ---------------------------------
    */
    job_order.prototype.reload = function() {
        this.$job_order.bootgrid("reload");   
        this.$archived_job_order.bootgrid("reload");    
        this.$job_order_bill.bootgrid("reload");    
    },

    /*
    | ---------------------------------
    | # job_order image file
    | ---------------------------------
    */
    job_order.prototype.image_file = function() {

        var url  = base_url + "maintenance/job_order/find/"+base_line;

        if($.isNumeric(base_line)){
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = $.parseJSON( data );
                    $(".fileinput").removeClass("fileinput-new").addClass("fileinput-exists");
                    $('.thumbnail').prepend("<img src='"+base_url+"uploads/"+data[0].job_order_logo+"' />");
                },
            });  

        } else {
            $(".fileinput").removeClass("fileinput-exists").addClass("fileinput-new");
            $("#job_order_logo").val(''); 
        }

    },

    job_order.prototype.reload_contact_person_selectpicker = function (data1, data2) {
        var $customer = data1;    
        var $brand = $('#'+data2);
        $brand.find('option').remove();
        $brand.selectpicker('refresh');

        $.ajax({
            url: base_url + 'job-order/find-contact-person-by-customer/' + $customer,
            type: "GET",
            success: function (data) {    
                $brand.append('<option value="">select contact person here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $brand.append('<option value="'+item.contact_person_id+'">'+item.contact_person_firstname+' '+ item.contact_person_middlename +' '+ item.contact_person_lastname +'</option>');  
                }); 
                $brand.selectpicker('refresh');     
            },
            error: function( jqXhr ) {
                if( jqXhr.status == 400 ) { 
                    var json = $.parseJSON( jqXhr.responseText );
                }
            }
        })
    },

    job_order.prototype.reload_brand_selectpicker = function (data1, data2) {
        var $customer = data1;    
        var $brand = $('#'+data2);
        $brand.find('option').remove();
        $brand.selectpicker('refresh');

        $.ajax({
            url: base_url + 'job-order/find-brand-by-customer/' + $customer,
            type: "GET",
            success: function (data) {    
                $brand.append('<option value="">select brand here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $brand.append('<option value="'+item.brand_id+'">'+item.brand_name+'</option>');  
                }); 
                $brand.selectpicker('refresh');     
            },
            error: function( jqXhr ) {
                if( jqXhr.status == 400 ) { 
                    var json = $.parseJSON( jqXhr.responseText );
                }
            }
        })
    },

    job_order.prototype.reload_account_selectpicker = function (data1, data2) {
        var $customer = data1;    
        var $account = $('#'+data2);
        $account.find('option').remove();
        $account.selectpicker('refresh');

        $.ajax({
            url: base_url + 'job-order/find-account-by-customer/' + $customer,
            type: "GET",
            success: function (data) {    
                $account.append('<option value="">select account here</option>');
                $.each(JSON.parse(data), function(i, item) {
                    $account.append('<option value="'+item.account_id+'">'+item.account_name+'</option>');  
                }); 
                $account.selectpicker('refresh');     
            },
            error: function( jqXhr ) {
                if( jqXhr.status == 400 ) { 
                    var json = $.parseJSON( jqXhr.responseText );
                }
            }
        })
    },

    job_order.prototype.reload_branch_selectpicker = function (data1, data2) {
        var $account = data1;    
        var $branch = $('#'+data2);
        $branch.find('option').remove();
        $branch.selectpicker('refresh');

        $.ajax({
            url: base_url + 'job-order/find-branch-by-account/' + $account,
            type: "GET",
            success: function (data) {  
                $branch.append('<option value="">select branch here</option>');                
                $.each(JSON.parse(data), function(i, item) {
                    $branch.append('<option value="'+item.branch_id+'">'+item.branch_name+'</option>');  
                });
                $branch.selectpicker('refresh');
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
    | # job_order table init
    | ---------------------------------
    */
    job_order.prototype.init = function() {   
        
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
            $.job_order.refresh($form);
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
        });        

        this.$body.on('change', '#customer_id', function (e) {
            e.preventDefault();
            var $customer = $(this).val();
            var $action = base_url + "job-order/find-by-customer/" + $customer;

            $.ajax({
                url: $action,
                beforeSend: function(){

                },
                success: function (data) {   

                    var data = $.parseJSON(data);    

                    $('#business_unit_id').selectpicker("val", data.business_unit);
                    $('#resources_id').selectpicker("val", data.account_executive); 
                    $('#contact_person_firstname').val(data.contact_person);

                    $.job_order.reload_contact_person_selectpicker($customer, 'contact_person_id');
                    $.job_order.reload_brand_selectpicker($customer, 'brand_id');
                    $.job_order.reload_account_selectpicker($customer, 'account_id');
                                                           
                },
                complete: function (data) {
                    
                }
            });

        });

        this.$body.on('change', '#account_id', function (e) {
            e.preventDefault();
            var $account = $(this).val();
            $.job_order.reload_branch_selectpicker($account, 'branch_id'); 
        });


        this.$body.on('change', 'input[name="free_job_order"]', function (e) {
            e.preventDefault();
            var job_reason = $('#job_order_free_reasons').val('');
            var modal = $('#free-job-order-modal');
            var pop = $('#free-job-order-popover');

            if($(this).val() == "Yes")
            {
                modal.modal('show');
            } else {
                pop.attr('data-content', '');
            }
        });
        
        this.$body.on('click','#save-free-job-order-btn', function (e) {
            e.preventDefault();
            var job_reason = $('#job_order_free_reasons').val();
            var modal = $('#free-job-order-modal');
            var pop = $('#free-job-order-popover');

            pop.attr('data-content', job_reason);
            modal.modal('hide');
        });

        this.$body.on('click','#job-order-billing-line-button', function (e) {
            e.preventDefault();
            var button = $(this);
            var $error = 0;
            var $form = $('#job-order-form');
            var $errors = $.job_order.validate($form, $error);
            var $action = base_url + "job-order/manage/";
            var $job_no = $('#job_order_no').val();
            var $modals = $('#billing-line-modal');

            if($errors != 0) { 
                $.job_order.swAlert('error', $form);
            } else {
                if($job_no == "")
                {
                    $.ajax({
                        type: $form.attr("method"),
                        url: $action + 'save?business_unit_id=' + $("#business_unit_id").val(),
                        data: $form.serialize(),
                        beforeSend: function(){
                            button.prop('disabled', true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');                       
                        },
                        success: function (data) {   
                            button.prop('disabled', false).html('Add New Billing Line');
                            var data = $.parseJSON(data);  
                            $('#job_order_no').val(data.job_no);
                            $('.billing-line-job-no').html(data.job_no);
                            $modals.modal('show');                 
                        },
                        complete: function (data) {
                            
                        }
                    });                    
                } else {
                    $modals.modal('show');
                }
            }   
            
        });

        this.$body.on('click', '#close-billing-line-btn', function (e) {
            e.preventDefault();            
            var $form = $('#billing-line-form');
            $.job_order.refresh($form);
            $.job_order.refresh_modal();            
        });

        /*
        | ---------------------------------
        | # job_order billing line save
        | ---------------------------------
        */
        this.$body.on('click', '#save-billing-line-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $modals = $(this).closest('.modal');
            var $error = 0;
            var $form = $('#billing-line-form');
            var $errors = $.job_order.validate($form, $error);            
            var $action = base_url + "job-order/manage/";
            var $modals_title = $modals.find('.modal-title span.billing-title').text();
            var $modals_no = $modals.find('.modal-title span.billing-line-job-no').text(); 
            
            if($errors != 0) { 
                $.job_order.swAlert('error', $form);
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
                        
                        if($modals_title == 'Add New Billing Line')
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'save-bill?job_order_no=' + $("#job_order_no").val(),
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.job_order.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.job_order.reload();
                                        $.job_order.refresh_modal();
                                        $.job_order.refresh($form);
                                    }, 5000);              
                                                                           
                                }
                            }); 
                        } else {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'update-bill?bill_no=' + $modals_no,
                                data: $form.serialize(),
                                success: function (data) {   
                                    var data = $.parseJSON(data);

                                    $.job_order.swAlert('timer', $form); 

                                    setTimeout(function(){ 
                                        $.job_order.reload();
                                        $.job_order.refresh_modal();
                                        $.job_order.refresh($form);
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
        | # job_order save
        | ---------------------------------
        */
        this.$body.on('click', '#save-job-order-btn', function (e) {
            e.preventDefault();
            var $error = 0;
            var $form = $("#job-order-form");
            var $errors = $.job_order.validate($form, $error);
            var $action = base_url + "job-order/manage/";

            if($errors != 0) { 
                $.job_order.swAlert('error', $form);
            } else {
                swal({
                    title: "Do you like to save it now?",
                    text: "The Job Order's Information will be save to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {    

                        if($("#job_order_no").val() != "")
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'update?job_order_no=' + $("#job_order_no").val() + '&job_order_free_reasons=' + $('#job_order_free_reasons').val(),
                                data: $form.serialize(),
                                beforeSend: function(){
                                                                   
                                },
                                success: function (data) {   
                                    var data = $.parseJSON(data);   
                                    $.job_order.reload();                                       
                                },
                                complete: function (data) {
                                    
                                }
                            });

                            $.job_order.swAlert('successful', $form);
                        } 
                        else 
                        {
                            $.ajax({
                                type: $form.attr("method"),
                                url: $action + 'save?business_unit_id=' + $("#business_unit_id").val() + '&job_order_free_reasons=' + $('#job_order_free_reasons').val(),
                                data: $form.serialize(),
                                beforeSend: function(){
                                                                   
                                },
                                success: function (data) {   
                                    var data = $.parseJSON(data);                                          
                                    $('#job_order_no').val(data.job_no);  

                                    $.ajax({
                                        type: "GET",
                                        url: base_url + 'job-order/manage/initial?job_bill=' + data.job_bill + '&job_no=' + data.job_no + '&job_qty=' + data.job_qty + '&job_uom=' + data.job_uom + '&job_dc=0',
                                        beforeSend: function(){
                                                                           
                                        },
                                        success: function (data) {   
                                            var data = $.parseJSON(data);
                                            $('#job-order-billing-line-button').removeClass('hidden').addClass('zoomInDown animated');
                                            $('#request-menu').removeClass('hidden').addClass('zoomInDown animated');  
                                            $.job_order.reload();     
                                            $.job_order.refresh_modal();                                              
                                        },
                                        complete: function (data) {
                                            
                                        }
                                    });        

                                },
                                complete: function (data) {
                                    
                                }
                            });

                            $.job_order.swAlert('successful', $form);
                        }
                        
                      
                    }
                });            
            }

        });

        /*
        | ---------------------------------
        | # job_order bill table initialized
        | ---------------------------------
        */
        job_order_billTable = this.$job_order_bill.bootgrid({
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
                console.log(request.job_number = $("#job_order_no").val());
                return request;
            },
            responseHandler: function (response)
            {
                console.log(response);
                return response;
            },
            url: base_url + "job-order/manage/bills/",
            keepSelection: false,
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
            | # job_order bill edit
            | ---------------------------------
            */
            job_order_billTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                    modals = $('#billing-line-modal'),
                    bill = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "job-order/manage/edit-bill/"+id;   

                    $.ajax({
                        type: 'POST',
                        url: url,
                        beforeSend: function(){
                           
                        },
                        success: function (data) {   
                            
                            var billing_line = $.parseJSON(data);                 
                            var _form = $('#billing-line-form');

                            modals.modal('show');
                            modals.find('.modal-title span.billing-title').text('Edit Billing Line Bill No.');
                            modals.find('.modal-title span.billing-line-job-no').text(id);

                            $.each(billing_line, function (key, value) {                           
                                
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

                        } //success

                    }); //ajax
                
            }); //end edit

            /*
            | ---------------------------------
            | # job_order bill delete
            | ---------------------------------
            */
            job_order_billTable.find(".command-delete").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                bill = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "job-order/manage/del-bill/"+id;

                swal({
                    title: "Are you sure?",
                    text:  "The Bill from (" +bill+ ") with Bill No. "+id+" will be removed from your records.",
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
                                text: "The Bill from (" +bill+ ") with Bill No. "+id+" has been successfully deleted!",
                                type: "success",
                                },
                                function(){                                     
                                    $.job_order.reload();
                            });     
                        },
                    });  

                });
            });

        });

        /*
        | ---------------------------------
        | # job_order table initialized
        | ---------------------------------
        */
        job_orderTable = this.$job_order.bootgrid({
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
                    return  "<button title=\"edit this\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> ";
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
            url: base_url + "job-order/manage/lists",
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
            | # job_order edit
            | ---------------------------------
            */
            job_orderTable.find(".command-edit").on("click", function (e) {
                e.preventDefault();

                var id   = $(this).parents('tr').data('row-id'),
                job_order = $(this).parents('tr').find('td:nth-child(3)').text(),
                    url  = base_url + "job-order/manage/edit/"+id;

                document.location = url;    
                
            });

        }); 

    },

    //init job_order
    $.job_order = new job_order, $.job_order.Constructor = job_order

}(window.jQuery),

//initializing job_order
function($) {
    "use strict";
    $.job_order.init();
    $.job_order.required_fields();
    $.job_order.image_file();
}(window.jQuery);