@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dịch vụ</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Dịch vụ trực tuyến</h5>
                    <p class="card-text">Các dịch vụ công trực tuyến</p>
                    <a href="{{ route('services.online') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection