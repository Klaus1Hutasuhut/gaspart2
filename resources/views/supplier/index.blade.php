@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Manajemen Data Karyawan</h3>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url('/supplier/new') }}" class="btn btn-primary btn-sm float-right">Tambah Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {!! session('success') !!}
                            </div>
                        @endif
                <table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Kode</th>           
            <th>Nama</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Email</th>
            <th colspan="2">Aksi</th> <!-- MODIFIKASI INI DENGAN MENAMBAHKAN COLSPAN -->
        </tr>
    </thead>
    <tbody>
        @forelse($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->id }}</td>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->phone }}</td>
            <td>{{ str_limit($supplier->address, 50) }}</td>
            <td><a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a></td>
            <td>
                <form action="{{ url('/supplier/' . $supplier->id) }}" method="POST">
                {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE" class="form-control">
                    <a href="{{ url('/supplier/' . $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
            
            <!-- [... TAMBAHKAN FORM INI ...] -->
            <!-- KARENA YANG DIBUTUHKAN METHOD POST MAKA KITA MEMASUKKANNYA KEDALAM FORM -->
            <td>
                <form action="{{ route('invoice.store') }}" method="post">
                {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $supplier->id }}" class="form-control">
                    <button class="btn btn-primary btn-sm">Buat Invoice</button>
                </form>
            </td>
            <!-- [... TAMBAHKAN FORM INI ...] -->
        </tr>
        @empty
        <tr>
            <td class="text-center" colspan="5">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
                        <div class="float-right">
                            {{ $suppliers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection