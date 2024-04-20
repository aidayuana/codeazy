@extends('layouts.master')
@section('main')
  <div class="title">Dashboard</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body d-flex flex-column gap-3">
            <div class="d-flex gap-3">
              <h6 class="my-auto">Nama</h6>
              <span class="my-auto">
                {{ $user->name }}
              </span>
            </div>
            <div class="d-flex gap-3">
              <h6 class="my-auto">Email</h6>
              <span class="my-auto">
                {{ $user->email }}
              </span>
            </div>
            <div class="d-flex gap-3">
              <h6 class="my-auto">Role</h6>
              <span class="my-auto text-uppercase">
                {{ $user->role }}
              </span>
            </div>
            <hr class="my-0">
            <div class="d-flex gap-3">
              <h6 class="my-auto">Asal Sekolah</h6>
              <span class="my-auto">
                {{ $dataUser->sekolah->nama }}
              </span>
            </div>
            <div class="d-flex gap-3">
              <h6 class="my-auto">NIP</h6>
              <span class="my-auto">
                {{ $dataUser->nip }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
