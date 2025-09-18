<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細 - mogitate</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body>
    <!-- ヘッダー -->
    <header class="header">
        <div class="logo">mogitate</div>
    </header>

    <!-- パンくずナビ -->
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a>
        <span>></span>
        <span>{{ $product->name }}</span>
    </div>

    <!-- メインコンテナ -->
    <div class="detail-container">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="product-form">
            @csrf
            @method('PUT')

            <div class="form-content">
                <!-- 商品画像 -->
                <div class="image-section">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-detail-image" id="preview-image">
                    </div>
                    <div class="file-input-container">
                        <label for="image" class="file-input-label">
                            ファイルを選択
                            <input type="file" name="image" id="image" class="file-input" accept="image/*" onchange="handleFileSelect(event)">
                        </label>
                        <span class="file-name" id="file-name">{{ basename($product->image) }}</span>
                    </div>
                </div>

                <!-- 商品情報 -->
                <div class="info-section">
                    <!-- 商品名 -->
                    <div class="form-group">
                        <label for="name" class="form-label">商品名</label>
                        <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-input" required>
                    </div>

                    <!-- 値段 -->
                    <div class="form-group">
                        <label for="price" class="form-label">値段</label>
                        <input type="text" name="price" id="price" value="{{ $product->price }}" class="form-input" required>
                    </div>

                    <!-- 季節 -->
                    <div class="form-group">
                        <label class="form-label">季節</label>
                        <div class="seasons">
                            @foreach($seasons as $season)
                                <label>
                                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}" 
                                           {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                                    {{ $season->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 商品説明 -->
                <div class="form-group description">
                    <label for="description" class="form-label">商品説明</label>
                    <textarea name="description" id="description" class="form-textarea" rows="6" required>{{ $product->description }}</textarea>
                </div>

                <!-- ボタンエリア -->
                <div class="button-area">
                    <div class="center-buttons">
                        <a href="{{ route('products.index') }}" class="back-button">戻る</a>
                        <button type="submit" class="save-button">変更を保存</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- 削除フォーム -->
        <form method="POST" action="{{ route('products.destroy', $product) }}" class="delete-form-overlay">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
    </div>

    <script>
        /**
         * ファイル選択時の処理
         * 画像プレビューとファイル名表示を更新
         */
        function handleFileSelect(event) {
            const file = event.target.files[0];
            const previewImage = document.getElementById('preview-image');
            const fileNameSpan = document.getElementById('file-name');

            if (file) {
                // 画像プレビュー
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // ファイル名表示
                fileNameSpan.textContent = file.name;
            }
        }
    </script>
</body>
</html>
