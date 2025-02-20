@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tra cứu hồ sơ</h1>
    <div class="row">
        <div class="col-md-12">
            <form>
                <div class="form-group">
                    <label for="profileSearch">Nhập thông tin tra cứu</label>
                    <input type="text" class="form-control" id="profileSearch" placeholder="Nhập mã hồ sơ hoặc thông tin liên quan">
                </div>
                <button type="submit" class="btn btn-primary">Tra cứu</button>
            </form>
        </div>
    </div>
</div>
@endsection