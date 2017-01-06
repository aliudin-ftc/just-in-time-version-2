<aside id="s-main-menu" class="sidebar">
    <div class="smm-header">
        <i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
    </div>

    <ul class="smm-alerts">
        <li data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
            <i class="zmdi zmdi-email"></i>
        </li>
        <li data-user-alert="sua-notifications" data-ma-action="sidebar-open" data-ma-target="user-alerts">
            <i class="zmdi zmdi-notifications"></i>
        </li>
        <li data-user-alert="sua-tasks" data-ma-action="sidebar-open" data-ma-target="user-alerts">
            <i class="zmdi zmdi-view-list-alt"></i>
        </li>
    </ul>

    <ul class="main-menu">
        <?php echo $menu; ?>
    </ul>
</aside>