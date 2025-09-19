<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録 - mogitate</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
    <!-- ヘッダー -->
    <header class="header">
        <div class="logo">mogitate</div>
    </header>

    <!-- メインコンテナ -->
    <div class="register-container">

        <h1>商品登録</h1>

        <!-- 商品登録フォーム -->
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- 商品名 -->
            <div class="form-group">
                <label for="name" class="form-label required">商品名</label>
                <input type="text" name="name" id="name" placeholder="商品名を入力" value="{{ old('name') }}" class="form-input">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- 値段 -->
            <div class="form-group">
                <label for="price" class="form-label required">値段</label>
                <input type="text" name="price" id="price" placeholder="値段を入力" value="{{ old('price') }}" class="form-input">
                @if($errors->has('price'))
                    @foreach($errors->get('price') as $error)
                        <div class="error-message">{{ $error }}</div>
                    @endforeach
                @endif
            </div>

            <!-- 商品画像 -->
            <div class="form-group">
                <label class="form-label required">商品画像</label>
                <div class="image-section">
                    <div class="product-image-container" id="image-container" style="display: none;">
                        <img src="" alt="商品画像プレビュー" class="product-register-image" id="preview-image">
                    </div>
                    <div class="file-input-container">
                        <label for="image" class="file-input-label">
                            ファイルを選択
                            <input type="file" name="image" id="image" class="file-input" accept="image/*" onchange="handleFileSelect(event)">
                        </label>
                        <span class="file-name" id="file-name">選択されていません</span>
                    </div>
                </div>
                @if($errors->has('image'))
                    @foreach($errors->get('image') as $error)
                        <div class="error-message">{{ $error }}</div>
                    @endforeach
                @endif
            </div>

            <!-- 季節 -->
            <div class="form-group">
                <div class="label-with-description">
                    <label class="form-label required">季節</label>
                    <span class="form-description">複数選択可</span>
                </div>
                <div class="seasons">
                    @foreach($seasons as $season)
                        <label>
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}" 
                                   {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                    @endforeach
                </div>
                @error('seasons')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品説明 -->
            <div class="form-group">
                <label for="description" class="form-label required">商品説明</label>
                <textarea name="description" id="description" placeholder="商品の説明を入力" class="form-textarea" rows="6">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    @foreach($errors->get('description') as $error)
                        <div class="error-message">{{ $error }}</div>
                    @endforeach
                @endif
            </div>

            <!-- ボタンエリア -->
            <div class="button-area">
                <a href="{{ route('products.index') }}" class="back-button">戻る</a>
                <button type="submit" class="register-button">登録</button>
            </div>
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
            const imageContainer = document.getElementById('image-container');
            const fileNameSpan = document.getElementById('file-name');

            if (file) {
                // 画像プレビュー
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imageContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);

                // ファイル名表示
                fileNameSpan.textContent = file.name;
            }
        }
    </script>
</body>
</html>
