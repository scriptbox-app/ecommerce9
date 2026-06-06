@php
	$cardColor = !empty($gs->colors) ? $gs->colors : '#6c5ce7';
	$buyNowColor = !empty($gs->buy_now_color) ? $gs->buy_now_color : $cardColor;
	$cardHex = ltrim($cardColor, '#');
	if (strlen($cardHex) === 3) {
		$cardHex = $cardHex[0].$cardHex[0].$cardHex[1].$cardHex[1].$cardHex[2].$cardHex[2];
	}
	$cardR = hexdec(substr($cardHex, 0, 2));
	$cardG = hexdec(substr($cardHex, 2, 2));
	$cardB = hexdec(substr($cardHex, 4, 2));
@endphp
<style>
.trending-item-slider .top-rated-item {
	display: flex;
	flex-direction: column;
	height: 100%;
	position: relative;
	text-decoration: none;
	color: inherit;
	border: 1.5px solid #eceef3;
	border-radius: 14px;
	background: #fff;
	overflow: hidden;
	margin: 0 8px 16px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
	-webkit-transition: box-shadow 0.3s ease, border-color 0.3s ease;
	transition: box-shadow 0.3s ease, border-color 0.3s ease;
}
.trending-item-slider .top-rated-item:hover {
	border-color: {{ $cardColor }};
	box-shadow: 0 10px 30px rgba({{ $cardR }}, {{ $cardG }}, {{ $cardB }}, 0.18);
	transform: none;
	z-index: 2;
}
.trending-item-slider .top-rated-item .top-rated-item-link {
	display: block;
	text-decoration: none;
	color: inherit;
	width: 100%;
}
.trending-item-slider .top-rated-item .item-img {
	position: relative;
	border-radius: 14px 14px 0 0;
	overflow: hidden;
	background: #f8f9fc;
}
.trending-item-slider .top-rated-item .item-img img {
	-webkit-transition: transform 0.4s ease;
	transition: transform 0.4s ease;
}
.trending-item-slider .top-rated-item:hover .item-img img {
	transform: scale(1.06);
}
.trending-item-slider .top-rated-item .buy-now-area {
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	top: auto;
	padding: 12px 14px;
	margin: 0;
	opacity: 0;
	visibility: hidden;
	transform: translateY(8px);
	pointer-events: none;
	z-index: 5;
	background: linear-gradient(to top, rgba(255, 255, 255, 0.97) 70%, rgba(255, 255, 255, 0));
	-webkit-transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
	transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
}
.trending-item-slider .top-rated-item:hover .buy-now-area {
	opacity: 1;
	visibility: visible;
	transform: translateY(0);
	pointer-events: auto;
}
.trending-item-slider .top-rated-item .buy-now-area .buy-now-btn {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 7px;
	width: 100%;
	padding: 9px 16px;
	margin: 0;
	border: none;
	border-radius: 50px;
	background: {{ $buyNowColor }};
	color: #fff;
	font-size: 12px;
	font-weight: 700;
	letter-spacing: 0.4px;
	text-transform: uppercase;
	cursor: pointer;
	text-align: center;
	-webkit-transition: filter 0.25s ease;
	transition: filter 0.25s ease;
}
.trending-item-slider .top-rated-item .buy-now-area .buy-now-btn:hover {
	filter: brightness(1.08);
	color: #fff;
}
.trending-item-slider .top-rated-item .info {
	position: relative;
	top: 0 !important;
	flex: 1;
	display: flex;
	flex-direction: column;
	align-items: center;
	text-align: center;
	padding: 8px 10px 6px;
	background: #fafbfc;
	border-top: 1px solid #f0f2f5;
	-webkit-transition: none;
	transition: none;
}
.trending-item-slider .top-rated-item:hover .info {
	top: 0 !important;
	background: #fff;
}
.trending-item-slider .top-rated-item .info .product-meta {
	width: 100%;
	display: flex;
	flex-direction: column;
	align-items: center;
}
.trending-item-slider .top-rated-item .info .name {
	font-size: 13px;
	font-weight: 600;
	line-height: 1.3;
	color: #2d3436;
	margin: 0 0 4px;
	padding: 0;
	width: 100%;
	max-width: 100%;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	-webkit-transition: color 0.25s ease;
	transition: color 0.25s ease;
}
.trending-item-slider .top-rated-item:hover .info .name {
	color: {{ $cardColor }};
}
.trending-item-slider .top-rated-item .info .price-row {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	flex-wrap: nowrap;
	gap: 5px;
	margin: 0 0 3px;
	line-height: 1;
	width: 100%;
}
.trending-item-slider .top-rated-item .info .current-price {
	font-size: 17px;
	font-weight: 700;
	line-height: 1;
	color: {{ $cardColor }};
	letter-spacing: -0.3px;
}
.trending-item-slider .top-rated-item .info .old-price {
	font-size: 11px;
	font-weight: 500;
	line-height: 1;
	color: #b2bec3;
	text-decoration: line-through;
}
.trending-item-slider .top-rated-item .info .discount-badge {
	display: inline-block;
	font-size: 10px;
	font-weight: 700;
	line-height: 1;
	color: #fff;
	background: #e17055;
	padding: 2px 5px;
	border-radius: 3px;
	vertical-align: middle;
}
.trending-item-slider .top-rated-item .info .review-row {
	display: flex;
	align-items: center;
	justify-content: center;
	line-height: 1;
	margin: 0;
	padding: 0;
	width: 100%;
}
.trending-item-slider .top-rated-item .info .stars {
	display: block;
	margin: 0;
	line-height: 1;
}
.trending-item-slider .top-rated-item .info .stars .ratings {
	position: relative;
	display: inline-block;
	vertical-align: middle;
	height: 14px;
	line-height: 1;
}
.trending-item-slider .top-rated-item .info .stars .empty-stars:before,
.trending-item-slider .top-rated-item .info .stars .full-stars:before {
	font-size: 11px;
	letter-spacing: 0.5px;
	line-height: 1;
}
.trending-item-slider .top-rated-item .info .stars .empty-stars:before {
	-webkit-text-stroke: 0;
	color: #dfe6e9;
}
.trending-item-slider .top-rated-item .info .stars .full-stars {
	color: {{ $cardColor }};
}
.trending-item-slider .top-rated-item .info .stars .full-stars:before {
	-webkit-text-stroke: 0;
	color: {{ $cardColor }};
}
.trending-item-slider .top-rated-item .item-cart-area {
	position: relative !important;
	opacity: 1 !important;
	left: 0 !important;
	width: 100%;
	padding: 0;
	margin: 0;
	margin-top: auto;
	text-align: center;
	-webkit-transition: none;
	transition: none;
}
.trending-item-slider .top-rated-item:hover .item-cart-area {
	opacity: 1 !important;
}
.trending-item-slider .top-rated-item .item-cart-area .add-to-cart-btn {
	opacity: 1 !important;
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	margin: 0;
	padding: 13px 16px;
	border: none;
	border-radius: 0 0 12px 12px;
	background: {{ $cardColor }};
	color: #fff;
	font-size: 13px;
	font-weight: 600;
	line-height: 1.2;
	cursor: pointer;
	-webkit-transition: background 0.25s ease, filter 0.25s ease;
	transition: background 0.25s ease, filter 0.25s ease;
}
.trending-item-slider .top-rated-item:hover .item-cart-area .add-to-cart-btn {
	opacity: 1 !important;
}
.trending-item-slider .top-rated-item .item-cart-area .add-to-cart-btn:hover {
	filter: brightness(1.08);
	color: #fff;
}
.trending-item-slider .top-rated-item .item-cart-area .add-to-cart-btn.cart-out-of-stock {
	background: #edf0f3;
	color: #95a5a6;
	cursor: not-allowed;
}
.trending-item-slider .top-rated-item .item-cart-area .add-to-cart-btn.cart-out-of-stock:hover {
	filter: none;
	background: #edf0f3;
	color: #95a5a6;
}
.trending-item-slider .top-rated-item .item-cart-area .add-to-cart-btn i {
	font-size: 15px;
}
</style>
