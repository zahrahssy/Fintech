@php
function rupiah($angka){
$hasil_rupiah = "Rp" .number_format($angka,0,',','.');
return $hasil_rupiah;
}
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
@if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
    <div class="row justify-content-center">
        @if(Auth::user()->role == 'bank')
        <div class="col-md-4">
            <div class="row justify-content-start mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header fw-bold" style="font-size: 25px;">Saldo</div>
                        <div class="card-body" style="font-size: 15px;">
                            {{ rupiah($saldo) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header fw-bold" style="font-size: 25px;">Nasabah</div>
                        <div class="card-body" style="font-size: 15px;">
                            {{ $nasabah }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header fw-bold" style="font-size: 25px;">Transaksi</div>
                        <div class="card-body" style="font-size: 15px;">
                            {{ $transactions }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col md-8">
            <div class="card">
                <div class="card-header fw-bold" style="font-size: 25px;">Top Up Request</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">

                            @foreach ($request_topup as $request )
                             <form action="{{ route('acceptRequest') }}" method="post">
                            @csrf
                            <input type="hidden" name="wallet_id" value="{{ $request->id }}">
                            <div class="card bg-white shadow-sm border-0 mb-3">
                                <div class="card-header border-0">
                                    {{ $request->user->name }}
                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <div class="col my-auto">
                                        Nominal : {{ rupiah($request->credit) }}
                                    </div>
                                    <div class="col text-end">
                                        <button type="submit" class="btn btn-primary">Accept Request</button>
                                    </div>
                                </div>

                            </div>
                            </form> 

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(Auth::user()->role == 'siswa')
        <div class="col-md-8">
            
            <div class="card mb-3">
                <div class="card-header">Welcome, {{ Auth::user()->name }}</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col d-flex justify-content-start">
                            Saldo: {{ rupiah($saldo) }}
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formTopUp">Top Up</button>
                            <form method="POST" action="{{ route('topupNow') }}">
                                @csrf
                                <div class="modal fade" id="formTopUp" tabindex="-1" aria-labelledby="exmapleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Masukan Nominal</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb3">
                                                    <input type="number" class="form-control" min="10000" name="credit" value="10000">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Top Up Sekarang</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Katalog Produk</div>

                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
                        @foreach ($products as $key => $product)
                        <div class="col">
                            <form method="POST" action="{{ route('addToCart') }}">
                                @csrf
                                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                <input type="hidden" value="{{ $product->price }}" name="price">
                                <div class="card">
                                    <div class="card-header">
                                        {{ $product->name }}
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-center">
                                            <div class="card d-flex justify-content-center align-items-center mb-3" style="height: 150px">
                                                <img width="150px" src="{{ $product->photo }}">
                                            </div>
                                        </div>

                                        <div>{{ $product->description }}</div>

                                        <div>Harga: {{ rupiah($product->price) }}</div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="mb-3">
                                            <input class="form-control" type="number" name="quantity" value="0" min="0">
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Masukan Keranjang</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    Keranjang
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($carts as $key => $cart)
                        <li> {{ $cart->product->name }} | {{ $cart->quantity }} * {{ $cart->price }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer">
                    Total Biaya: {{ $total_biaya }}
                    <form action="{{ route('payNow') }}" method="POST">
                        <div class="d-grid gap-2">
                            @csrf
                            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">Mutasi Wallet</div>
                <div class="card-body">
                    <ul>
                        @foreach ($mutasi as $data)
                        <li>{{ $data->credit ? $data->credit : 'Debit' }} | {{ $data->debit ? $data->debit : 'Kredit' }} | {{ $data->description }}</li>
                        @if ($data->status == 'proses')
                        <span class="badge text-bg-warning">PROSES</span>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    Riwayat Transaksi
                </div>
                <div class="card-body">
                    @foreach ($transactions as $key => $transaction)
                    <div class="row mb-3">
                        <div class="col">
                            <div class="row">
                                <div class="col fw-bold">
                                    {{ $transaction[0]->order_id }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-secondary" style="font-size: 12px">
                                    {{ $transaction[0]->created_at }}
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end align-items-center">
                            <a href="{{ route('download', ['order_id' => $transaction[0]->order_id]) }}" class="btn btn-success" target="_blank">Download</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection