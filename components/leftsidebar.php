<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Menu</li>

            <li>
                <a href="index.php" class="waves-effect">
                    <i class="ri-dashboard-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php if($_SESSION["admin"] == true) { ?>

                <li class="">
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                        <i class="ri-user-line"></i>
                        <span>Players</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li><a href="players.php">View Players</a></li>
                        <li><a href="add-player.php">Add Players</a></li>
                    </ul>
                </li>

            <?php } else { ?>
                <li>
                    <a href="players.php" class=" waves-effect">
                        <i class="ri-user-line"></i>
                        <span>Players</span>
                    </a>
                </li>
            <?php } ?>


            <li>
                <a href="<?= $_SESSION["admin"] == true ? "admincalendar.php" : "calendar.php" ?>" class=" waves-effect">
                    <i class="ri-calendar-2-line"></i>
                    <span>Calendar</span>
                </a>
            </li>

            <?php if($_SESSION["admin"] == true) { ?>

            <li class="">
                <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                    <i class="ri-todo-line"></i>
                    <span>Tasks</span>
                </a>
                <ul class="sub-menu mm-collapse" aria-expanded="false">
                    <li><a href="tasks.php">View Tasks</a></li>
                    <li><a href="add-task.php">Add Tasks</a></li>
                </ul>
            </li>

            <?php } else { ?>
                <li>
                    <a href="tasks.php" class=" waves-effect">
                        <i class="ri-todo-line"></i>
                        <span>Tasks</span>
                    </a>
                </li>
            <?php } ?>

            <li>
                <a href="chat.php" class=" waves-effect">
                    <i class="ri-chat-1-line"></i>
                    <span>Chat</span>
                </a>
            </li>

            <li>
                <a href="settings.php" class=" waves-effect">
                    <i class="ri-settings-2-line"></i>
                    <span>Settings</span>
                </a>
            </li>

        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->