<h2 class="header-breadcrumb">
    <span class="pull-right hidden-md">
        <div title="click to toggle menu" class="toggle-switch" data-ts-color="pink">
            <input id="toggle-switch" type="checkbox" hidden="hidden">
            <label for="toggle-switch" class="ts-helper"></label>
        </div>
    </span>
    <ol class="breadcrumb">
        <li><a href="#"><?php echo $template['title']; ?></a></li>
        <li><a href="<?php echo base_url().$template['page']['category']; ?>"><?php echo $template['sub_title']; ?></a></li>
        <li class="active"><?php echo is_numeric($template['page']['method']) ? $template['page']['category'] : $template['page']['method']; ?></li>
    </ol>
</h2>