@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1 class="mb-4">Dashboard</h1>

        <div class="row">
            <!-- Simpanan Card -->
            <div class="col-md-6 mb-4">
                <div class="card shadow rounded-3">
                    <div class="card-header bg-primary text-white">
                        Form Simpanan
                    </div>

                    <div class="card-body">
                        <form id="simpanForm" method="post" action="{{ route('simpan-simpanan') }}">
                            @csrf

                            <input type="hidden" name="TxtNominalSimpanan">

                            <div class="mb-3">
                                <label for="no_rekening">Nomor Rekening</label>
                                <input type="text" name="TxtNoRekening" id="no_rekening" class="form-control" required
                                    placeholder="Masukkan NIS">
                                    <div id="result"></div>
                            </div>

                            <div class="mb-3">
                                <label for="nominal_simpanan">Nominal Simpanan (Rp)</label>
                                <input type="text" id="nominal_simpanan" class="form-control currency" autocomplete="off"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan_simpanan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan_simpanan" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mt-4 text-center">
                                <button type="button" class="btn btn-primary btn-sm w-50" onclick="printSimpanan()">
                                    Print & Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Penarikan Card -->
            <div class="col-md-6 mb-4">
                <div class="card shadow rounded-3">
                    <div class="card-header bg-danger text-white">
                        Form Penarikan
                    </div>

                    <div class="card-body">
                        <form id="penarikanForm" method="post" action="{{ route('simpan-penarikan') }}">
                            @csrf

                            <input type="hidden" name="TxtNominalPenarikan">

                            <div class="mb-3">
                                <label for="no_rekening_penarikan">Nomor Rekening</label>
                                <input type="text" name="TxtNoRekeningPenarikan" id="no_rekening_penarikan" class="form-control"
                                    required placeholder="Masukkan NIS">
                                <div id="result2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="nominal_penarikan">Nominal Penarikan (Rp)</label>
                                <input type="text" id="nominal_penarikan" class="form-control currency"
                                    autocomplete="off" required>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan_penarikan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan_penarikan" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mt-4 text-center">
                                <button type="button" class="btn btn-danger btn-sm w-50" onclick="printPenarikan()">Print &
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/script.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@endpush