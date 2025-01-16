<?php

use classes\db\DBPostgres;

?>

<h1>Вопросы и ответы</h1>
<div class="btn_block">
    <button class="btn" onclick="showForm(this)">Новый вопрос</button>
    <form action="<?= HOST ?>/controller/" id='form' class="qa-form" method="post">
        <input type="text" hidden name="action_type" value="qa">
        <div class="element">
            <label for="theme">Тема</label>
            <input type="text" name='theme' required>
        </div>
        <div class="element">
            <label for="comment">Напишите вопрос</label>
            <input type="text" name='comment' required>
        </div>
        <input type="submit" class='btn' value="Сохранить">
    </form>
</div>
<div class="list">

    <?php
    $questions = DBPostgres::getQAHandler()->getAll();
    foreach ($questions as $question) {
        ?>
        <div class="item">
            <div class='info'>
                <p><?= $question['Q']; ?></p>
                <p><?= $question['A']; ?></p>
            </div>
        </div>
        <?php
    }
    ?>
</div>

