<?php

use classes\db\DBPostgres;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ROLE'])) {
    $role = $_POST['ROLE'];
    setcookie("ROLE", $role, 0, HOST);
    if ($role == "Master" && $profileId = DBPostgres::getMasterProfileHandler()->authorize(USER_ID)) {
        setcookie("PROFILE_ID", $profileId, 0, HOST);
    } elseif ($role == "Client" && $profileId = DBPostgres::getClientProfileHandler()->authorize(USER_ID)) {
        setcookie("PROFILE_ID", $profileId, 0, HOST);
    } else {
        setcookie("PROFILE_ID", '', 0, HOST);
    }
    die();
}
?>

<h2>Выберете нужный профиль:</h2>
<div class="form-group btns">
    <button class="btn bcw worker-btn">Мастер</button>
    <button class="btn bcw client-btn">Клиент</button>
</div>

<?php
if (ROLE && !PROFILE_ID) { ?>
    <h3>У вас не создан этот профиль. Хотите создать его?</h3>
    <div class="form-group btns">
        <a class="btn create-role-btn" href="<?= HOST ?>/profile/create/">Создать профиль</a>
    </div>
<?php }
?>
<script>
    <?php include 'js/role.js'; ?>
</script>

