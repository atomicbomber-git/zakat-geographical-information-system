<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="gcp-api-key" content="{{ config('app.gcp_api_key') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head')
</head>
<body>
    <div>
        <div style="min-height: 90vh">
            @unless($dont_show_navbar ?? false)
                @include('shared.navbar')
            @endunless

            @if(!($dont_show_auth_info ?? false))
                @auth
                    <div class="container my-3">
                        @include("shared.auth-info")
                    </div>
                @endauth
            @endif

            @yield('content')
        </div>

        <div>
            @yield("pre-footer")
            <footer class="bg-dark text-light">
                <div class="container py-3">
                    <div class="row">
                        <div class="col-md-7">
                            <p>
                                KANTOR BAZNAS KOTA PONTIANAK <br/>
                                Jl. Nirbaya / Kota Baru, Pontianak Selatan (78121) <br/>
                            </p>
                        </div>
                        <div class="col-md-5">
                            TEL / WA: 081258790040 <br/>
                            FAX: 056118182401 <br/>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')

    <script>
        $(document).ready(function() {

            $("form.form-delete").submit(function(e) {
                e.preventDefault()

                let form = this

                swal("Apakah Anda yakin ingin menghapus data ini?", {
                    dangerMode: true,
                    icon: "warning",
                    buttons: {
                        cancel: "Tidak",
                        confirm: "Ya"
                    },
                })
                .then(will_submit => {
                    if (will_submit) {
                        $(form).off("submit").submit()
                    }
                })
            })
        })
    </script>
</body>
</html>
