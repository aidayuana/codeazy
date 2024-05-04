<?php

namespace App\Http\Controllers\SekolahCourse;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\SekolahCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = SekolahCourse::with('sekolah', 'course', 'guru.user')->where('sekolah_id', Auth::user()->guru->sekolah_id)->where('guru_id', Auth::user()->guru->id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.guru_course.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SekolahCourse $sekolahCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SekolahCourse $sekolahCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SekolahCourse $sekolahCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SekolahCourse $sekolahCourse)
    {
        //
    }
}
