@extends('layouts.master')

@section('title', 'Manual Books')

@section('content')
<div class="container">
    <h1>Manual Books</h1>
    @if($manualBooks->isEmpty())
        <p>No manual books found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($manualBooks as $manualBook)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $manualBook->nama }}</td>
                        <td>
                            <a href="{{ route('manualbook.download', $manualBook->id) }}" class="btn btn-primary">Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
