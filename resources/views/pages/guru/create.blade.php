@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('guru.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Tambah Guru</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Tambah Guru</h4>
          </div>
          <div class="card-body">
            <form method="POST"
              @if (Auth::user()->role == 'super_admin') action="{{ route('guru.store') }}"
            @else
                action="{{ route('admin.guru.store') }}" @endif
              class="form-horizontal d-flex flex-column gap-3">
              @csrf
              <div class="form-group">
                <label for="name" class="mb-1 control-label">Nama Guru</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nama Guru"
                    value="{{ old('name') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="nip" class="mb-1 control-label">NIP</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP"
                    value="{{ old('nip') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="mb-1 control-label">Email</label>
                <div class="col-sm-12">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                    value="{{ old('email') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="mb-1 control-label">Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    value="{{ old('password') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="mb-1 control-label">Konfirmasi Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password" name="password"
                    placeholder="Konfirmasi Password" value="{{ old('password') }}" required />
                </div>
              </div>

              @if (Auth::user()->role == 'super_admin')
                <div class="form-group">
                  <label for="sekolah_id" class="mb-1 control-label">Asal Sekolah</label>
                  <div class="col-sm-12">
                    <select class="form-select" id="sekolah_id" name="sekolah_id" required>
                      <option value="">Pilih Asal Sekolah</option>
                      @foreach ($dataSekolah as $item)
                        <option value="{{ $item->id }}" {{ old('sekolah_id') == $item->id ? 'selected' : '' }}>
                          {{ $item->nama }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @else
                {{-- text readonly current sekolah name and hidden sekolah id --}}
                <input type="hidden" name="sekolah_id" value="{{ Auth::user()->admin->sekolah_id }}">
                <div class="form-group">
                  <label for="sekolah" class="mb-1 control-label">Asal Sekolah</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="sekolah"
                      value="{{ Auth::user()->admin->sekolah->nama }}" readonly />
                  </div>
                </div>
              @endif

              {{-- mata pelajaran --}}
              <div class="form-group">
                <label for="mata_pelajaran" class="mb-1 control-label">Mata Pelajaran</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran"
                    placeholder="Mata Pelajaran" value="{{ old('mata_pelajaran') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="alamat" class="mb-1 control-label">Alamat</label>
                <div class="col-sm-12">
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required>{{ old('alamat') }}</textarea>
                </div>
              </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">
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
