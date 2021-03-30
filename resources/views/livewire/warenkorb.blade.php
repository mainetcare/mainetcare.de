<div class="" id="Cart">
    @if($is_mobile)
        @include('cart.cart-mobile')
    @else
        @include('cart.cart-desktop')
    @endif
</div>
