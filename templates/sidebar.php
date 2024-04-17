
<?php
require ($_SERVER['DOCUMENT_ROOT'] . '/models/Menu.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/models/Sub_menu.php');

$menu       = new Menu();
$sub_menu   = new Sub_menu();

$resMenu = $menu->getWhere('', 'sort ASC');
$menu_list = [];
foreach($resMenu AS $row) {
    $resSubMenu = $sub_menu->getWhere(" AND menu_id = " . $row['id'], "name ASC");
    $menu_list[] = [
        'id'    => $row['id'],
        'name'  => $row['name'],
        'url'   => $row['url'],
        'icon'  => $row['icon'],
        'active_keyword'  => $row['active_keyword'],
        'sub_menu' => $resSubMenu
    ];
}
?>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
    <?php foreach($menu_list AS $row): 
            $checkmenu = $helpers->checkactivemenu($uri, $row['active_keyword']);
            $active = ($checkmenu) ? 'actived' : '';
            $areaexpanded = ($checkmenu) ? 'true' : 'false';
            $navcontentshow = ($checkmenu) ? 'show' : '';

            $baseUrl = BASE_URL;
            if($row['active_keyword'] != 'home') {
                $baseUrl = BASE_URL . $row['url'];
            }

            if($row['active_keyword'] == 'home' && $uri == '/') {
                $active = 'actived';
            }
        ?>
        <?php if(empty($row['sub_menu'])): ?>
        <li class="nav-item">
            <a class="nav-link " href="<?php echo $baseUrl ?>">
                <i class="<?php echo $row['icon'] ?>"></i>
                <?php echo $row['name'] ?>
            </a>
        </li><!-- End Dashboard Nav -->
        <?php else : ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="<?php echo $row['icon'] ?>"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <?php foreach($row['sub_menu'] AS $rows): 
                        $checkmenu = $helpers->checkactivemenu($uri, $rows['active_keyword']); 
                        $active = ($checkmenu) ? 'active' : '';   
                    ?>
                    <li>
                        <a href="<?php echo BASE_URL . '/' . $rows['url'] ?>">
                            <i class="<?php echo $rows['icon']. ' ' . $active ?>"></i><span><?php echo $rows['name'] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li><!-- End Components Nav -->
        
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>

  </aside><!-- End Sidebar-->