<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Title halaman Index
        $title = 'Category';
        // Mengurutkan data berdasarkan data terbaru
        $category = Category::latest()->paginate(5);
        return view('home.category.index', compact('category', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Category - Create';

        return view('home.category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // Melakukan validasi data
        $this->validate($request, [
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

        if (
            // Melakukan save to database
            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image->hashName()
            ])
        ) {
            // Melakukan return redirect
            return redirect()->route('category.index')
                ->with('success', 'Category Successfully Created');
        } else {
            return redirect()->route('category.create')
                ->with('errors', 'Category Failed to Created');
        }
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
        // Titi\le halaman edit
        $title = 'Category - Edit';

        // get data category by id

        $category = Category::find($id);

        return view('home.category.edit', compact('category', 'title'))
        ;
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
        // melakukan validasi data
        $this->validate($request, [
            'name' => 'required|max:100',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // get data by id
        $category = Category::find($id);

        // jika image kosong tidak di update
        if ($request->file('image')  == '') {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
        } else {
            // jika gambarnya diupdate
            // hapus image lama
            Storage::disk('local')->delete('public/category/' . basename($category->image));

            // upload image baru
            $image = $request->file('image');
            $image->storeAs('public/category/', $image->hashName());

            // Update Data
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image->hashName()
            ]);

        }
        
        return redirect()->route('category.index')
        ->with('success', 'Category Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get data by id
        $category = Category::find($id);

        // delete Image
        // basename itu untuk mengambil nama file
        Storage::disk('local')->delete('public/category/' . basename($category->image));

        // delete data by id
        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category Successfully Deleted');
        
    }
}
