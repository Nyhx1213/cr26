@extends('layouts.default')

@section('title', 'Classement')

@section('content')
<table>
    <thead>
        <tr>
            <th>Rang</th>
            <th>Équipe</th>
            <th>Collège</th>
            <th>Score</th>
            <th>Site</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($scores as $index => $score)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $score->equipe->nom }}</td>
            <td>{{ $score->equipe->college?->nom ?? 'Inconnu' }}</td>
            <td>{{ $score->score_total }}</td>
            <td><a href="{{ $score-> equipe->site}}">{{ $score-> equipe->site}}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection