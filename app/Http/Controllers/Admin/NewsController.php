<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // title halaman index
        $title = 'News - Index';

        // get data terbaru dari table news/ dari model News
        $news = News::latest()->paginate(5);
        $category = Category::all();

        // Compact berfungsi mengirim data ke view yang diambil dari variable di atas
        return view('home.news.index', compact('title', 'news', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // title halaman create
        $title = 'News - Create';

        // model category
        $category = Category::all();

        // Compact berfungsi mengirim data ke view
        return view('home.news.create', compact('title', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $this->validate($request,[
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'content' => 'required',
            'category_id' => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        // fungsi untuk menyimpan image ke dalam folder public/news
        // fungsi hashName() berfungsi untuk memberikan nama acak pada image
        $image->storeAs('public/news', $image->hashName());

        // create data ke dalam table news
        News::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'image' => $image->hashName(),
            'content' => $request->content
        ]);

        return redirect()->route('news.index');
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
