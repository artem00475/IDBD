
<?php

use classes\db\DBPostgres;

include_once "header.php";
?>

<?php

$role=$_COOKIE["ROLE"];

if (isset($_COOKIE["PROFILE_ID"])){
    $userId=$_COOKIE["PROFILE_ID"];
}else{
    $userId=0;
}

?>
<?php if ($role=="Master" || $_GET["role"]=="master"):?>
<?php 
    if ($userId==0){
        $experience = "";
        $qualification ="";
    }else{
        $master = DBPostgres::getMasterProfileHandler()->getById($userId);
        $experience = $_GET['role']=="master" ? "" : $master->getExperience() ;
        $qualification = $_GET['role']=="master" ? "" : $master->getQualification();
    }

?>

<!-- обработка формы -->
<div class='mains'>
    <h1>Ваши данные</h1>
    <div class="btn_block">
    <form action="backend.php" id='form' class="qa-form" method="post">
        <input type="text" hidden name="action_type" value="qa">
            <div class="element">
                <input class="form-control item" type="text" name="experience" maxlength="200" minlength="4" id="experience" placeholder="Ваш опыт" value="<?php echo $experience;?>" required>
            </div>
            <div class="element">
                <input class="form-control item" type="text" name="qualification" maxlength="200" minlength="1" id="qualification" placeholder="Квалификация" value="<?php echo $qualification;?>" required>
            </div>
            <!-- <div class="element">
                <input class="form-control item" type="file" name="photo"  id="photo" placeholder="Фото" required>
                <label for="photo">Выбрать фото</label>
            </div> -->
            <input type="submit" class='btn' value="Сохранить">
        </form>
    </div>
    </div>
</div>

<?php elseif ($role=="Client"|| $_GET["role"]=="client"):?>
<?php 
    if ($userId==0){
        $address ="";
    }else{
        $client = DBPostgres::getClientProfileHandler()->getById($userId);
        $address = $_GET['role']=="client" ? "" :  $client->getAddress();
    }
    // $client = DBPostgres::getClientProfileHandler()->getById($userId);
    // $address = $client->getAddress();
?>
<div class='mains'>
    <h1>Ваши данные</h1>
    <div class="btn_block">
    <form action="backend.php" id='form' class="qa-form" method="post">
        <input type="text" hidden name="action_type" value="qa">
            <div class="element">
                <input class="form-control item" type="text" name="address" maxlength="200" minlength="4" id="address" placeholder="Ваш адрес" value="<?php echo $address;?>" required>
            </div>
            <!-- <div class="element">
                <input class="form-control item" type="file" name="photo"  id="photo" placeholder="Фото" required>
                <label for="photo">Выбрать фото</label>
            </div> -->
            <input type="submit" class='btn' value="Сохранить">
        </form>
    </div>
    </div>
</div>
<?php endif?>
<?php include_once "footer.php";?>