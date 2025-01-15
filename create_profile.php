<?php

include_once "header.php";

$role = $_COOKIE["ROLE"];

if ($role == "Master") : ?>
    <div class='main'>
        <h1>Ваши данные</h1>
        <div class="btn_block">
            <form action="backend.php" id='form' class="profile-form" method="post">
                <input type="text" hidden name="action_type" value="create_master">
                <div class="element">
                    <input class="form-control item" type="number" name="experience" maxlength="16"
                           id="experience" placeholder="Ваш опыт" required>
                </div>
                <div class="element">
                    <input class="form-control item" type="text" name="qualification" maxlength="200" minlength="1"
                           id="qualification" placeholder="Квалификация" required>
                </div>
                <div class="element">
                    <input class="form-control item" type="file" name="photo"  id="photo" placeholder="Фото">
                    <label for="photo">Выбрать фото</label>
                </div>
                <input type="submit" class='btn' value="Сохранить">
            </form>
        </div>
    </div>
    </div>

<?php elseif ($role == "Client"): ?>
    <div class='main'>
        <h1>Ваши данные</h1>
        <div class="btn_block">
            <form action="backend.php" id='form' class="profile-form" method="post">
                <input type="text" hidden name="action_type" value="create_client">
                <div class="element">
                    <input class="form-control item" type="text" name="address" maxlength="200" minlength="4"
                           id="address" placeholder="Ваш адрес" required>
                </div>
                <div class="element">
                    <input class="form-control item" type="file" name="photo"  id="photo" placeholder="Фото">
                    <label for="photo">Выбрать фото</label>
                </div>
                <input type="submit" class='btn' value="Сохранить">
            </form>
        </div>
    </div>
    </div>
<?php endif ?>
<?php include_once "footer.php"; ?>