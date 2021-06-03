<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\kategori;
use App\Task;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pagename='Data Tugas';
        $data = Task::all();
        return view('admin.tugas.index', compact('data', 'pagename'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data_kategori = kategori::all(); //mengimputkan semua data kategori
        $pagename='Form Input Tugas';
        return view('admin.tugas.create', compact('pagename', 'data_kategori')); //memberi view dari admintuags kategri.
                                          //compact adalah formulir 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request); kiriman dari form
        // Untuk melihat dan mengecek isi dari requst dan data_tugas

        // rewuired haru diisi semua
        $request->validate([
            'txtnama_tugas'=>'required',
            'optionid_kategori'=>'required',
            'txtketerangan_tugas'=>'required',
            'radiostatus_tugas'=>'required',
        ]);

        //membuat objek dari sebuah class yang bernama Task
        $data_tugas = new Task([
            
            //data seblum dikirim harus di packing kedalam satu clas, agar pengiriman 
            'nama_tugas'=> $request ->get('txtnama_tugas'),
            'id_kategori'=> $request ->get('optionid_kategori'), 
            'ket_tugas'=> $request ->get('txtketerangan_tugas'),
            'status_tugas'=> $request ->get('radiostatus_tugas'),
        ]);

        //data yang di form sudah masuk kedalam phpmyadmin dan belum bisa menampilkan datanya
        $data_tugas->save();

        // mengarahkan ke admin tugas otomatis mencari index
        return redirect('admin/tugas')->with('sukses', 'tugas berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data_kategori=kategori::all();
        $pagename='Update Tugas';
        $data=Task::Find($id);
        return view('admin.tugas.edit', compact('data', 'pagename', 'data_kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'txtnama_tugas'=>'required',
            'optionid_kategori'=>'required',
            'txtketerangan_tugas'=>'required',
            'radiostatus_tugas'=>'required',
        ]);

            $tugas=Task::find($id);

            $tugas->nama_tugas = $request ->get('txtnama_tugas');
            $tugas->id_kategori = $request ->get('optionid_kategori'); 
            $tugas->ket_tugas = $request ->get('txtketerangan_tugas');
            $tugas->status_tugas = $request ->get('radiostatus_tugas');
       

        $tugas->save();
        return redirect('admin/tugas')->with('sukses', 'tugas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tugas = Task::find($id);
        $tugas->delete();
        return redirect('admin/tugas')->with('sukses', 'tugas berhasil dihapus');
    }
}
