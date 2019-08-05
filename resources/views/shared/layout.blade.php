<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head')
</head>
<body>
    <div style="min-height: 90vh">
        @unless(isset($dont_show_navbar) && $dont_show_navbar)
            @include('shared.navbar')
        @endunless

        @if(! ($is_home_page ?? false ))
        <div class="container">
            @include("shared.auth-info")
        </div>
        @endif

        @yield('content')
    </div>

    <div class="mt-3">
        @yield("pre-footer")
        <footer class="bg-dark text-light">
            <div class="container py-3">
                <div class="row">
                    <div class="col-md-7">
                        <p>
                            Sistem Informasi Geografis Zakat ini merupakan
                            sebuah website yang menyajikan informasi
                            tentang lokasi unit pengumpul zakat dan
                            mustahiq. Website ini bertujuan untuk
                            memberikan kemudahan kepada muzakki
                            untuk memberi zakat kepada UPZ ataupun
                            langsung kepada Mustahiq.
                        </p>
                        <p>
                            KANTOR BAZNAS KOTA PONTIANAK <br/>
                            Jl. Tabrani Ahmad (Komplek Kantor Camat Barat) Pontianak 78115 <br/>
                        </p>
                    </div>
                    <div class="col-md-5">
                        TEL: (0561) 812 8215 / 0812 5645 1201 <br/>
                        FAX: (0561) 812 8215 <br/>
                    </div>
                </div>
            </div>
        </footer>
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
