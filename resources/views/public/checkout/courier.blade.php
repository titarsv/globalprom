<div class="order-page__form-input-wrapper">
    <input type="text" class="checkout-step__del-info-input checkout-step__del-info-input_long" name="courier[street]" placeholder="Улица:">
</div>

<div class="order-page__form-input-wrapper">
    <input type="text" class="checkout-step__del-info-input checkout-step__del-info-input_short" name="courier[house]" placeholder="Дом:">
</div>

<div class="order-page__form-input-wrapper">
    <input type="text" class="checkout-step__del-info-input checkout-step__del-info-input_short" name="courier[apart]" placeholder="Кв:">
</div>

<div class="order-page__form-select-wrapper">
    <select name="payment" id="checkout-step__payment" class="order-page__form-select">
        <option disabled="" selected="">Выберите способ оплаты</option>
        <option value="cash">Наличными при самовывозе</option>
        <option value="card">Онлайн-оплата картой</option>
        {{--<option value="prepayment">Предоплата</option>--}}
    </select>
</div>