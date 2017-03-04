<h2 class="header-title text-capitalize">
	<?php if($template['title'] == 'Maintenance' && (($template['page']['modules'] == "manage" || !isset($template['page']['modules'])) || ($template['page']['modules'] == "archived" || !isset($template['page']['modules'])))): ?>
	    <ul class="pull-right h-menu job-menu">
		    <li class="dropdown h-apps">
		        <a data-toggle="dropdown" href="" class="theme-color">
		            <i class="hm-icon zmdi zmdi-apps"></i>
		        </a>
		        <ul class="dropdown-menu pull-right">
		            <li>
		                <a href="<?php echo base_url('maintenance/'.str_replace("_","-",$template["page"]["category"]).'/manage'); ?>">
		                    <i class="theme-bg-1 bg zmdi zmdi-settings"></i>
		                    <small>Manage</small>
		                </a>
		            </li>
		            <li> 
		                <a href="<?php echo base_url('maintenance/'.str_replace("_","-",$template["page"]["category"]).'/archived'); ?>">
		                    <i class="theme-bg-2 bg zmdi zmdi-archive"></i>
		                    <small>Archived</small>
		                </a>
		            </li>
		        </ul>
		    </li>
		</ul>
	<?php elseif( ($template['page']['modules'] == 'job-request' && $template['page']['method'] != 'add') && ($template['page']['modules'] == 'job-request' && $template['page']['method'] != 'edit') && ($template['page']['modules'] == 'job-request' && $template['page']['method'] != 'attach') ): ?>
		<ul class="pull-right h-menu job-menu">
		    <li class="dropdown h-apps">
		        <a data-toggle="dropdown" href="" class="theme-color">
		            <i class="hm-icon zmdi zmdi-apps"></i>
		        </a>
		        <ul class="dropdown-menu pull-right">
		            <li>
		                <a href="<?php echo base_url('job-order/manage/job-request/'.$template["page"]["views"].''); ?>">
		                    <i class="theme-bg-1 bg zmdi zmdi-settings"></i>
		                    <small>Manage</small>
		                </a>
		            </li>
		            <li> 
		                <a href="<?php echo base_url('job-order/manage/job-request/'.$template["page"]["views"].'/archived'); ?>">
		                    <i class="theme-bg-2 bg zmdi zmdi-archive"></i>
		                    <small>Archived</small>
		                </a>
		            </li>
		        </ul>
		    </li>
		</ul>
	<?php elseif( ($template['page']['modules'] == 'job-element' && $template['page']['method'] != 'add') && ($template['page']['modules'] == 'job-element' && $template['page']['method'] != 'edit') ): ?>
		<ul class="pull-right h-menu job-menu">
		    <li class="dropdown h-apps">
		        <a data-toggle="dropdown" href="" class="theme-color">
		            <i class="hm-icon zmdi zmdi-apps"></i>
		        </a>
		        <ul class="dropdown-menu pull-right">
		            <li>
		                <a href="<?php echo base_url('job-order/manage/job-element/'.$template["page"]["views"].''); ?>">
		                    <i class="theme-bg-1 bg zmdi zmdi-settings"></i>
		                    <small>Manage</small>
		                </a>
		            </li>
		            <li> 
		                <a href="<?php echo base_url('job-order/manage/job-element/'.$template["page"]["views"].'/archived'); ?>">
		                    <i class="theme-bg-2 bg zmdi zmdi-archive"></i>
		                    <small>Archived</small>
		                </a>
		            </li>
		        </ul>
		    </li>
		</ul>
	<?php elseif ($template['title'] == 'Job Order'): ?>
		<?php $job_no = $this->uri->segment($this->uri->total_segments()); ?>
		<ul id="request-menu" class="pull-right h-menu job-menu <?php echo $template["method"]=='Edit' ? '' : 'hidden'; ?>">
	        <li class="dropdown h-apps">
	            <a data-toggle="dropdown" href="" class="theme-color">
	                <i class="hm-icon zmdi zmdi-apps"></i>
	            </a>
	            <ul class="dropdown-menu pull-right">
	                <li>
	                    <a href="<?php echo base_url('job-order/manage/job-request/'.$job_no.''); ?>">
	                        <i class="palette-Green-400 bg zmdi zmdi-file-text"></i>
	                        <small>Job <br/>Request</small>
	                    </a>
	                </li>
	                <li> 
	                    <a href="<?php echo base_url('job-order/manage/job-element/'.$job_no.''); ?>">
	                        <i class="palette-Purple-300 bg zmdi zmdi-view-headline"></i>
	                        <small>Job <br/>Element</small>
	                    </a>
	                </li>
	                <li>
	                    <a href="<?php echo base_url('job-order/manage/delivery-packing/'.$job_no.''); ?>">
	                        <i class="palette-Light-Blue bg zmdi zmdi-email"></i>
	                        <small>Delivery &amp;<br/>Packing</small>
	                    </a>
	                </li>
	                <li>                                                                                               
	                    <a href="<?php echo base_url('job-order/manage/job-qoutation/'.$job_no.''); ?>">
	                        <i class="palette-Red-400 bg zmdi zmdi-search"></i>
	                        <small>Job <br/>Qoutation</small>
	                    </a>
	                </li>
	            </ul>
	        </li>
	    </ul>
	<?php endif; ?>

    <?php 
    	echo is_numeric($template['page']['method']) ? $template['page']['method'] : $template['method'].' '; 
    	echo ucfirst(str_replace('-',' ',$template['sub_title'] ? $template['sub_title'] : $template['title'])); 	    
    ?>

    <small>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut fringilla tellus. Integer sit amet neque sed diam sollicitudin varius cursus sit amet neque.
    </small>                                
</h2>