<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 - mogitate</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
</head>
<body>
    <!-- ヘッダー -->
    <header class="header">
        <div class="logo">mogitate</div>
    </header>

    <!-- メインコンテナ -->
    <div class="container">
        <div class="top-section">
            <h1>
                @if(request('search'))
                    "{{ request('search') }}"の検索結果
                @else
                    商品一覧
                @endif
            </h1>

            <!-- 商品追加ボタン -->
            <a href="{{ route('products.create') }}" class="add-product-button">+ 商品を追加</a>
        </div>

        <div class="bottom-section">
            <!-- サイドバー -->
            <aside class="sidebar">
                <!-- 検索フォーム -->
                <form method="GET" action="{{ route('products.search') }}" class="search-form">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}"> <!-- ソート条件を保持 -->
                    @endif
                    @if(request('page'))
                        <input type="hidden" name="page" value="{{ request('page') }}"> <!-- ページ番号を保持 -->
                    @endif
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="商品名で検索" 
                        value="{{ request('search') }}" 
                        class="search-input"
                    > <!-- 検索キーワードを保持 -->
                    <button type="submit" class="search-button">検索</button>
                </form>

                <!-- ソートセクション -->
                <div class="sort-section">
                    <label class="sort-label">価格順で表示</label>
                    <form method="GET" action="{{ route('products.search') }}" id="sort-form">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}"> <!-- 検索条件を保持 -->
                        @endif
                        @if(request('page'))
                            <input type="hidden" name="page" value="{{ request('page') }}"> <!-- ページ番号を保持 -->
                        @endif
                        <select name="sort" class="sort-select" onchange="document.getElementById('sort-form').submit()">
                            <option value="default">価格で並べ替え</option>
                            <option value="price_descending" {{ request('sort') == 'price_descending' ? 'selected' : '' }}>価格の高い順</option>
                            <option value="price_ascending" {{ request('sort') == 'price_ascending' ? 'selected' : '' }}>価格の安い順</option>
                        </select>
                    </form>

                    <!-- ソート条件タグ表示 -->
                    @if(request('sort') === 'price_descending' || request('sort') === 'price_ascending')
                        <div class="sort-tag">
                            <span class="sort-tag-text">
                                @switch(request('sort'))
                                    @case('price_descending')
                                        高い順に表示
                                        @break
                                    @case('price_ascending')
                                        安い順に表示
                                        @break
                                @endswitch
                            </span>
                        <a href="{{ route('products.search', request()->only(['search', 'page'])) }}" class="sort-tag-remove"> <!-- ソート条件のみリセット -->
                            ×
                        </a>
                        </div>
                    @endif
                </div>
            </aside>

            <!-- メインコンテンツ -->
            <main class="main-content">
                <!-- 商品グリッド -->
                <div class="products-grid">
                    @forelse($products as $product)
                        <a href="{{ route('products.show', array_merge(['product' => $product, 'from' => request()->route()->getName() === 'products.search' ? 'search' : 'list'], request()->only(['search', 'sort', 'page']))) }}" class="product-card-link"> <!-- 検索・ソート・ページ条件を詳細ページに引き継ぎ -->
                            <div class="product-card">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-price">¥{{ number_format($product->price) }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                            商品が見つかりませんでした。
                        </div>
                    @endforelse
                </div>

                <!-- ページネーション -->
                @if($products->hasPages())
                    <div class="pagination">
                        {{-- 前のページへのリンク --}}
                        @if($products->onFirstPage())
                            <span class="disabled">&lt;</span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="page-link">&lt;</a>
                        @endif

                        {{-- ページ番号 --}}
                        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if($page == $products->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- 次のページへのリンク --}}
                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="page-link">&gt;</a>
                        @else
                            <span class="disabled">&gt;</span>
                        @endif
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>