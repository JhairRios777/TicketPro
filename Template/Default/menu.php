<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand d-flex align-items-center" href="#">
            <i class="fas fa-cube"></i>
            <span class="fw-bold ms-2">Sistema Web</span>
        </a>
        <button class="btn-close-sidebar d-lg-none" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <?php
                $menu = array(
                    "Inicio" => array(
                        "Id" => 1,
                        "Nombre" => "Inicio",
                        "Url" => "/",
                        "Icono" => "fas fa-home"
                    ),
                    "Dashboard" => array(
                        "Id" => 2,
                        "Nombre" => "Dashboard",
                        "Url" => "#/dashboard",
                        "Icono" => "fas fa-chart-line"
                    ),
                    "Usuarios" => array(
                        "Id" => 3,
                        "Nombre" => "Usuarios",
                        "Url" => "#/usuarios",
                        "Icono" => "fas fa-users"
                    ),
                    "Configuracion" => array(
                        "Id" => 4,
                        "Nombre" => "Configuración",
                        "Url" => "#/configuracion",
                        "Icono" => "fas fa-cog"
                    ),
                );

                if (!function_exists('getMenu')) {
                function getMenu($miMenu) {
                    foreach ($miMenu as $key => $value) {
                        // si tiene hijos, renderizar collapse
                        if (isset($value['Children']) && is_array($value['Children'])) {
                            $submenuId = 'themesSubmenu-' . (isset($value['Id']) ? $value['Id'] : md5($key));
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="' . htmlspecialchars($value['Url']) . '" data-bs-toggle="collapse" data-bs-target="#' . $submenuId . '" aria-expanded="false" aria-controls="' . $submenuId . '">';
                            if (!empty($value['Icono'])) {
                                echo '<i class="' . htmlspecialchars($value['Icono']) . '"></i>';
                            }
                            echo '<span class="ms-2">' . htmlspecialchars($value['Nombre']) . '</span>';
                            echo '<i class="fas fa-chevron-down ms-auto"></i>';
                            echo '</a>';
                            echo '<div class="collapse" id="' . $submenuId . '">';
                            echo '<ul class="nav flex-column ms-3">';
                            foreach ($value['Children'] as $child) {
                                echo '<li class="nav-item">';
                                $extraAttrs = '';
                                if (isset($child['DataTheme'])) {
                                    $extraAttrs = ' data-theme="' . htmlspecialchars($child['DataTheme']) . '"';
                                }
                                echo '<a class="nav-link theme-option" href="' . htmlspecialchars($child['Url']) . '"' . $extraAttrs . '>';
                                if (!empty($child['Icono'])) {
                                    $style = isset($child['IconStyle']) ? ' style="' . htmlspecialchars($child['IconStyle']) . '"' : '';
                                    echo '<i class="' . htmlspecialchars($child['Icono']) . '"' . $style . '></i>';
                                }
                                echo '<span class="ms-2">' . htmlspecialchars($child['Nombre']) . '</span>';
                                echo '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                            echo '</li>';
                        } else {
                            // item normal
                            echo '<li class="nav-item">';
                            $target = isset($value['Target']) ? ' target="' . htmlspecialchars($value['Target']) . '"' : '';
                            echo '<a class="nav-link' . (isset($value['Active']) && $value['Active'] ? ' active' : '') . '" href="' . htmlspecialchars($value['Url']) . '"' . $target . '>';
                            if (!empty($value['Icono'])) {
                                echo '<i class="' . htmlspecialchars($value['Icono']) . '"></i>';
                            }
                            echo '<span class="ms-2">' . htmlspecialchars($value['Nombre']) . '</span>';
                            echo '</a>';
                            echo '</li>';
                        }
                    }
                }
                }
                // renderizar menú
                getMenu($menu);
            ?>
        </ul>
    </nav>
</aside>