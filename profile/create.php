<?php if (ROLE == "Master") : ?>
    <h1>Ваши данные</h1>
    <div class="btn_block">
        <form id='form' class="profile-form" method="post" enctype="multipart/form-data"
              action="<?= HOST ?>/controller/profile/">
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
                <input class="form-control item" type="file" name="photo" accept="image/*" id="photo"
                       placeholder="Фото">
                <label for="photo">Выбрать фото</label>
            </div>
            <input type="submit" class='btn' value="Сохранить">
        </form>
    </div>
<?php elseif (ROLE == "Client"): ?>
    <h1>Ваши данные</h1>
    <div class="btn_block">
        <form id='form' class="profile-form" method="post" enctype="multipart/form-data"
              action="<?= HOST ?>/controller/profile/">
            <input type="text" hidden name="action_type" value="create_client">
            <div class="element">
                <input class="form-control item" type="text" name="address" maxlength="200" minlength="4"
                       id="address" placeholder="Ваш адрес" required>
            </div>
            <div class="element">
                <input class="form-control item" type="file" name="photo" accept="image/*" id="photo"
                       placeholder="Фото">
                <label for="photo">Выбрать фото</label>
            </div>
            <input type="submit" class='btn' value="Сохранить">
        </form>
    </div>
<?php endif ?>
