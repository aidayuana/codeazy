<?php

namespace App\Http\Controllers;

use App\Models\ManualBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class ManualBookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin'])->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('auth')->only(['index', 'download']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $manualBooks = ManualBook::all();
        return view('pages.manualbook.index', compact('roles', 'manualBooks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.manualbook.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:8192'
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            $file = $request->file('file');
            $file_name = date('d-m-Y') . '_' . $file->getClientOriginalName();
            $file_path = $file->storeAs('public/manualbook', $file_name);

            ManualBook::create([
                'nama' => $file_name,
                'file_path' => $file_path,
            ]);

            Alert::success('Success', 'Manual Book berhasil diupload');
            return redirect()->route('manualbook.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManualBook $manualBook)
    {
        return view('pages.manualbook.edit', compact('manualBook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:8192'
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            $manualBook = ManualBook::find($id);
            if ($request->hasFile('file')) {
                if ($manualBook->file_path) {
                    Storage::delete($manualBook->file_path);
                }

                $file = $request->file('file');
                $file_name = date('d-m-Y') . '_' . $file->getClientOriginalName();
                $file_path = $file->storeAs('public/manualbook', $file_name);
                $manualBook->file_path = $file_path;
                $manualBook->nama = $file_name;
            }

            $manualBook->save();
            Alert::success('Success', 'Manual Book berhasil diperbarui');
            return redirect()->route('manualbook.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManualBook $manualBook)
    {
        try {
            if ($manualBook->file_path) {
                Storage::delete($manualBook->file_path);
            }

            $manualBook->delete();
            Alert::success('Success', 'Manual Book berhasil dihapus');
            return redirect()->route('manualbook.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function download($id)
    {
        $manualBook = ManualBook::find($id);
        if (!$manualBook) {
            Alert::error('Error', 'Manual Book tidak ditemukan');
            return redirect()->back();
        }

        return response()->download(storage_path('app/' . $manualBook->file_path));
    }
}
