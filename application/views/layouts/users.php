<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>J2V2 | <?= ucwords(str_replace('-',' ',$template['title'])) ?> <?= $template['sub_title'] ? ' - ' . ucwords(str_replace('-',' ',$template['sub_title'])) : '' ?>  <?= $template['method'] ? ' ('.ucwords(str_replace('-',' ',$template['method'])).')' : ''  ?></title>
        <!-- Vendor CSS -->
        <link href="<?php echo base_url('assets/public/vendors/bower_components/animate.css/animate.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/google-material-color/dist/palette.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/farbtastic/farbtastic.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/summernote/dist/summernote.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/sweetalert/dist/sweetalert.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/vendors/bower_components/dropzone/dropzone.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/public/vendors/bootgrid/jquery.bootgrid.min.css'); ?>" rel="stylesheet">
        <!-- CSS -->
        <link href="<?php echo base_url('assets/public/css/app.min.1.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/css/app.min.2.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/public/css/style.css'); ?>" rel="stylesheet">

        <script type="text/javascript">
            var base_url = '<?= base_url() ?>';
            var controller = '<?= !empty($controller) ? $controller : '' ?>';
            var base_line = '<?= !empty($this->uri->segment($this->uri->total_segments())) ? $this->uri->segment($this->uri->total_segments()) : '' ?>';
            var base_module = '<?= !empty($template['page']['method']) ? $template['page']['method'] : '' ?>';
            var base_category = '<?= !empty($template['page']['category']) ? $template['page']['category'] : '' ?>';
            var base_module_line = '<?= !empty($this->uri->segment($this->uri->total_segments())) ? $this->uri->segment($this->uri->total_segments() - 1) : '' ?>';
        </script>
    </head>

    <body data-ma-header="teal">

        <!-- Header -->
        <?php $template['partials']['header'] ? $this->load->view($template['partials']['header']) : ''; ?>
        <!-- /Header -->

        <section id="main">
            <?php $template['partials']['sidebar1'] ? $this->load->view($template['partials']['sidebar1']) : ''; ?>
            <?php $template['partials']['sidebar2'] ? $this->load->view($template['partials']['sidebar2']) : ''; ?>

            <?php $this->load->view($template['body']); ?>

            <!-- Footer -->
            <?php $template['partials']['footer'] ? $this->load->view($template['partials']['footer']) : ''; ?>
            <!-- Footer -->
        </section>

        <!-- Page Loader -->
        <div class="page-loader palette-Teal bg">
            <div class="preloader pl-xl pls-white">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20"/>
                </svg>
            </div>
        </div>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>   
        <![endif]-->
    
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url('assets/public/vendors/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>        
        <script src="<?php echo base_url('assets/public/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/Waves/dist/waves.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bootstrap-growl/bootstrap-growl.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/moment/min/moment.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/es6-promise/dist/es6-promise.auto.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/bower_components/sweetalert/dist/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/summernote/dist/summernote-updated.min.js'); ?>"></script>        
        <script src="<?php echo base_url('assets/public/vendors/bower_components/dropzone/dropzone.min.js'); ?>"></script> 
        <script src="<?php echo base_url('assets/public/vendors/bower_components/easing/jquery.easing.1.3.min.js'); ?>"></script>    
        <script src="<?php echo base_url('assets/public/vendors/fileinput/fileinput.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/input-mask/input-mask.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/vendors/farbtastic/farbtastic.min.js'); ?>"></script>        
        <script src="<?php echo base_url('assets/public/vendors/bower_components/autosize/dist/autosize.min.js'); ?>"></script> 
        <script src="<?php echo base_url('assets/public/vendors/bootgrid/jquery.bootgrid.updated.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/js/functions.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/js/actions.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/js/page.js'); ?>"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="<?php echo base_url('assets/public/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js'); ?>"></script>
        <![endif]-->                

        <!-- append js -->
        <?php 
            if(isset($template['metadata']))
            {
                foreach ($template['metadata'] as $value) {
                    echo $value."\n\t\t";
                }
                echo "\n";
            }      
        ?>
    </body>
</html>