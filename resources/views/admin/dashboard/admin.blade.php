@extends('layouts.admin.template')

@section('content')
   <div class="row p-4">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-3 fw-semibold">Total Penyelenggara</p>
                <h4 class="mb-3">{{ $penyelenggara }}</h4>
                <i class="mdi mdi-account-group fs-30 text-primary float-end"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-3 fw-semibold">Event Berlangsung</p>
                <h4 class="mb-3">{{ $eventBerlangsung }}</h4>
                <i class="mdi mdi-calendar-clock fs-30 text-success float-end"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-3 fw-semibold">Event Selesai</p>
                <h4 class="mb-3">{{ $eventSelesai }}</h4>
                <i class="mdi mdi-calendar-check fs-30 text-warning float-end"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-3 fw-semibold">Tiket Terjual</p>
                <h4 class="mb-3">{{ $statistik['event_terjual'] }}</h4>
                <i class="mdi mdi-ticket-confirmation fs-30 text-danger float-end"></i>
            </div>
        </div>
    </div>
</div>

@endsection
