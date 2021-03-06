<!--
/**
 * SubPage Template
 * 20210102 | @m | 최초 등록
 * 20210208 | @m | 요구반영. 결함개선. 고도화.
 * ~20210208 | @m |
 * 20210406 | @m | 요구반영
 */
-->
@extends('master_sub')

@section('title', '영상보관함 - 재생목록')

@section('content')
<!-- #body -->
<div id="body" tabindex="-1">
<!-- container -->
<div class="container clearfix">
<!-- #body_head -->
<div id="body_head">
<!-- container -->
<div class="container clearfix">

@include('inc.common.inc_layer_sitemap')

<!-- body_title -->
<div id="body_title">

	<!-- location1 -->
	<div id="location1">
		<div class="breadcrumb clearfix">
			<strong class="blind">현재페이지 위치:</strong>
			<span class="cont">
				<a href="javascript:void(0);" class="a1"><i class="t1">영상보관함</i></a>
			</span>
		</div>
	</div>
	<!-- /location1 -->

	<!-- lnb1 -->
	<div id="lnb1">
		<strong class="h1"><a href="#lnb1c" class="toggle slide" title="현재 위치"><span class="t1">재생 목록</span> <i class="ic1"></i></a></strong>
		<!-- lnb1c -->
		<div id="lnb1c">
			<ul>
			<li><a href="{{ route('sub.video.video_play_history') }}">시청 기록</a></li>
			<li><a href="{{ route('sub.video.video_note_list') }}">영상 노트</a></li>
			<li><a href="{{ route('sub.video.video_playlist') }}">재생 목록</a></li>
			</ul>
		</div>
		<!-- /lnb1c -->
	</div>
	<!-- lnb1 -->
	<script>/*<![CDATA[*/
		$(function(){
			/** ◇◆ 목록앵커 클릭하면 활성 메뉴를 제목에 표시. 링크 이동. 20210111. @m
			 */
			(function(){
				var $my = $('#lnb1'),
					$m = $('li>a[href]', $my);
				// 현재활성
				$m.each(function(){
					if( $(this).closest('li').is('.on') ){
						$('.h1 .t1', $my).text( $(this).text() );
					}
				});

				// 클릭
				$m.on('click', function(e){
					//e.preventDefault();
					$('.toggle', $my).triggerHandler('click'); // 토글 닫기
					$('.h1 .t1', $my).text( $(this).text() );
					return; // 링크 이동
				});
			})();
		});
	/*]]>*/</script>

</div>
<!-- /body_title -->


<!-- cp1infomenu1 -->
<div class="cp1infomenu1">
	<div class="w1">
	</div>
	<div class="w2">
		<a href="#layer1playlist1write1" class="button toggle" data-send-focus="that"><span class="t1">+ 새 목록 만들기</span></a>
	</div>
</div>
<!-- /cp1infomenu1 -->


<!-- (레이어팝업.노트수정) -->
@include('sub.video.inc_layer_playlist_add')

<script>/*<![CDATA[*/
    $(function(){
        // 레이어팝업 템플릿 바로 확인
        //$('[href="#layer1playlist1write1"]').triggerHandler('click');
    });
/*]]>*/</script>


</div>
<!-- /container -->
</div>
<!-- /#body_head -->
<!-- #body_content -->
<div id="body_content">
<!-- container -->
<div class="container clearfix">


<!-- cp1playlist2 -->
<div class="cp1playlist2">
    <ul class="lst1">
        @if (count($playlistDirectoryList))
            @foreach ($playlistDirectoryList as $playlistDirectory)
            <li class="li1">
                <div class="tg1">
                    <div class="t1">
                        <a href="@if ($playlistDirectory->video_sum == 0) javascript:alert('해당 재생목록에 영상이 없습니다.'); @else {{ route('sub.video.video_playlist_detail', ['idx' => $playlistDirectory->idx]) }} @endif" class="a1">{{ $playlistDirectory->title }}</a>
                    </div>
                    <span class="t2">총 영상 수 {{ $playlistDirectory->video_sum }}개 &gt;</span>
                </div>
                <div class="eg1">
                    <a href="javascript:void(0);" class="a2 edit" directory_idx="{{ $playlistDirectory->idx }}"><i class="a2ic1"></i> <span class="a2t1">수정</span></a>
                    <a href="javascript:void(0);" class="a2 del" onclick="deletePlaylistDirectory('{{ $playlistDirectory->idx }}')"><i class="a2ic1"></i> <span class="a2t1">삭제</span></a>
                </div>
            </li>
            @endforeach
        @else
        <br><br><span>재생목록이 없습니다.</span>
        @endif
	</ul>
</div>
<!-- /cp1playlist2 -->


<script>/*<![CDATA[*/
	$(function(){

		/** ◇◆ 수정클릭샘플 | 20210208. @m
		 * 이건 그냥 보여주기 샘플. 개발자 동작 처리 필요!
		 */
		(function(){
			var $my = $('.cp1playlist2'),
				$bedit = $('.a2.edit', $my);
			// 수정 클릭
			$bedit.on('click', function(e){
				e.preventDefault();
                var directoryIdx = $(this).attr('directory_idx');
				var $item = $(this).closest('.li1');
				$item.find('.tg1, .eg1').hide(); // 원래 내용 숨김
				var html = '';
					html += '<div class="w1edit">';
					html += '	<input type="text" value="" placeholder="제목을 입력해주세요. (50자 이하)" title="재생 목록 제목" class="text w100 mgb05em" />';
					html += '	<div class="eg1">';
					html += '		<a href="javascript:void(0);" class="a2 cancel"><i class="a2ic1"></i> <span class="a2t1">취소</span></a>';
					html += '		<a href="javascript:void(0);" class="a2 save"><i class="a2ic1"></i> <span class="a2t1">저장</span></a>';
					html += '	</div>';
					html += '</div>';
				$item.append($(html));
				var $input = $('input.text', $item),
					$bcancel = $('.a2.cancel', $item),
					$bsave = $('.a2.save', $item);
                $bsave.attr('directory_idx', directoryIdx);
				$input.val( $item.find('.tg1>.t1').text().replace(/^\s*|\s*$/g, '') )[0].focus(); // 앞뒤공백제거 후 인풋막스 값 넣음
				// 취소 클릭
				$bcancel.on('click', function(e){
					$item.find('.tg1, .eg1').show(); // 원래 내용 보임
					$item.find('.w1edit').remove(); // 수정 양식 제거
				});
				// 저장 클릭
				$bsave.on('click', function(e){
					$item.find('.tg1>.t1').text( $input.val() ); // 수정한 값 넣음
					$item.find('.tg1, .eg1').show(); // 원래 내용 보임
					$item.find('.w1edit').remove(); // 수정 양식 제거

                    var directoryIdx = $(this).attr('directory_idx');
                    var directoryTitle = $(this).closest('.w1edit').find('.text').val();

                    // 재생목록 디렉터리 수정
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        dataType: 'json',
                        url: "{{ route('sub.video.modify_playlist_directory') }}",
                        // contentType: false,
                        // processData: false,
                        data: {
                            'directory_idx': directoryIdx,
                            'directory_title': directoryTitle
                        },
                        success: (response) => {
                            if (response.status == 'success') {
                                location.reload();

                            } else {
                                alert(response.msg);
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
				});
			});
		})();
	});
/*]]>*/</script>


</div>
<!-- /container -->
</div>
<!-- /#body_content -->
</div>
<!-- /container -->
</div>
<!-- /#body -->
@endsection

@section('script')
<script>
// 재생 목록 디렉터리 삭제
function deletePlaylistDirectory(idx) {
    if (confirm('해당 재생목록을 삭제하시겠습니까?\n재생목록에 추가된 영상도 전부 삭제됩니다.')) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            url: "{{ route('sub.video.delete_playlist_directory') }}",
            // contentType: false,
            // processData: false,
            data: {
                'directory_idx': idx
            },
            success: (response) => {
                if (response.status == 'success') {
                    location.reload();

                } else {
                    alert(response.msg);
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
}
</script>
@endsection
