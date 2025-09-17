<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 商品一覧を表示
     * 検索・ソート機能付き、6件ずつページネーション
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 商品名での検索
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 価格順でのソート
        $sortBy = $request->get('sort', 'default');
        switch ($sortBy) {
            case 'price_ascending':
                $query->orderBy('price', 'asc');
                break;
            case 'price_descending':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
                break;
        }

        // ページネーション（6件ずつ）
        $products = $query->paginate(6);

        return view('products.index', compact('products'));
    }
}
