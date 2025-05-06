<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="assets/img/jne logo.png" class="header-logo" /> <span
                    class="logo-name">
                    <h6>fuzzy tsukamoto</h6>
                </span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown <?= ($_GET['p'] == 'home') ? 'active' : '' ?>">
                <a href="?p=home" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <?php if ($_SESSION['posisi'] == 'Admin') { ?>
                <li class="menu-header">Master Data</li>
                <li class="dropdown <?= ($_GET['p'] == 'user') ? 'active' : '' ?>">
                    <a href="?p=user" class="nav-link"><i data-feather="user-plus"></i><span>Data User</span></a>
                </li>
                <li class="dropdown <?= ($_GET['p'] == 'variabel') ? 'active' : '' ?>">
                    <a href="?p=variabel" class="nav-link"><i data-feather="folder"></i><span>Data Variabel</span></a>
                </li>
                <li class="dropdown <?= ($_GET['p'] == 'himpunan') ? 'active' : '' ?>">
                    <a href="?p=himpunan" class="nav-link"><i data-feather="folder"></i><span>Data Himpunan</span></a>
                </li>
                <li class="dropdown <?= ($_GET['p'] == 'rule') ? 'active' : '' ?>">
                    <a href="?p=rule" class="nav-link"><i data-feather="folder"></i><span>Data Rule Fuzzy</span></a>
                </li>
                <li class="dropdown <?= ($_GET['p'] == 'dataset') ? 'active' : '' ?>">
                    <a href="?p=dataset" class="nav-link"><i data-feather="folder"></i><span>Dataset</span></a>
                </li>
                <li class="dropdown <?= ($_GET['p'] == 'proses') ? 'active' : '' ?>">
                    <a href="?p=proses" class="nav-link"><i data-feather="settings"></i><span>Proses</span></a>
                </li>
            <?php } ?>
            <li class="dropdown <?= ($_GET['p'] == 'laporan') ? 'active' : '' ?>">
                <a href="?p=laporan" class="nav-link"><i data-feather="book"></i><span>Laporan</span></a>
            </li>
        </ul>
    </aside>
</div>