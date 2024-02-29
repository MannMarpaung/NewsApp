<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Melakukan validasi data
        $this -> validate($request, [
            'name' => 'required|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Melakukan upload image
        $image = $request->file('image');
        // Menyimpan image yang diupload ke folder
        // storage/app/public/category
        // fungsi hashName untuk generate nama yang unik
        // fungsi getClientOriginalName itu untuk menggunakan nama asli dari image
        $image->storeAs('public/category', $image->hashName());

        // Melakukan save to database
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $image->hashName()
        ]);

        // Melakukan return redirect
        return redirect()->route('category.index')
            ->with('success', 'Category Berhasil Ditambahkan');

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
