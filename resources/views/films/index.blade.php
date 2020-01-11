@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Films <small>({{ $films->count() }})</small>
            </div>
            <div class="card-body">
                <form id="search-form" action="{{ url('search') }}" method="get">
                    <div id="js-search" class="form-group">
                        <input
                            v-model="search"
                            id="js-input"
                            type="text"
                            name="q"
                            class="form-control"
                            placeholder="Search..."
                            value="{{ request('q') }}"
                        />
                        <div style="width: 100%; height: fit-content;" v-for="completion in completions">
                            <completion-suggestion :completion="completion" @suggestion-clicked="suggestionClicked"></completion-suggestion>
                        </div>
                    </div>
                </form>
                @forelse ($films as $film)
                    <article class="mb-3">
                        <h2>{!! $film->highlight != null ? $film->highlight->title != null ? $film->highlight->title[0] : $film->title : $film->title !!}</h2>

                        <p class="m-0">{!! $film->highlight != null ? $film->highlight->description != null ? $film->highlight->description[0] : $film->description : $film->description !!}</body>

                        <div>
                            {{--                            @foreach ($article->tags as $tag)--}}
                            {{--                                <span class="badge badge-light">{{ $tag}}</span>--}}
                            {{--                            @endforeach--}}
                        </div>
                    </article>
                @empty
                    <p>No films found</p>
                @endforelse
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                completions: [],
                search: "{{ $query }}"
            },
            watch: {
                search: function (val, preVal) {
                    if ( val !== "" ) {
                        axios.get('/search/completions/' + val).then(response => {
                            app.completions = response.data;
                        }).catch(error => {
                            console.log(error)
                        });
                    } else {
                        app.completions = [];
                    }
                }
            },
            methods: {
                suggestionClicked: function (value) {
                    document.getElementById('js-input').value = value;
                    document.getElementById('search-form').submit();
                }
            }
        });
    </script>
@stop
