<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    function index(Request $request)
    {
        // Cara Pake Query Builder
        // $title = $request->title;
        // $blogs = DB::table('blogs')->where('title', 'LIKE', '%' . $title . '%')->orderBy('id', 'desc')->paginate(10);

        // return view('blog', ['blogs' => $blogs, 'title' => $title]);

        // cara pake eloquent, eloquent itu memudahkan dari laravel
        $title = $request->title;
        $blogs = Blog::where('title', 'LIKE', '%' . $title . '%')->withTrashed()->orderBy('id', 'desc')->paginate(10);
        return view('blog', ['blogs' => $blogs, 'title' => $title]);
    }

    function add()
    {
        return view('blog-add');
    }

    function create(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:blogs|max:255',
            'keterangan' => 'required',
        ]);

        // DB::table('blogs')->insert([
        //     'title' => $request->title,
        //     'description' => $request->description
        // ]);

        // kalo kita menggunakan eloquent, kita ga perlu capek" ketik 1" seperti di query builder
        // ada syarat pakenya
        // 1. Variable yg dikirim dari user harus sama dengan kolom di table, kalo sama maka kita bisa
        // memakai mass assignment
        Blog::create($request->all());

        // cara yg tidak memaka eloquent
        // $blog = new Blog;a
        // $blog->title = $request->title;
        // $blog->description = $request->keterangan;
        // $blog->save();

        // cara yg tidak memakai eloquent
        // Blog::create([
        //     'title' => $request->title,
        //     'description' => $request->keterangan
        // ]);

        Session::flash('message', 'New Blog Berhasil Ditambahkan');

        return redirect()->route('blog');
    }

    function show($id)
    {
        // menampilkan detail data hanya 1 saja
        // $blog = DB::table('blogs')->where('id', $id)->first();

        // findOrFail = dia otomatis ngereturn data error kemudian melempar ke halaman 404 not found
        // syaratnya = melakukan pencarian dari primary key nya
        $blog = Blog::findOrFail($id);
        // if (!$blog) {
        //     abort(404);
        // }
        // menuju halaman detail kemudian membawa data blog ke file detail-blog
        return view('blog-detail', ['blog' => $blog]);
    }

    function edit($id)
    {
        // $blog = DB::table('blogs')->where('id', $id)->first();
        $blog = Blog::findOrFail($id);
        // if (!$blog) {
        //     abort(404);
        // }
        return view('blog-edit', ['blog' => $blog]);
    }
    // gunanya (Request $request) -> menerima inputan user
    function update(Request $request, $id)
    {
        // untuk ngecek berhasil atau tidak inputan usernya
        // return $request->all();
        $request->validate([
            // ini gunanya supaya ignore id dari blog yg diedit, jadi
            // walaupun title atau description tidk di edit bisa disave
            'title' => 'required|unique:blogs,title,' . $id . '|max:255',
            'description' => 'required',
        ]);

        // DB::table('blogs')->where('id', $id)->update([
        //     'title' => $request->title,
        //     'description' => $request->description
        // ]);
        $blog = Blog::findOrFail($id);
        $blog->update($request->all());
        //memunculkan message ketika berhasil
        Session::flash('message', 'Blog Berhasil DiUpdate');
        //ngedirect ke halaman blog
        return redirect()->route('blog');
    }

    function delete($id)
    {
        // cara kalo memakai Query Builder
        // $blog = DB::table('blogs')->where('id', $id)->delete();

        // cara delete dengan eloquent
        // buat menghindari orang iseng memasuki id asal"an agar lngsng ditendang ke 404 not found
        Blog::findOrFail($id)->delete();

        Session::flash('message', 'Blog Berhasil Delete');
        return redirect()->route('blog');
    }

    function restore($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id)->restore();
    }
}
