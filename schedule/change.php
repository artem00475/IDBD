<h1>Изменение рабочего графика</h1>

<form method='POST' class='schedule-form' id='form' style="display: flex;" action="<?= HOST ?>/controller/service/">
    <input type="text" hidden name="action_type" value="schedule">
    <div class="element">
        <label for="days[]">Выберите дни</label>
        <select class="form-control item" name="days[]" required multiple="multiple">
            <option value="1">Понедельник</option>
            <option value="2">Вторник</option>
            <option value="3">Среда</option>
            <option value="4">Четверг</option>
            <option value="5">Пятница</option>
            <option value="6">Суббота</option>
            <option value="7">Воскресенье</option>
        </select>
    </div>
    <input type="submit" class='btn' value="Сохранить">
</form>