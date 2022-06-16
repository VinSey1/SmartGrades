<link href="<?= DS.CSS.DS ?>navbar.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <img src="<?= DS.FILES.DS ?>logo-navbar.png" class="navbar-brand" style="height: 7vh" alt="Logo de SmartGrades">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" style="font-size: 20px">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Accueil</span></a>
                </li>
                <?php
                    if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "etudiant")
                        require_once COMMON.DS.'navbar-etudiant.php';
                    else if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "professeur")
                        require_once COMMON.DS.'navbar-professeur.php';
                    else if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "administrateur")
                        require_once COMMON.DS.'navbar-administrateur.php';
                ?>
            </ul>
            <?php if (!empty($_SESSION["user"])) { ?>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/compte">Gérer le compte</a></li>
                            <li><a class="dropdown-item" href="/deconnexion">Déconnexion</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <p class="mb-0 dropdown-item text-muted">
                                <?= $_SESSION["user"]->email ?>
                            </p>
                        </ul>
                    </li>
                </ul>
            <?php } else  { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/connexion">Connexion</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/inscription">Inscription</span></a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>