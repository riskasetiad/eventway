@extends('layouts.admin.template')

@section('content')
    <div class="row p-4">
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3 fw-semibold">Event Saya</p>
                    <h4 class="mb-3">{{ $jumlahEvent }}</h4>
                    <i class="mdi mdi-calendar-multiselect fs-30 text-primary float-end"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3 fw-semibold">Tiket Terjual</p>
                    <h4 class="mb-3">{{ $statistikPenjualan['event_terjual'] }}</h4>
                    <i class="mdi mdi-ticket fs-30 text-success float-end"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3 fw-semibold">Total Pendapatan</p>
                    <h4 class="mb-3">Rp{{ number_format($statistikPenjualan['total_pendapatan'], 0, ',', '.') }}</h4>
                    <i class="mdi mdi-cash fs-30 text-warning float-end"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
