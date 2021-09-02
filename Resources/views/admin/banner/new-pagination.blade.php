<div class="layui-table-page">
    <div class="layui-box layui-laypage layui-laypage-default">

        @if($paginator->onFirstPage())
            <a href="javascript:;" class="layui-laypage-prev layui-disabled"><i class="layui-icon"></i></a>
        @else
            <a href="{{$paginator->previousPageUrl()}}" class="layui-laypage-prev"><i class="layui-icon"></i></a>
        @endif

        @for($paginatorii = 1; $paginatorii <= $paginator->lastPage(); $paginatorii++)
            @if($paginatorii == $paginator->currentPage())
                <span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>{{$paginatorii}}</em></span>
            @elseif($paginatorii == 1 || $paginatorii == $paginator->lastPage())
                <a href="{{$paginator->url($paginatorii)}}">{{$paginatorii}}</a>
            @elseif($paginator->lastPage() <= 4)
                <a href="{{$paginator->url($paginatorii)}}">{{$paginatorii}}</a>
            @elseif($paginator->lastPage() > 4)
                @if(($paginatorii + 1) == $paginator->currentPage() && ($paginatorii - 1) != 1)
                    <span class="layui-laypage-spr">…</span>
                    <a href="{{$paginator->url($paginatorii)}}">{{$paginatorii}}</a>
                @elseif(($paginatorii + 1) == $paginator->currentPage() && ($paginatorii - 1) == 1)
                    <a href="{{$paginator->url($paginatorii)}}">{{$paginatorii}}</a>
                @elseif(($paginatorii - 1) == $paginator->currentPage() && ($paginatorii + 1) != $paginator->lastPage())
                    <a href="{{$paginator->url($paginatorii)}}">{{$paginatorii}}</a>
                    <span class="layui-laypage-spr">…</span>
                @elseif(($paginatorii - 1) == $paginator->currentPage() && ($paginatorii + 1) == $paginator->lastPage())
                    <a href="{{$paginator->url($paginatorii)}}">{{$paginatorii}}</a>
                @endif
            @endif
        @endfor

        @if($paginator->currentPage() == $paginator->lastPage())
            <a href="javascript:;" class="layui-laypage-next layui-disabled"><i class="layui-icon"></i></a>
        @else
            <a href="{{$paginator->nextPageUrl()}}" class="layui-laypage-next"><i class="layui-icon"></i></a>
        @endif

        <span class="layui-laypage-count">共 {{$paginator->total()}} 条</span>
    </div>
</div>
