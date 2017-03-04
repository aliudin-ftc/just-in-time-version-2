<h2 class="header-breadcrumb">
    <span class="pull-right hidden-md">
        <div title="click to toggle menu" class="toggle-switch" data-ts-color="pink">
            <input id="toggle-switch" type="checkbox" hidden="hidden">
            <label for="toggle-switch" class="ts-helper"></label>
        </div>
    </span>
    <ol class="breadcrumb">
            <li>
                <a href="#">
                    <?php echo str_replace('_',' ',$template['page']['parent']); ?>
                </a>
            </li>

        <?php if( isset($template['page']['category']) && !isset($template['page']['modules'])): ?>
            <li class="active">
                <?php echo str_replace('_',' ',($template['page']['category']=='index') ? 'manage' : $template['page']['category'] ); ?> 
            </li>
        <?php elseif(isset($template['page']['category'])): ?>
            <li>
                <a href="#">
                    <?php echo str_replace('_',' ',$template['page']['category']); ?> 
                </a>
            </li>
        <?php endif; ?>


        <?php if( isset($template['page']['modules']) && !isset($template['page']['method']) ):?>
            <li class="active">
                <?php echo str_replace('-',' ',$template['page']['modules']); ?>
            </li>
        <?php elseif(isset($template['page']['modules'])): ?>
            <li>
                <a href="#">
                    <?php echo str_replace('-',' ',$template['page']['modules']); ?> 
                </a>
            </li>
        <?php endif; ?>

        <?php if(isset($template['page']['views'])):?>
            <?php if(is_numeric(substr($template['page']['views'], 0, 3)) && $template['page']['method'] != null) : ?>
                <li class="active">
                    <?php echo str_replace('-',' ',$template['page']['method']); ?>
                </li>
            <?php else: ?>

            <?php endif; ?>

        <?php endif; ?>
    </ol>
</h2>