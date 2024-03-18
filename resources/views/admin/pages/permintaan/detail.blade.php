@extends('layouts.master')

@section('title')
    Detail Permintaan Barang
@endsection

@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Permintaan Barang
        @endslot
        @slot('title')
            Detail
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="mb-3">
                <label for="nik" class="form-label">NIK Peminta</label>
                <input type="text" id="nik" class="form-control" placeholder="Masukan Nama Peminta" required
                    disabled value="{{ $data->nik }}" />
                <div class="invalid-feedback">Kolom wajib diisi.</div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" class="form-control" placeholder="Masukan Nama Peminta" required
                    disabled value="{{ $data->name }}" />
                <div class="invalid-feedback">Kolom wajib diisi.</div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" id="department" class="form-control" placeholder="Masukan Department Peminta" required
                    disabled value="{{ $data->department }}" />
                <div class="invalid-feedback">Kolom wajib diisi.</div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="mb-3">
                <label for="tglPermintaan" class="form-label">Tanggal Permintaan</label>
                <div class="position-relative">
                    <div id="tglPermintaan">
                        <input type="text" class="form-control" placeholder="Pilih Tanggal" required disabled
                            value="{{ $data->date_request }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-5">
            <h5>Daftar Barang</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Barang</th>
                        <th scope="col" class="text-center">Lokasi</th>
                        <th scope="col" class="text-center">Tersedia</th>
                        <th scope="col" class="text-center">Qty</th>
                        <th scope="col" class="text-center">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->requestItemDetails as $detail)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $detail->barang }}</td>
                            <td>{{ $detail->lokasi }}</td>
                            <td>{{ $detail->stok }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ $detail->satuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end mt-5">
        <a href="{{ route('permintaan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('#department-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [{
                        data: null,
                        width: '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'department',
                        name: 'department',
                    },
                    {
                        data: 'id',
                        render: renderAction,
                    },
                ]
            });

            function renderAction(data, type, row, meta) {
                let url = "{{ route('department.destroy', ':id') }}"
                url = url.replace(':id', data)
                console.log(url)
                let btn =
                    `<button class="delete btn btn-danger btnDeleteDt btn-sm" data-url="${url}"><i class="fa fa-trash"></i></button>`
                return btn
            }
        });

        function handleCreateData() {
            $('button').prop('disabled', true)
            let btnText = $('#btnSubmit').html()
            $('#btnSubmit').html('<i class="fa fa-spinner fa-spin" ></i> Loading')

            let formData = new FormData($('#department-form')[0])
            $.ajax({
                type: "POST",
                url: "{{ route('department.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#departmentModal').modal('hide')
                    $('#btnSubmit').html(btnText)
                    $('#department-form')[0].reset()
                    $('#department-datatable').DataTable().ajax.reload()
                    $('button').prop('disabled', false)
                },
                error: function(err) {
                    $('#btnSubmit').html(btnText)
                    $('button').prop('disabled', false)
                }
            });
        }
        $('#department-form').submit(function(e) {
            console.log('here');
            e.preventDefault()
            handleCreateData()
        })
    </script>
@endsection
