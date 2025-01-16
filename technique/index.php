<?php

use classes\db\DBPostgres;

?>

<h1>Добавление прибора</h1>
<form method='POST' class='rate-order-form' id='form' style="display: flex;" action="<?= HOST ?>/controller/">
    <input type="text" hidden name="action_type" value="add_technique">
    <div class="element">
        <label for="date">Дата покупки</label>
        <input type="date" name='date' required>
    </div>
    <div class="element">
        <label for="technique">Выберите прибор</label>
        <select name="technique" required>
            <?php
            $arTechnique = DBPostgres::getTechniqueHandler()->getAll();
            foreach ($arTechnique as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
    </div>
    <input type="submit" class='btn' value="Сохранить">
</form>
<h2>Ваши приборы</h2>
<div class="list">
    <?php
    $arOwner = DBPostgres::getOwnerHandler()->getByClient(PROFILE_ID);
    foreach ($arOwner as $owner) { ?>
        <div class="item">
            <div class='info'>
                <p>Название: <?= $owner->getTechnique() ?></p>
                <p>Дата покупки: <?= $owner->getDate() ?></p>
            </div>
        </div>
    <?php } ?>
</div>
