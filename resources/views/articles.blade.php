@extends('Layouts.base')
@section('title', 'Articles')
@section('content')
<section>
    <div class="container">
        <div class="jumbotron text-center">
            <h1>Articles</h1>
            <p>News API | Gurdian API | New York Times API </p>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-info">Sync News API Articles</button>
                <button type="button" class="btn btn-warning">Sync Gurdian API Articles</button>
                <button type="button" class="btn btn-danger">Sync New York Times API Articles</button>
            </div>
        </div>
    </div>
</section>
@endsection

