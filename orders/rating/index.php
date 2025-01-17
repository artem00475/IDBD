<h1>Оценка заказа</h1>
<form method='POST' class='rate-order-form' id='form' style="display: flex;" action="<?= HOST ?>/controller/">
    <input type="text" hidden name="action_type" value="rate_order">
    <input type="text" hidden name="order_id" value="<?= $orderId ?>">
    <div class="element">
        <label for="date">Рейтинг</label>
        <input class="form-control item" type="number" name='rating' required min="0" max="5" step="0.1">
    </div>
    <div class="element">
        <label for="comment">Комментарий</label>
        <input class="form-control item" type="text" name='comment' required>
    </div>
    <input type="submit" class='btn' value="Сохранить">
</form>

