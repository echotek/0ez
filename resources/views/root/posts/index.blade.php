@extends('root.main')

@section('body')
    <div class="container">
        <h1>{{ $title }}</h1>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-2">
                <div class="sidebar-nav">
                    <a href="{{ route('root-posts-new') }}" class="btn btn-block btn-success">New Post</a>
                    <input type="text" name="q" placeholder="Fast search..." class="form-control" />
                    <ul class="nav nav-pills nav-stacked">
                        <li class="{{ Input::get('status', 'all') == 'all' ? 'active' : '' }}">
                            <a href="{{ route('root-posts') }}">All Posts</a>
                        </li>
                        <li class="{{ Input::get('status') == 'draft' ? 'active' : '' }}">
                            <a href="{{ route('root-posts', ['status' => 'draft']) }}">Drafts</a>
                        </li>
                        <li class="{{ Input::get('status') == 'moderation' ? 'active' : '' }}">
                            <a href="{{ route('root-posts', ['status' => 'moderation']) }}">Moderation</a>
                        </li>
                        <li class="{{ Input::get('status') == 'refused' ? 'active' : '' }}">
                            <a href="{{ route('root-posts', ['status' => 'refused']) }}">Refused</a>
                        </li>
                        <li class="{{ Input::get('status') == 'deleted' ? 'active' : '' }}">
                            <a href="{{ route('root-posts', ['status' => 'deleted']) }}">Deleted</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-10">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Published</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr class="{{ $post->is_pinned == '1' ? 'warning' : '' }} {{ in_array($post->status, ['draft', 'deleted', 'refused']) ? 'active' : '' }}">
                            <td>{{ $post->id }}</td>
                            <td>
                                <div>
                                    <a href="{{ route('root-post-edit', ['post_id' => $post->id]) }}">{{ $post->title }}</a>
                                    @if($post->status == 'draft')
                                        <span class="purple-text">Draft</span>
                                    @endif
                                </div>
                                <div class="post-options">
                                    <a href="{{ route('view', ['slug' => $post->slug]) }}" target="_blank" class="brown-text">View</a>
                                    <a href="{{ route('root-post-edit', ['post_id' => $post->id]) }}" class="brown-text">Edit</a>
                                    @if($post->status == 'active')
                                        <a href="{{ route('root-post-to-draft', ['post_id' => $post->id]) }}"
                                           class="brown-text">To Draft</a>
                                    @else
                                        <a href="{{ route('root-post-to-active', ['post_id' => $post->id]) }}"
                                           class="brown-text">Publish</a>
                                    @endif
                                    @if($post->status != 'deleted')
                                        <a href="{{ route('root-post-to-deleted', ['post_id' => $post->id]) }}"
                                           class="brown-text">Delete</a>
                                    @else
                                        <a href="{{ route('root-post-to-draft', ['post_id' => $post->id]) }}"
                                           class="brown-text">Recover</a>
                                    @endif
                                    @if($post->is_pinned)
                                        <a href="{{ route('root-post-unpin', ['post_id' => $post->id]) }}" class="brown-text">Unpin</a>
                                    @else
                                        <a href="{{ route('root-post-pin', ['post_id' => $post->id]) }}"
                                           class="brown-text">Pin</a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ date('Y.m.d H:i', strtotime($post->published_at)) }}
                                </div>
                                <div>
                                    <small class="text-muted">{{ hdate($post->published_at) }}</small>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    @if($posts->lastPage() > 1)
                        {!! $posts->render() !!}
                    @endif
                </div>
            </div>
        </div>


    </div>
@stop