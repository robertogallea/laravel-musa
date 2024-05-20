<x-mail::message>
# Introduction

E' stato pubblicato **{{ $post->title }}** un nuovo post! Vai subito a leggerlo!

> {{ $post->summary }}

<x-mail::button :url="route('posts.show', $post)">
Visualizza {{ $post->title }}
</x-mail::button>



A presto!<br>
{{ config('app.name') }}
</x-mail::message>
