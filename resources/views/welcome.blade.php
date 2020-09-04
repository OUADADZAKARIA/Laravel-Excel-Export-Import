<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="container mt-5">
            <div class="row mt-5">
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-header text-white bg-dark">
                            Laravel - Excel Export
                        </div>
                        <div class="m-5">
                            <a href="/users/export">Exporter</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{session('status')}}
                        </div>
                        @endif


                        @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                            {{$error}}
                            @endforeach
                        </div>
                        @endif


                        @if (session()->has('failures'))
                        <div class="alert alert-danger" role="alert">
                            @foreach (session()->get('failures') as $validation)
                            <ul>
                                <li>ligne : {{$validation->row()}} | column : {{$validation->attribute()}}
                                    <ul>
                                        @foreach ($validation->errors() as $error)
                                        <li>{{$validation->values()[$validation->attribute()]}} : {{$error}}</li>
                                        @endforeach
                                    </ul>
                                </li>


                            </ul>
                            @endforeach
                        </div>
                        @endif

                        <div class="card-header">
                            Laravel - Excel Import
                        </div>
                        <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group p-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="inputGroupFile01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                            <br>
                            <div class="text-center my-2">
                                <button class="btn btn-info">Importer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</body>

</html>