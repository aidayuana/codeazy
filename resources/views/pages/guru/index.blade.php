@extends('layouts.master')
@section('main')
  <div class="title">Data Guru</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>List Data Guru</h4>
            <a class="btn btn-success" href="{{ route('guru.create') }}">
              Tambah Guru
            </a>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Guru</th>
                  <th>NIP</th>
                  <th>Mata Pelajaran</th>
                  <th>Asal Sekolah</th>
                  <th width="280px">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(function() {
      /*------------------------------------------
      Render DataTable
      --------------------------------------------*/
      const table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('guru.index') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
          },
          {
            data: 'user.name',
            name: 'user.name'
          },
          {
            data: 'nip',
            name: 'nip'
          },
          {
            data: 'mata_pelajaran',
            name: 'mata_pelajaran'
          },
          {
            data: 'sekolah.nama',
            name: 'sekolah.nama'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          },
        ]
      });
    });
  </script>
@endsection
