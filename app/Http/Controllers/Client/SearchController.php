<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
    public function searchKey(Request $request)
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        $keyword = $request->input('keyword');
        $product1 = Book::where('title_book', 'like', '%' . $keyword . '%')->paginate(10);
        $products = $product1 = Book::where('title_book', 'like', '%' . $keyword . '%')->paginate(10);
        // Tính toán số lượng sản phẩm cho mỗi category
        $categoryCounts = [];
        foreach ($cate as $cat) {
            $productCount = Book::where('id_cate', $cat->id)->count();
            $categoryCounts[$cat->id] = $productCount;
        }
        // Tính toán số lượng sản phẩm cho mỗi author
        $authorCounts = [];
        foreach ($auth as $au) {
            $productCount = Book::where('id_author', $au->id)->count();
            $authorCounts[$au->id] = $productCount;
        }
        // Tính toán số lượng sản phẩm cho mỗi nxb
        $publisherCounts = [];
        foreach ($publishers as $au) {
            $productCount = Book::where('id_publisher', $au->id)->count();
            $publisherCounts[$au->id] = $productCount;
        }

        return view('client.books.filter', compact('publisherCounts','publishers','cate', 'products', 'product1', 'auth', 'categoryCounts', 'authorCounts'));
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}