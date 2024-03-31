<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Guru::with(['user', 'sekolah'])->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.guru.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.guru.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSekolah = Sekolah::get();
        return view('pages.guru.create', compact('dataSekolah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'alamat' => 'required',
            'mata_pelajaran' => 'required',
            'nip' => 'required|unique:guru,nip',
            'id_sekolah' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'guru',
            ]);

            if ($user) {
                Guru::create([
                    'id_user' => $user->id,
                    'id_sekolah' => $request->id_sekolah,
                    'nip' => $request->nip,
                    'alamat' => $request->alamat,
                    'mata_pelajaran' => $request->mata_pelajaran,
                ]);
                Alert::toast('Data guru berhasil ditambahkan!', 'success');
                return redirect()->route('guru.index');
            } else {
                $user->delete();
                Alert::toast('Data guru gagal ditambahkan!', 'error');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $dataSekolah = Sekolah::with('guru')->get();
        return view('pages.guru.show', compact('guru', 'dataSekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        $dataSekolah = Sekolah::with('guru')->get();
        return view('pages.guru.edit', compact('guru', 'dataSekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nip' => 'required|unique:guru,nip,' . $guru->id,
            'sekolah_id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $guru->update($request->all());
            Alert::toast('Data guru berhasil diubah!', 'success');
            return redirect()->route('guru.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        try {
            $guru->delete();
            Alert::toast('Data guru berhasil dihapus!', 'success');
            return redirect()->route('guru.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
