<div class="col @if($reply) offset-s1 s11 @else s12 @endif">
    <div class="card-panel grey lighten-5 z-depth-1">
        <div class="row valign-wrapper">
            <div class="col s1">
                <img src="{{ getUserThumbnail($comment->user)  }}" alt="" class="circle responsive-img">
            </div>
            <div class="col s11">
                  <span class="black-text">
                      <span class="right comment-date">{{ get_time_ago($comment->created_at) }}</span>
                      {{ $comment->comment  }}
                      @if(!$reply) <br><a href="#" class="reply-link" onclick="goToCommentInput({{ $comment->id }}, '{{ $comment->url }}');">{{ trans('general.reply') }}</a>
                      @endif
                  </span>
            </div>
        </div>
    </div>
</div>

@if(!$reply)
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