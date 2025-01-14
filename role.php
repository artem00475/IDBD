<?php

use classes\db\DBPostgres;

include_once "header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ROLE'])) {
    $role = $_POST['ROLE'];
    $userId = $_COOKIE["USER_ID"];
    setcookie("ROLE", $role);
    if ($role == "Master" && $profileId = DBPostgres::getMasterProfileHandler()->authorize($userId) != 0) {
        setcookie("PROFILE_ID", $profileId);
    } elseif ($role == "Client" && $profileId = DBPostgres::getClientProfileHandler()->authorize($userId) != 0) {
        setcookie("PROFILE_ID", $profileId);
    } else {
        setcookie("PROFILE_ID", '');
    }
    die();
}
?>


<div class='mains'>
    <h2>Выберете свою роль:</h2>
    <div class="form-group btns">
        <button class="btn bcw worker-btn">Мастер</button>
        <button class="btn bcw client-btn">Клиент</button>
    </div>
    <button class="btn ready-btn">Готово</button>

</div>

<?php
$role = $_COOKIE['ROLE'] ?? '';
$profileId = $_COOKIE["PROFILE_ID"] ?? '';
if ($role && !$profileId) {
    $profile_url = $role == "Client" ? "my_profile.php?role=client" : "my_profile.php?role=master";
    ?>
    <div class='mais'>
        <h3>У вас нету этой роли. Хотите создать новую роль?</h3>
        <div class="form-group btns">
            <a class="btn create-role-btn" href="<?php echo $profile_url; ?>">Создать роль</a>
        </div>
    </div>

<?php }
?>
<script src="/~s338923/isbd/js/role.js"></script>

<?php include_once "footer.php"; ?>
