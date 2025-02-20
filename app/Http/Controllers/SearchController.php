<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return redirect()->route('home')->with('error', 'Vui lòng nhập từ khóa tìm kiếm');
        }

        $posts = Post::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->with('category')
            ->paginate(10);

        return view('search.results', [
            'posts' => $posts,
            'query' => $query
        ]);
    }
}