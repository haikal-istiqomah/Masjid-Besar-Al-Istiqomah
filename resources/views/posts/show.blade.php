<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <article>
            <h1>{{ $post->title }}</h1>
            <p class="text-muted">Dipublikasikan pada {{ $post->created_at->format('d F Y') }}</p>
            <hr>
            <div>
                {!! nl2br(e($post->body)) !!}
            </div>
            <a href="/berita" class="btn btn-primary mt-4">Kembali ke Daftar Berita</a>
        </article>
    </div>
</body>
</html>