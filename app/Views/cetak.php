<html>

<head>
    <title>Cetak Laporan</title>

    <style>
        /* Micro clearfix */
        .cf:before,
        .cf:after {
            content: " ";
            /* 1 */
            display: table;
            /* 2 */
        }

        .cf:after {
            clear: both;
        }

        /**
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */
        .cf {
            *zoom: 1;
        }

        /* akhir micro clearfix*/



        .d-flex {
            display: flex;
            flex-wrap: wrap;
        }

        .d-inline {
            display: inline;
        }

        .d-inline-block {
            display: inline-block;
        }

        .text-center {
            text-align: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .d-block {
            display: block;
        }

        .container {
            width: 800px;
            margin: auto;
        }

        /* .heder .container .logo {
            float: left;
        } */

        .header .container .title {
            margin: -100px auto 0;
            /* float: right; */
        }

        .header .container .title h2 {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: 20px;
        }

        .header .container .title p {
            font-family: 'Times New Roman', Times, serif;
            font-style: italic;
            /* font-size: 17px; */
        }

        .header .container .title .alamat {
            margin-top: 10px;
        }

        .header .container .title .kota {
            margin-top: -10px;
            margin-bottom: -5px;
        }

        main {
            margin-top: 20px;
        }

        .data-laporan h5 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22px;
            margin-left: 0px;
            margin-top: 15px;
            text-decoration: underline;
        }

        .table1 {
            font-family: sans-serif;
            color: #444;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #f2f5f7;
        }

        .table1 tr th {
            background: #FF6E15;
            color: #fff;
            font-weight: normal;
        }

        .table1,
        th,
        td {
            border: 1px solid #DCDCDC;
            padding: 8px 20px;
            text-align: center;
        }

        .table1 tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container d-block">
            <div class="logo">
                <img src="<?= base_url('public/uploads/logo') . '/logo.jpg' ?>" width="100" height="100">
            </div>
            <div class="title">
                <h2 class="text-center">UNIVERSITAS SAINS DAN TEKNOLOGI </h2>
                <p class="text-center alamat">Jl. Sosial Padang Bulan, Hedam, Abepura</p>
                <p class="text-center kota">Kota Jayapura, Papua 99352</p>
            </div>

        </div>

    </header>
    <main>
        <div class="container">
            <hr size="3%" color="black" noshade>
            <section class="data-laporan">
                <h5 class="text-center">Laporan Hasil Perhitungan</h5>
                <table class="table1">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Usia</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Andi Saputra</td>
                        <td>Magelang</td>
                        <td>21</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Budi Budiman</td>
                        <td>Jakarta</td>
                        <td>24</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Calvin Sanusi</td>
                        <td>Malang</td>
                        <td>29</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Diki</td>
                        <td>Bandung</td>
                        <td>24</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Malas Ngoding</td>
                        <td>Medan</td>
                        <td>23</td>
                    </tr>
                </table>
            </section>
        </div>
    </main>
</body>

</html>