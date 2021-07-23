<style>
    .comment-date{
        color:#a9a9a9;
    }
</style>
@if($comments->isEmpty())
    @if(!$replies)
        <div class="center">
            <p>{{ trans('general.no_comments') }}</p>
        </div>
    @endif
@else
    @foreach($comments as $comment)
        <div class="col @if($replies) offset-s1 s11 @else s12 @endif" id="comment-block-{{ $comment->id }}">
            <div class="card-panel grey lighten-5 z-depth-1">
                <div class="row valign-wrapper">
                    <div class="col s1">
                        <img src="{{ getUserThumbnail($comment->user)  }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                    </div>
                    <div class="col s11">
                          <span class="black-text">
                              <span class="right comment-date">{{ get_time_ago($comment->created_at) }}</span>
                                {{ $comment->comment  }}
                              @if(!$replies) <br><a href="#" class="reply-link" onclick="goToCommentInput({{ $comment->id }}, '{{ $comment->url }}');">@if($comment->replies()->count()) Replies ({{ $comment->replies()->count() }}) @else {{ trans('general.reply') }} @endif</a>
                              @endif
                          </span>
                    </div>
                </div>
            </div>
        </div>
        @if(!$replies)
            <div id="replies-{{ $comment->id }}" data-id="{{ $comment->id }}">
                <div class="center loader hide">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div><div class="gap-patch">
                                <div class="circle"></div>
                            </div><div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    @if($showPages && $replies)
        <div class="center">
            <a href="#"  onclick="loadMoreReplies(this, '{{ $url }}', {{ $comment_id }});">{{ trans('general.load_more') }}</a>
        </div>
    @endif

@endif
@if($replies)
    <div class="col offset-s1 s11" id="block-reply-{{ $comment_id }}">
        <form action="#" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="comment-input" name="comment" class="materialize-textarea input-{{ $comment_id }}"></textarea>
                    <label for="comment-input">{{ trans('general.post_reply') }}</label>
                    <a href="#" onclick="postComment(this, '{{ $url }}', {{ $comment_id }});" data-reply="1" class="waves-effect waves-blue btn right">{{ trans('general.post') }}</a>
                </div>
            </div>
        </form>
    </div>
@endif

@if($showPages && !$replies)
    <div class="center">
        <a href="#" onclick="loadMoreComments(this, '{{ $url }}');">{{ trans('general.load_more') }}</a>
    </div>
@endif