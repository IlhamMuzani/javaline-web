<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('id', 'nama_post')->get();
        return view('admin/post.index', compact('posts'));
    }

    public function create()
    {
        return view('admin/post.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_post' => 'required',
            ],
            [
                'nama_post.required' => 'Masukkan nama',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Post::create(array_merge(
            $request->all(),
            [
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));
        return redirect('admin/post-pengurus')->with('success', 'Berhasil menambahkan post');
    }


    public function edit($id)
    {
        $post = Post::where('id', $id)->first();
        return view('admin.post.update', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_post' => 'required',
        ], [
            'nama_post.required' => 'Nama tidak boleh Kosong',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $post = Post::find($id);
        $post->nama_post = $request->nama_post;
        $post->tanggal_awal = Carbon::now('Asia/Jakarta');
        $post->save();
        return redirect('admin/post-pengurus')->with('success', 'Berhasil memperbarui Post');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('admin/post-pengurus')->with('success', 'Berhasil menghapus Post');
    }
}