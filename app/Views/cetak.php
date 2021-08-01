<html>

<head>
    <title>Cetak Laporan</title>

    <style>
        .logo img {
            width: 150px;
            height: 150px;
        }

        .d-flex {
            display: flex;
            flex-wrap: wrap;
        }

        .text-center {
            text-align: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .container {
            width: 800px;
            margin: auto;
        }

        .header .container .title {
            margin: 0 auto;
        }

        main {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container d-flex">
            <div class="logo">
                <img src="<?= base_url('public/uploads/logo') . '/logo.jpg' ?>">
            </div>
            <div class="title">
                <h5>UNIVERSITAS SAINS DAN TEKNOLOGI </h5>
            </div>

        </div>

    </header>
    <main>
        <div class="container">
            <hr size="3%" color="black" noshade>
        </div>
    </main>
</body>

</html>