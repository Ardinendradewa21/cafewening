<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="mt-5">
            {{-- di blade tdk bisa memanggil stdClass saja, tapi harus disertai
    memanggil properti nya (mau nampilin apa) contoh: title, description --}}
            <h2 class="text-center">{{ $blog->title }}</h2>
            <div class="body-blog">
                <p>
                    {{ $blog->description }}
                </p>
                <div class="d-flex flex-column align-items-end">
                    <div>{{ $blog->created_at }}</div>
                    <div>by admin</div>
                </div>

            </div>

</body>

</html>
