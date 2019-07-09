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
        <option value="instant_installments">Мгновенная рассрочка</option>
        {{--<option value="payment_in_parts">Оплата частями</option>--}}
    </select>
</div>

<div class="order-page__form-select-wrapper hidden">
    <select name="payment_parts" id="checkout-payment__parts" class="order-page__form-select">
        <option disabled="" selected="">Выберите колличество платежей</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
    </select>
</div>