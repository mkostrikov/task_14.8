<header class="header">
    <div class="header__bar">
        <button class="header__button header__button_auth">Войти</button>
        <button class="header__button header__button_reg">Зарегистрироваться</button>
    </div>
    <div class="logo">SPA</div>
    <div class="header__user-bar">
        <span class="user-login">Привет, admin.</span>
        <button class="header__button header__button_">Выйти</button>
    </div>
    <dialog class="dialog dialog_auth">
        <?php
        require __DIR__ . '/form_auth.php';
        ?>
    </dialog>
    <dialog class="dialog dialog_registr">
        <?php
        require __DIR__ . '/form_registr.php';
        ?>
    </dialog>
</header>