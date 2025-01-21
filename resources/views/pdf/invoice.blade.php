<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>

<style>
    /* Global styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #e0f7fa;
        padding: 2rem;
    }

    .invoice-container {
        max-width: 36rem;
        background-color: white;
        margin: 0 auto;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }

    .header {
        display: table;
        width: 100%;
    }

    .header-left {
        display: table-cell;
        vertical-align: top;
        width: 50%;
    }

    .brand-name {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .company-slogan {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .header-right {
        display: table-cell;
        vertical-align: top;
        text-align: right;
        width: 50%;
    }

    .invoice-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .invoice-date {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .address-section {
        /* padding: 1.5rem; */
        display: table;
        width: 100%;
    }

    .office-address, .recipient-address {
        display: table-cell;
        vertical-align: top;
        width: 50%;
        padding-right: 1rem;
        padding-bottom: 1rem;
    }

    .section-title {
        font-weight: bold;
    }

    .address-text {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .invoice-details {
        /* padding: 1.5rem; */
        display: table;
        width: 100%;
    }

    .invoice-number, .total-due {
        display: table-cell;
        vertical-align: top;
        width: 50%;
        padding-right: 1rem;
        padding-bottom: 1rem;
    }

    .invoice-id {
        font-size: 1.125rem;
        font-weight: bold;
        color: #3b82f6;
    }

    .total-amount {
        font-size: 1rem;
        color: #6b7280;
    }

    .items-table {
        width: 100%;
        margin-top: 1.5rem;
        border-collapse: collapse;
    }

    .table-header {
        background-color: #bbdefb;
        font-weight: bold;
    }

    .table-cell {
        padding: 0.5rem 1rem;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    .total-summary {
        display: table;
        width: 100%;
    }

    .summary-left {
        display: table-cell;
        vertical-align: top;
        text-align: right;
    }

    .summary-right {
        display: table-cell;
        vertical-align: top;
        padding-left: 1rem;
        text-align: right;
    }

    .summary-item {
        font-weight: bold;
    }

    .summary-value {
        color: #6b7280;
    }

    .payment-terms {
        background-color: #bbdefb;
        font-weight: 600;
        display: table;
        width: 100%;
    }

    .payment-info, .terms-info {
        display: table-cell;
        vertical-align: top;
        padding-inline:24px;
        width: 50%;
    }

    .payment-title, .terms-title {
        font-weight: bold;
        color: #3b82f6;
        font-size: 1rem;
    }
</style>

<body>
<div class="invoice-container">
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1 class="brand-name">Brand Name.</h1>
            <p class="company-slogan">company slogan here</p>
        </div>
        <div class="header-right">
            <h2 class="invoice-title">INVOICE</h2>
            <p class="invoice-date">
                {{ \Carbon\Carbon::parse($data['created_at'])->format('d/m/Y H:i:s') }}
            </p>
            <p class="invoice-date">
                {{ $data['status'] }}
            </p>
        </div>
    </div>

    <!-- Address Section -->
    <div class="address-section">
        @if( $data['shipping_address'] && count($data['shipping_address']) > 0 )
            <div class="office-address">
                <p class="section-title">Shipping Address</p>

                <p class="address-text">{{ $data['shipping_address']['street_address'] }}</p>

                <p class="address-text">
                    {{ $data['shipping_address']['street_address_plus'] }}
                    {{ $data['shipping_address']['postal_code'] }}
                </p>

                <p class="address-text">
                    {{ $data['shipping_address']['last_name'] }}
                    {{ $data['shipping_address']['first_name'] }}
                </p>

                <p class="address-text">
                    {{ $data['shipping_address']['country_name'] }}
                    {{ $data['shipping_address']['city'] }}
                </p>
                <p class="address-text">{{ $data['shipping_address']['phone'] }}</p>
            </div>
        @endif

        @if($data['shipping_option'] && count($data['shipping_option']) > 0 )

            <div class="recipient-address">
                <p class="section-title">Shipping option:</p>
                <p class="address-text"> {{ $data['shipping_option']['name'] }}</p>
                <p class="address-text">
                    {{ $data['shipping_option']['price'] }}
                    {{ $data['currency_code']}}
                </p>

            </div>

        @endif

    </div>

    <!-- Invoice Details -->
    <div class="invoice-details">
        <div class="invoice-number">
            <p class="section-title">Invoice Number</p>
            <p class="invoice-id">{{ $data['number'] }}</p>
        </div>
        <div class="total-due">
            <p class="section-title">Total due:</p>
            <p class="total-amount">{{ $total }}</p>
        </div>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
        <tr class="table-header">
            <th class="table-cell">Item</th>
            <th class="table-cell">Quantity</th>
            <th class="table-cell">Price</th>
            <th class="table-cell">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['items'] as $item)
            <tr>
                <td class="table-cell">{{ $item['name'] }}</td>
                <td class="table-cell">{{ $item['quantity'] }}</td>
                <td class="table-cell">{{ $item['unit_price_amount'] }}</td>
                <td class="table-cell">{{ $item['unit_price_amount'] *  $item['quantity'] }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <!-- Total Summary -->
    <div class="total-summary">
        <div class="summary-left">
            <p class="summary-item">Total:</p>
        </div>
        <div class="summary-right">
            <p class="summary-value">{{ $total }}</p>
        </div>
    </div>

    <!-- Payment Terms -->
    <div class="payment-terms">
        <div class="payment-info">
            <p class="payment-title">Payment Method</p>
            <p>
                @switch($data['payment_method']['slug'])
                    @case('notchpay')
                        <svg style="width: 8px; width: 8px;" viewBox="0 0 144 144" fill="none">
                            <path d="M83.1953 111.293C83.1953 113.827 81.8349 115.399 79.1991 115.414C76.3648 115.414 75.1248 113.798 75.1106 111.08C75.1106 107.386 75.1106 103.693 75.0681 100.006C75.1392 98.5999 74.9469 97.1925 74.5013 95.8573C74.0832 94.8966 72.8574 93.6725 72.0071 93.6796C71.4483 93.8044 70.9313 94.0725 70.5066 94.458C70.0818 94.8434 69.7639 95.3329 69.5838 95.8787C69.1941 99.2021 69.2579 102.582 69.1516 105.934C69.0879 107.884 69.1516 109.849 68.939 111.784C68.6769 114.168 67.2385 115.478 64.801 115.421C62.3636 115.364 60.9677 113.997 60.8614 111.578C60.7481 108.731 60.8614 105.934 60.8614 103.109H60.9394C60.9394 100.398 60.7835 97.672 60.9394 94.9749C61.322 89.2389 65.6513 85.2678 71.3907 85.1824C78.0653 85.0757 82.6639 88.6055 83.0465 94.6831C83.3937 100.206 83.2379 105.756 83.1953 111.293Z" fill="#37384E"/>
                            <path d="M131.541 122.288C128.647 123.643 125.402 124.049 122.266 123.448C113.239 121.576 104.354 119.029 95.4186 116.716C91.4861 115.698 89.5021 113.079 89.4454 108.944C89.4454 107.094 89.5163 105.244 89.4454 103.408C89.3179 100.824 90.154 99.6716 92.8678 100.639C94.4454 101.305 96.1209 101.706 97.8277 101.828C99.3441 101.828 101.371 101.451 102.221 100.405C102.929 99.579 102.653 97.2235 101.937 96.1346C93.1323 82.5467 84.2257 69.0157 75.2175 55.5417C73.3256 52.695 70.6897 52.752 68.7625 55.6555C59.8416 69.056 50.9279 82.4637 42.1842 95.9709C41.8036 96.6735 41.5764 97.4494 41.5178 98.247C41.4591 99.0446 41.5704 99.8457 41.8441 100.597C42.6802 102.454 44.6784 102.732 46.6127 101.778C47.1312 101.634 47.6592 101.527 48.1928 101.458C55.5407 99.3229 54.5699 99.9633 54.5699 106.439C54.5699 113.983 53.337 115.513 46.0105 117.363C37.9966 119.384 30.004 121.477 21.9973 123.505C15.0604 125.263 9.45568 122.26 7.44335 115.762C6.2884 111.912 7.5213 108.582 9.62573 105.4C21.6666 87.1962 33.7122 68.9873 45.7625 50.7736C51.0342 42.7745 56.3201 34.7257 61.6626 26.7338C67.6004 17.8594 76.3937 17.7171 82.211 26.5416C99.6889 52.9157 117.134 79.3276 134.545 105.778C138.669 111.997 137.55 119.235 131.541 122.288Z" fill="#218366"/>
                        </svg>

                        @break

                    @case('cash')

                        @break

                    @case('stripe')

                        @break

                    @default

                @endswitch

                {{ $data['payment_method']['title'] }}
            </p>
        </div>

        <div class="terms-info">
            <p class="terms-title">Terms & Conditions</p>
            <p>Terms and conditions</p>
        </div>
    </div>
</div>
</body>
</html>
