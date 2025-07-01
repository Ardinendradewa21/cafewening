<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="mt-5">
            <h1 class="text-center">Akun Pengguna</h1>
            <div class="table-responsive mt-5">
                <a href="{{ url('/blog/add') }}" class="btn btn-primary mb-3">Add New</a>

                {{-- Jika ada session yang namanya meesage
                tampilin paragraf ada class boothstrap jika berhasil muncul 'new blog berhasil ditambahka'
                dibagian  file BlogController --}}
                @if (Session::has('message'))
                    <p class="alert alert-success">{{ Session::get('message') }}</p>
                @endif

                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="title" value="{{ $title }}" class="form-control"
                            placeholder="Search Title" aria-label="Search Title" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </div>

                </form>

                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Title</th>

                    </thead>
                    <tbody class="table-group-divider">
                        @if ($blogs->count() == 0)
                            <tr>
                                <td colspan="3" class="text-center">No Data Found with
                                    <strong>{{ $title }}</strong> Keyword
                                </td>
                            </tr>
                        @endif
                        @foreach ($blogs as $blog)
                            <tr>
                                <td>{{ ($blogs->currentpage() - 1) * $blogs->perpage() + $loop->index + 1 }}</td>
                                <td>{{ $blog->title }}</td>
                                <td><a href="{{ url('blog/' . $blog->id . '/detail') }}">view</a> | <a
                                        href="{{ url('blog/' . $blog->id . '/edit') }}">edit</a> | <a
                                        href="{{ url('blog/' . $blog->id . '/delete') }}">delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $blogs->links() }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
