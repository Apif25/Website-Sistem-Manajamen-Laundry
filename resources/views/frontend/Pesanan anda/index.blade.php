@extends('frontend.layouts.app')

@section('content')
<div class="top-container">
    <img src="{{ asset('img/pesanan/section1.png') }}" alt="Produk" class="bg-hero-image">
    <div class="top-container-text">
        <H1>Pesanan Anda</H1>
    </div>
</div>
<div class="main-container">
        
        <div class="tabs-container">
            <button class="tab-btn-order active" onclick="switchTable(event, 'diproses')">
                Diproses
            </button>
            <button class="tab-btn-order" onclick="switchTable(event, 'selesai')">
                Selesai
            </button>
            <button class="tab-btn-order" onclick="switchTable(event, 'dibatalkan')">
                Dibatalkan
            </button>
        </div>

        <div class="table-content">

            <div id="diproses" class="table-panel active">
                <div class="table-responsive">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order-row" onclick="">
                                <td class="order-id">#ORD-9481</td>
                                <td>05 Jun 2026</td>
                                <td>Jaket Windbreaker Anti Air x1</td>
                                <td>Rp 320.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="selesai" class="table-panel">
                <div class="table-responsive">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order-row" onclick="">
                                <td class="order-id">#ORD-9482</td>
                                <td>06 Jun 2026</td>
                                <td>Sepatu Running Pro x1</td>
                                <td>Rp 750.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="dibatalkan" class="table-panel">
                <div class="table-responsive">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order-row" onclick="">
                                <td class="order-id">#ORD-9479</td>
                                <td>04 Jun 2026</td>
                                <td>Tas Ransel Laptop 15" x1</td>
                                <td>Rp 450.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection