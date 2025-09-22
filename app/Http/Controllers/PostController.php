<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
{
    // 1. Ambil semua data dari tabel posts
    $posts = Post::all();

    // 2. Kirim data ke view dan tampilkan
    return view('posts.index', ['posts' => $posts]);
}

    public function show(Post $post)
{
    // Laravel secara otomatis akan mencari Post berdasarkan ID dari URL
    // Ini disebut "Route Model Binding"

    return view('posts.show', ['post' => $post]);
}
}
