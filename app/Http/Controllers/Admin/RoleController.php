<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagename='Role';
        $role_permission=Role::with('permissions')->get();
        return view('admin.role.index', compact('pagename', 'role_permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pagename='Tambah Role'; 
        //siapkan pagename tambah role
        $allPermission=Permission::all();
        //data semua role dikirim dari kontroller all permision diterima ke create.blade.php
        return view('admin.role.create', compact('pagename', 'allPermission')); 
        //mengembalikan view pada bagian admin.role.create sertakan data pagename dan allPermission
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'txtnama_role'=>'required',
            'optionid_permission'=>'required|array',
            'permission.*'=>'required|string',
        ],[
            'textname_role.required' => "nama role harus diisi",
            //pesan eror pada role
            'permission.required' => "anda harus memilih permission",
            'permission.*.required' => "anda harus memilih permission"
            //pesan eror pada permission
        ]);

        $role=Role::create(['name'=>$request->input('txtnama_role')]);
        // name ambil dari request //akan tambah ke tabel
        $role->syncPermissions($request->input('optionid_permission'));
        // hasil input pada permission
        
        return redirect()->action('Admin\RoleController@index')->with('sukses','Role berhasil dibuat');
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
    }
}
