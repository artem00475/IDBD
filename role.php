<?php

use classes\db\DBPostgres;

include_once "header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ROLE'])) {
    $role = $_POST['ROLE'];
    $userId = $_COOKIE["USER_ID"];
    setcookie("ROLE", $role);
    if ($role == "Master" && $profileId = DBPostgres::getMasterProfileHandler()->authorize($userId)) {
        setcookie("PROFILE_ID", $profileId);
    } elseif ($role == "Client" && $profileId = DBPostgres::getClientProfileHandler()->authorize($userId)) {
        setcookie("PROFILE_ID", $profileId);
    } else {
        setcookie("PROFILE_ID", '');
    }
    die();
}
?>


<div class='main'>
    <h2>Выберете нужный профиль:</h2>
    <div class="form-group btns">
        <button class="btn bcw worker-btn">Мастер</button>
        <button class="btn bcw client-btn">Клиент</button>
    </div>
</div>

<?php
$role = $_COOKIE['ROLE'] ?? '';
$profileId = $_COOKIE["PROFILE_ID"] ?? '';
if ($role && !$profileId) { ?>
    <div class='main'>
        <h3>У вас не создан этот профиль. Хотите создать его?</h3>
        <div class="form-group btns">
            <a class="btn create-role-btn" href="create_profile.php">Создать профиль</a>
        </div>
    </div>
<?php }
?>
<script src="/~s338923/isbd/js/role.js"></script>

<?php include_once "footer.php"; ?>
