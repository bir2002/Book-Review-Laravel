@extends('layouts.app')

@section('content')

<h1 class="mb-10 tetx-2x1">Books</h1>
<form method="GET" action="{{route('books.index')}}">
    <input type="text" name="title" placeholder="Search for a book" value="{{request('title')}}" class="input"/>
    <button type="submit" class="btn">Search</button>
    <a href="{{route('books.index')}}" class="btn">Reset</a>
</form>

<div class="filter-container mb-4 flx">
    @php
        '' => 'Latest',
           'popular_last_month' => 'Popular Last Month',
           'popular_last_6months' => 'Popular Last 6 Months',
           'highest_rated_last_month' => 'Highest Rated Last Month',
           'highest_rated_last_6months' => 'Highest Rated Last 6 Months',

    @endphp
     @foreach ($filters as $key => $label)
     <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
       class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">
       {{ $label }}
     </a>
   @endforeach
 </div>
</div>  

<ul>   
    @forelse ($books as $book)
    <li class="mb-4">
        <div class="book-item">
          <div
            class="flex flex-wrap items-center justify-between">
            <div class="w-full flex-grow sm:w-auto">
              <a href="{{route('books.show', $book->id)}}" class="book-title">{{$book->title}}</a>
              <span class="book-author">by {{$book->author}}</span>
            </div>
            <div>
              <div class="book-rating">
               {{number_format($book->reviews()->avg('rating'), 1)}}
              </div>
              <div class="book-review-count">
                out of {{$book->reviews()->count()}} {{Str::Plural('review', $book->reviews()->count())}}
              </div>
            </div>
          </div>
        </div>
      </li>
    @empty
    <li class="mb-4">
        <div class="empty-book-item">
          <p class="empty-text">No books found</p>
          <a href="{{route('books.index')}}" class="reset-link">Reset criteria</a>
        </div>
      </li>
        
    @endforelse
</ul>
@endsection;