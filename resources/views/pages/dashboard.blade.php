@extends('layouts.master')
@section('main')
  <div class="title">Dashboard</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Activities</h4>
          </div>
          <div class="card-body">
            <ul class="timeline-xs">
              <li class="timeline-item success">
                <div class="margin-left-15">
                  <div class="text-muted text-small">2 minutes ago</div>
                  <p>
                    <a class="text-info" href=""> Bambang </a>
                    has completed his account.
                  </p>
                </div>
              </li>
              <li class="timeline-item">
                <div class="margin-left-15">
                  <div class="text-muted text-small">12:30</div>
                  <p>Staff Meeting</p>
                </div>
              </li>
              <li class="timeline-item danger">
                <div class="margin-left-15">
                  <div class="text-muted text-small">11:11</div>
                  <p>Completed new layout.</p>
                </div>
              </li>
              <li class="timeline-item info">
                <div class="margin-left-15">
                  <div class="text-muted text-small">Thu, 12 Jun</div>
                  <p>
                    Contacted
                    <a class="text-info" href=""> Microsoft </a>
                    for license upgrades.
                  </p>
                </div>
              </li>
              <li class="timeline-item">
                <div class="margin-left-15">
                  <div class="text-muted text-small">Tue, 10 Jun</div>
                  <p>Started development new site</p>
                </div>
              </li>
              <li class="timeline-item">
                <div class="margin-left-15">
                  <div class="text-muted text-small">Sun, 11 Apr</div>
                  <p>
                    Lunch with
                    <a class="text-info" href=""> Mba Inem </a>
                    .
                  </p>
                </div>
              </li>
              <li class="timeline-item warning">
                <div class="margin-left-15">
                  <div class="text-muted text-small">Wed, 25 Mar</div>
                  <p>server Maintenance.</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
