<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 商品一覧を表示
     */
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->paginate(6);
        return view('products.index', compact('products'));
    }

    /**
     * 商品検索・ソート機能
     */
    public function search(Request $request)
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
        $products = $query->paginate(6)->withPath(route('products.search'))->withQueryString();

        return view('products.index', compact('products'));
    }

    /**
     * 商品登録フォームを表示
     */
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    /**
     * 新しい商品を登録
     */
    public function store(ProductCreateRequest $request)
    {
        // バリデーション済みのデータを取得
        $validatedData = $request->validated();

        $productData = [
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
        ];

        // 画像がアップロードされた場合の処理
        if ($request->hasFile('image')) {
            $productData['image'] = $request->file('image')->store('products', 'public');
        }

        // 商品を作成
        $product = Product::create($productData);

        // 季節の関連付け
        if ($request->has('seasons')) {
            $product->seasons()->attach($validatedData['seasons']);
        }

        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }

    /**
     * 商品詳細を表示
     */
    public function show(Product $product)
    {
        $product->load('seasons');

        $seasons = Season::all();

        return view('products.show', compact('product', 'seasons'));
    }

    /**
     * 商品情報を更新
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        // バリデーション済みのデータを取得
        $validatedData = $request->validated();

        // 商品情報を更新
        $updateData = [
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
        ];

        // 画像がアップロードされた場合の処理
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // 新しい画像を保存
            $updateData['image'] = $request->file('image')->store('products', 'public');
        }

        // 商品情報を更新
        $product->update($updateData);

        // 季節の関連付けを更新
        $product->seasons()->sync($validatedData['seasons']);

        return redirect()->route('products.index')->with('success', '商品情報を更新しました。');
    }

    /**
     * 商品を削除
     */
    public function destroy(Product $product)
    {
        // 関連する画像を削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 季節との関連を削除
        $product->seasons()->detach();

        // 商品を削除
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
