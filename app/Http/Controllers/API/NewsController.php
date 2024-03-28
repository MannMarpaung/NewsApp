<?php

namespace App\Http\Controllers\API;

use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{

    public function index()
    {
        try {
            $news = News::latest()->get();
            return ResponseFormatter::success(
                $news,
                'Data list of news'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function show($id)
    {
        try {
            // get data by id
            $news = News::findOrFail($id);
            return ResponseFormatter::success(
                $news,
                'Data news by id'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function store(Request $request)
    {

        try {
            // validate
            $this->validate($request, [
                'title' => 'required',
                'category_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'content' => 'required',
            ]);

            // upload image
            $image = $request->file('image');
            $image->storeAs('public/news', $image->hashName());

            // create data
            $news = News::create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->title, '-'),
                'image' => $image->hashName(),
                'content' => $request->content
            ]);

            return ResponseFormatter::success(
                $news,
                'Data news has been created'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function destroy($id)
    {
        try {
            //get data by id
            $news = News::findOrFail($id);

            // delete image
            Storage::disk('local')->delete('public/news/' . basename($news->image));

            // delete data
            $news->delete();

            return ResponseFormatter::success(
                $news,
                'Data news has been deleted'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            //validate
            $this->validate($request, [
                'title' => 'required|max:255',
                'category_id' => 'required',
                'content' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);

            // Get data by id
            $news = News::findOrFail($id);

            // jika tidak ada image yang diupload
            if ($request->file('image') == '') {
                // update data
                $news->update([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'slug' => Str::slug($request->title, '-'),
                    'content' => $request->content
                ]);
            } else {
                // hapus old image
                Storage::disk('local')->delete('public/news/' . basename($news->image));

                // upload new image
                $image = $request->file('image');
                $image->storeAs('public/news', $image->hashName());

                // upload data
                $news->update([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'slug' => Str::slug($request->title, '-'),
                    'image' => $image->hashName(),
                    'content' => $request->content
                ]);
            }

            return ResponseFormatter::success(
                $news,
                'Data news has been updated'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }
}
