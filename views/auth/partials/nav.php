<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <?= app_name() ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a href="<?= route('home')?>" class="nav-link">главная</a>
            </li>
            <li class="nav-item">
                <a href="<?= route('about')?>" class="nav-link">о нас</a>
            </li>
            <li class="nav-item">
                <a href="<?= route('contact')?>" class="nav-link">контакт</a>
            </li>
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item">
                <a href="<?= route('user.sign.in')?>" class="nav-link">вход</a>
            </li>
            <li class="nav-item">
                <a href="<?= route('user.sign.up')?>" class="nav-link">регистрация</a>
            </li>
        </ul>
    </div>
</nav>