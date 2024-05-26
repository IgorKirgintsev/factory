<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<style>
    body { font-family: DejaVu Sans, sans-serif; }
</style>
<body>
     <h2>{{$mcompany->name}}</h2>
     <h2>{{$title}}</h2>
     <h3>{{$date}}</h3>
     <div class="container mt-5">
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-danger">
                <th scope="col">Клиент</th>
                <th scope="col">Адрес</th>
                <th scope="col">Почта</th>
                <th scope="col">Инн</th>
                <th scope="col">Телефон</th>
            </tr>
        </thead>
          <tbody>
            @foreach($clients as $item)
             <tr>
                <td>{{$item->name}}</td>
                <td>{{$item->adres}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->inn}}</td>
                <td>{{$item->telefon}}</td>
            </tr>
            @endforeach
        </div>
        <script src="{{ asset('js/app.js') }}" type="text/js"></script>
    </body>
</html>
