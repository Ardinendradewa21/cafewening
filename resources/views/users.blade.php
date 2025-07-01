<!DOCTYPE html>
<html lang="en">

<head>
    {{-- ${product.icon} --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Akun Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="mt-5">
            <h1 class="text-center">Akun Pengguna</h1>
            <div class="table-responsive mt-5">
                {{-- <a href="{{ url('/blog/add') }}" class="btn btn-primary mb-3">Add New</a> --}}

                {{-- Jika ada session yang namanya meesage
                tampilin paragraf ada class boothstrap jika berhasil muncul 'new blog berhasil ditambahka'
                dibagian  file BlogController --}}


                {{-- <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="title" value="{{ $title }}" class="form-control"
                            placeholder="Search Title" aria-label="Search Title" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </div>

                </form> --}}

                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                    </thead>
                    <tbody class="table-group-divider">
                        @if ($users->count() == 0)
                            <tr>
                                <td colspan="3" class="text-center">No Data Found with
                                    <strong>{{ $title }}</strong> Keyword
                                </td>
                            </tr>
                        @endif
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
