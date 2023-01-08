<form action="" method="post" class="form form_registr">
    <h1 class="form__title">Регистрация</h1>
    <p>Обязательны к заполнению <span aria-label="required">*</span></p>
    <label>
        Логин <span aria-label="required">*</span><input type="text" name="login" class="form__input form__input_type_login" autocomplete="off" title="Логин должен состоять из английских символов, цифр, знака подчеркивания _ . Начинаться с буквы и заканчиваться буквой или цифрой. Длина 6-8 символов." required>
    </label>
    <label>
        Пароль <span aria-label="required">*</span><input type="password" name="password" class="form__input form__input_type_password" autocomplete="off" title="Пароль должен состоять из английских символов, цифр. Начинаться с буквы. Длина 6-8 символов." required>
    </label>
    <label>
        Показать пароль <input type="checkbox" name="checkbox" class="form__input_type_checkbox">
    </label>
    <label>
        Повторите пароль <span aria-label="required">*</span><input type="password" name="password-repeat" class="form__input form__input_type_password-repeat" autocomplete="off" required>
    </label>
    <label>
        Дата рождения <span aria-label="required">*</span><input type="date" name="date-birthday" class="form__input form__input_type_date" required>
    </label>
    <button type="submit" class="form__button form__button_type_submit">Войти</button>
    <button type="button" class="form__button form__button_type_close">Закрыть</button>
</form>