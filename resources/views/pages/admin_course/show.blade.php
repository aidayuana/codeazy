@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('admin.course.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Course {{ $sekolahCourse->course->name }} - {{ $sekolahCourse->sekolah->nama }}</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-column gap-3">
              <div class="form-group">
                <label for="guru_id" class="mb-1 control-label fw-bold">Guru</label>
                <div class="col-sm-12">
                  <span>{{ $sekolahCourse->guru->user->name }}</span>
                </div>
              </div>

              <div class="form-group">
                <label for="course_id" class="mb-1 control-label fw-bold">Course</label>
                <div class="col-sm-12">
                  <span>{{ $sekolahCourse->course->name }}</span>
                </div>
              </div>

              <div class="form-group">
                <label for="deskripsi" class="mb-1 control-label fw-bold">Deskripsi</label>
                <div class="col-sm-12">
                  <span>{{ $sekolahCourse->course->description }}</span>
                </div>
              </div>

              <div class="d-flex flex-column gap-3">
                @foreach ($sekolahCourse->modul as $modul)
                  <div class="row">
                    <div class="form-group col-10">
                      <label for="file[{{ $modul->id }}]" class="mb-2 control-label fw-bold">
                        Modul {{ $modul->sekolahCourse->course->name }} - {{ $modul->nama }}
                      </label>
                      <div class="col-sm-12">
                        <a href="{{ route('modul.download', $modul->id) }}" class="btn btn-primary">Download</a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection
