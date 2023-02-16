@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/subspecs.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="{{ asset('css/select2-materialize.css') }}" rel="stylesheet" />
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (isset($status))
        <div class="alert alert-success" role="alert">
            {!! $status !!}
        </div>
    @endif

    <style type="text/css">
      .stats th {
        font-size: 0.9rem;
        line-height: 1;
      }
      .stats td {
        font-size: 1rem;
        text-align: left;
        padding: 0.7rem;
        border: solid 1px #ccc;
      }
    </style>


    <div class="container">
        <div class="row justify-content-center">
                <div class="col-md-10 m-auto">
                  <h3 class="mt-3">Заходы по меткам:</h3>
                  <table class="stats m-auto">
                    <tr>
                      <th>Метка</th>
                      <th>Страница захода</th>
                      <th>Количество заходов</th>
                      <th>Последння дата захода</th>
                    </tr>
                  @foreach ($utmStats as $stat)
                      <tr>
                        <td>{{$stat->source_id}}</td>
                        <td>{{$stat->target_id}}</td>
                        <td class="text-center">{{ ($stat->visit_count)}}</td>
                        <td>{{ ($stat->updated_at)}}</td>
                      </tr>
                  @endforeach
                  </table>
                </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-10">
            <h3 class="mt-3">Заходы в собственные профили:</h3>
            <table class="stats m-auto">
              <tr>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Количество заходов</th>
              </tr>
            @foreach ($userStats as $stat)
                <tr>
                  <td>{{$stat->name}}</td>
                  <td>{{$stat->phone}}</td>
                  <td class="text-center">{{ ($stat->own_profile_visits)}}</td>
                </tr>
            @endforeach
            </table>
          </div>
  </div>
    </div>
@endsection
