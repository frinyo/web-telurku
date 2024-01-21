@extends('layouts.mainLayout')

@section('body')
    <div>
        <h1>Checkout</h1>
        <hr>

        <div class="row">
            <div class="col-12 col-md-5 order-2 order-md-1">
                <h4 class="mb-4">Detail Pemesanan</h4>
                <form action="{{ route('Checkout.Order') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="inputProvince" class="form-label">Provinsi</label>
                        <input required type="text" name="province" class="form-control shadow-sm" id="inputProvince"
                            placeholder="contoh: Jawa Timur">
                    </div>
                    <div class="mb-3">
                        <label for="inputCity" class="form-label">Kota</label>
                        <input required type="text" name="city" class="form-control shadow-sm" id="inputCity"
                            placeholder="contoh: Kediri">
                    </div>
                    <div class="mb-3">
                        <label for="inputPostalCode" class="form-label">Kode Pos</label>
                        <input required type="text" name="postal_code" class="form-control shadow-sm"
                            id="inputPostalCode" placeholder="contoh: 64116">
                    </div>
                    <div class="mb-3">
                        <label for="inputAddress" class="form-label">Alamat lengkap</label>
                        <textarea required name="address" class="form-control shadow-sm" id="inputAddress" rows="4"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Checkout</button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-7 order-1 order-md-2">
                <h5 class="mb-3">{{ count($cart_items) }} item</h5>
                @foreach ($cart_items as $item)
                    <div class="card p-2 mb-3 w-100" id="cardId{{ $item->id }}">
                        <div class="row">
                            <div class="col-6 col-md-5">
                                <div class="d-flex gap-3">
                                    <div style="height: 90px; width: 90px; flex-shrink: 0">
                                        <img src="{{ asset('img/egg-default.jpg') }}" alt="" class="w-100 h-100"
                                            style="object-fit: contain; background-color: rgb(223, 223, 223)">
                                    </div>
                                    <div>
                                        <h5 class="mb-2">{{ $item->product->name }}</h5>
                                        <p class="badge bg-secondary mb-0">{{ $item->quantity }} kg</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-7">
                                <div class="d-flex gap-3 justify-content-end">
                                    <div>
                                        <p class="mb-1">Harga</p>
                                        <p class="fw-bold" style="font-size: 18px; color: rgb(39, 163, 111)"">Rp
                                            {{ number_format($item->total_price, 0, '', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="me-2 d-flex justify-content-end">
                    <h5>Total: Rp {{ number_format($cart_items->sum('total_price'), 0, '', '.') }}</h5>
                </div>
            </div>
        </div>

    </div>
@endsection
