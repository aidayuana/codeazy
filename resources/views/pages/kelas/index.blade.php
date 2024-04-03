@extends('layouts.master')
@section('main')
  <div class="title">Data Kelas</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>List Data Kelas</h4>
            <a class="btn btn-success" href="{{ route('kelas.create') }}">
              Tambah Kelas
            </a>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kelas</th>
                  @if (Auth::user()->role == 'super_admin')
                    <th>Asal Sekolah</th>
                  @endif
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
        ajax: "{{ route('kelas.index') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
          },
          {
            data: 'nama_kelas',
            name: 'nama_kelas'
          },
          @if (Auth::user()->role == 'super_admin')
            {
              data: 'sekolah.nama',
              name: 'sekolah.nama'
            },
          @endif {
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
