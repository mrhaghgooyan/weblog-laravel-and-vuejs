<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>Aloware Single Blog | What is a CRM dialer and why do you need one?</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>

</head>
<body class="bg-white">
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light mb-3">

        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="image/Aloware-Logo-Dark.png" alt="Aloware" width="200">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <section content="container mt-3">
        <nav class="d-none d-md-block">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item active small" aria-current="page">Home</li>
                <li class="breadcrumb-item active small" aria-current="page">Resource</li>
                <li class="breadcrumb-item active small" aria-current="page">Blogs</li>
                <li class="breadcrumb-item active small" aria-current="page">What is a CRM dialer and why do you need one?</li>
            </ol>
        </nav>
        <h1 class="font-weight-bolder mb-3">What is a CRM dialer and why do you need one?</h1>
        <div class="d-flex d-none d-md-block">
            <span class="text-muted mr-3 small">January 6, 2022</span>
            <span class="text-muted mr-3 small">Aloware Editors</span>
            <a href="#" class="btn-link text-success small">#Contact Center Solutions</a>
        </div>
        <img src="./image/CRM-dialer-main-FINAL.png" alt="Aloware" class="img-fluid rounded mt-3">
    </section>
    <section class="row my-3">
        <div class="col-12 col-md-8">
            <p>A CRM, which stands for customer relationship management, is one of the most powerful business management tools today. It helps companies keep a digital record of every customer. A CRM gathers customer interactions from various channels into one place to generate leads and earn more revenue.</p>
            <p>A CRM, which stands for customer relationship management, is one of the most powerful business management tools today. It helps companies keep a digital record of every customer. A CRM gathers customer interactions from various channels into one place to generate leads and earn more revenue.</p>
            <h2>What is a CRM Dialer?</h2>
            <p>
                A <a href="#" class="text-success">CRM dialer</a> assists agents by making it easier and faster for them to dial telephone numbers from their database. Conversation logs and notes are automatically synced with your CRM system which makes everything much easier to track.
            </p>
        </div>
        <div class="col-12 col-md-4">
            <div>
                <img src="./image/banner-ad-ebook2@2x-1.png" alt="Aloware Book" class="img-fluid border rounded">
            </div>
        </div>
    </section>
</div>


<div id="app">
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

</body>
</html>
