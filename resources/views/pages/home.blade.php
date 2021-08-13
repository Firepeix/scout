@php /** @var \Scout\Book\Domain\Book $book */ @endphp
@extends('layout.app')
@section('content')
    <div class="card is-shadowless has-border">
        <header class="card-header is-shadowless has-bottom-border">
            <p class="card-header-title card-text-title">
                Livros
            </p>
            <div class="card-header-icon buttons are-small" aria-label="more options">
                <button class="button is-info">Limpar Logs</button>
            </div>
        </header>
        <div class="card-content">
            <table class="table is-fullwidth is-bordered is-hoverable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Capitulo</th>
                    <th>Ignorado Até</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->getId() }}</td>
                        <td>{{ $book->getTitle() }}</td>
                        <td>{{ $book->getLastChapterRead() }}</td>
                        <td>{{ $book->getIgnoredUntil() !== null ? $book->getIgnoredUntil()->format('d/m/Y') : 'Ativo'}}</td>
                        <td>123</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
