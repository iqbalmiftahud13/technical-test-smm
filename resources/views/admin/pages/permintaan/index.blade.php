@extends('layouts.master')

@section('title')
    Permintaan Barang
@endsection

@section('css')
    <!-- bootstrap-datepicker css -->
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
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
            Permintaan Barang
        @endslot
    @endcomponent

    <div id="vue">
        <div class="text-sm-end">
            <button type="button" data-bs-toggle="modal" data-bs-target="#reqItemModal"
                class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2">
                <i class="mdi mdi-plus me-1"></i> Tambah
            </button>
        </div>

        <div class="card px-3 py-3 shadow p-3 mb-5 bg-white rounded-4">
            <table class="table table-bordered" id="reqItem-datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Department</th>
                        <th>Tanggal Permintaan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="reqItemModal" tabindex="1" aria-labelledby="reqItemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reqItemModalLabel">Tambah Permintaan Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" class="needs-validation createContact-form" id="reqItem-form"
                            @submit.prevent="handleCreateData()">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK Peminta</label>
                                        <v-select id="nik" name="nik" :options="departments" label="nik"
                                            placeholder="Masukan NIK Peminta" v-model="selectedDepartment"
                                            @option:selected="onSelectDeparment">
                                            {{-- <template #search="{attributes, events}">
                                                <input class="vs__search" :required="!selected" v-bind="attributes"
                                                    v-on="events" />
                                            </template> --}}
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input v-model="formRequest.name" type="text" id="name" class="form-control"
                                            placeholder="Masukan Nama Peminta" required disabled />
                                        <div class="invalid-feedback">Kolom wajib diisi.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <input v-model="formRequest.department" type="text" id="department"
                                            class="form-control" placeholder="Masukan Department Peminta" required
                                            disabled />
                                        <div class="invalid-feedback">Kolom wajib diisi.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="mb-3">
                                        <label for="tglPermintaan" class="form-label">Tanggal Permintaan</label>
                                        <div class="position-relative">
                                            <div id="tglPermintaan">
                                                <input v-model="formRequest.date_request" type="date"
                                                    class="form-control" placeholder="Pilih Tanggal" required>
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
                                                <th scope="col" class="text-center">
                                                    <button type="button" class="btn btn-lg" @click="addRow()">
                                                        <i class='bx bx-plus-circle text-success fs-4'></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in formRequest.details">
                                                <th scope="row">@{{ index + 1 }}</th>
                                                <td>
                                                    <v-select id="barang" name="barang" :options="barang"
                                                        label="barang" v-model="formRequest.details[index].selectedBarang"
                                                        style="min-width: 150px"
                                                        @option:selected="onSelectBarang($event, index)" required />
                                                </td>
                                                <td>
                                                    <input v-model="formRequest.details[index].lokasi" type="text"
                                                        id="lokasi" class="form-control" placeholder="-" required
                                                        disabled />
                                                </td>
                                                <td>
                                                    <input v-model="formRequest.details[index].stok" type="text"
                                                        id="stok" class="form-control" placeholder="-" required
                                                        disabled />
                                                </td>
                                                <td>
                                                    <input v-model="formRequest.details[index].qty" type="text"
                                                        id="qty" class="form-control" placeholder="" required
                                                        @input="onInputQty($event, index)" />
                                                </td>
                                                <td>
                                                    <input v-model="formRequest.details[index].satuan" type="text"
                                                        id="satuan" class="form-control" placeholder="-" required
                                                        disabled />
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2">
                                                        <button class="btn btn-lg" @click="removeRow(index)">
                                                            <i class='bx bx-trash text-danger fs-4'></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" id="btnSubmit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end modal body -->
                </div>
                <!-- end modal-content -->
            </div>
            <!-- end modal-dialog -->
        </div>
        <!-- end Modal -->
    </div>
@endsection
@section('script')
    <!-- bootstrap-datepicker js -->
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/vue-select@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
    <script type="text/javascript">
        $(function() {

            var table = $('#reqItem-datatable').DataTable({
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
                        data: 'date_request',
                        name: 'date_request',
                    },
                    {
                        data: 'id',
                        render: renderAction,
                    },
                ]
            });

            function renderAction(data, type, row, meta) {
                let url = "{{ route('permintaan.destroy', ':id') }}"
                let urlDetail = "{{ route('permintaan.show', ':id') }}"
                url = url.replace(':id', data)
                urlDetail = urlDetail.replace(':id', data)
                console.log(url)
                let btn =
                    `<a href="${urlDetail}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> <button class="delete btn btn-danger btnDeleteDt btn-sm" data-url="${url}"><i class="fa fa-trash"></i></button>`
                return btn
            }
        });

        $('#reqItem-form').submit(function(e) {
            console.log('here');
            e.preventDefault()
            handleCreateData()
        })
        var vue = new Vue({
            el: '#vue',
            components: {
                'v-select': VueSelect.VueSelect
            },
            data() {
                return {
                    departments: @json($department),
                    barang: @json($barang),
                    selectedDepartment: null,
                    formRequest: {
                        nik: '',
                        name: '',
                        department: '',
                        date_request: '',
                        details: [{
                            id_barang: null,
                            barang: null,
                            lokasi: null,
                            stok: null,
                            satuan: null,
                            qty: null,
                            selectedBarang: null,
                        }],
                    }
                }
            },
            methods: {
                addRow() {
                    this.formRequest.details.push({
                        id_barang: null,
                        barang: null,
                        lokasi: null,
                        stok: null,
                        satuan: null,
                        qty: null,
                        selectedBarang: null,
                    })
                },
                resetForm() {
                    this.formRequest = {
                        nik: '',
                        name: '',
                        department: '',
                        date_request: '',
                        details: [{
                            id_barang: null,
                            barang: null,
                            lokasi: null,
                            stok: null,
                            satuan: null,
                            qty: null,
                            selectedBarang: null,
                        }],
                    }
                    this.selectedDepartment = null
                },
                handleCreateData() {
                    $('button').prop('disabled', true)
                    let btnText = $('#btnSubmit').html()
                    $('#btnSubmit').html('<i class="fa fa-spinner fa-spin" ></i> Loading')

                    $.ajax({
                        type: "POST",
                        url: "{{ route('permintaan.store') }}",
                        data: this.formRequest,
                        success: function(res) {
                            $('#reqItemModal').modal('hide')
                            $('#btnSubmit').html(btnText)
                            vue.resetForm()
                            $('#reqItem-datatable').DataTable().ajax.reload()
                            $('button').prop('disabled', false)
                        },
                        error: function(err) {
                            $('#btnSubmit').html(btnText)
                            $('button').prop('disabled', false)
                        }
                    });
                },
                removeRow(idx) {
                    this.formRequest.details.splice(idx, 1)
                },
                onInputQty(e, idx) {
                    if (parseInt(e.target.value) > parseInt(this.formRequest.details[idx].stok)) {
                        this.formRequest.details[idx].qty = this.formRequest.details[idx].stok
                    } else {
                        this.formRequest.details[idx].qty = e.target.value
                    }
                },
                onSelectDeparment(input) {
                    if (input) {
                        this.formRequest.nik = input.nik
                        this.formRequest.name = input.name
                        this.formRequest.department = input.department
                    }
                },
                onSelectBarang(input, idx) {
                    if (input) {
                        this.formRequest.details[idx].id_barang = input.id
                        this.formRequest.details[idx].lokasi = input.lokasi
                        this.formRequest.details[idx].stok = input.stok
                        this.formRequest.details[idx].satuan = input.satuan
                        this.formRequest.details[idx].barang = input.barang
                    }
                }
            }
        })
    </script>
@endsection
