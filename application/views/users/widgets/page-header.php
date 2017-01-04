<h2 class="header-title text-capitalize">
    <?php echo is_numeric($template['page']['method']) ? $template['page']['category'] : $template['page']['method']; ?> <?php echo $template['sub_title']; ?>

    <?php if ($template['title'] == 'Maintenance' && ($template['page']['method'] == "manage" || $template['page']['method'] == "archived")): ?>
	    <ul class="pull-right h-menu job-menu">
		    <li class="dropdown h-apps">
		        <a data-toggle="dropdown" href="" class="theme-color">
		            <i class="hm-icon zmdi zmdi-apps"></i>
		        </a>
		        <ul class="dropdown-menu pull-right">
		            <li>
		                <a href="<?php echo base_url('users/maintenance/'.$template["page"]["category"].'/manage'); ?>">
		                    <i class="theme-bg-1 bg zmdi zmdi-settings"></i>
		                    <small>Manage</small>
		                </a>
		            </li>
		            <li> 
		                <a href="<?php echo base_url('users/maintenance/'.$template["page"]["category"].'/archived'); ?>">
		                    <i class="theme-bg-2 bg zmdi zmdi-archive"></i>
		                    <small>Archived</small>
		                </a>
		            </li>
		        </ul>
		    </li>
		</ul>
	<?php endif; ?>
    <small>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut fringilla tellus. Integer sit amet neque sed diam sollicitudin varius cursus sit amet neque.
    </small>                                
</h2>