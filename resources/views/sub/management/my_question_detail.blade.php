<!--
/**
 * SubPage Template
 * 20210102 | @m | 최초 등록
 * 20210103 | @m | 요구반영. 결함개선. 고도화.
 * ~20210118. 20210316 | @m |
 * 20210324 | @m | 신고하기 레이어팝업 추가
 */
-->
@php
// 지난 시간 계산
function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'년',
        '2592000'=>'개월',
        '604800'=>'주',
        '86400'=>'일',
        '3600'=>'시간',
        '60'=>'분',
        '1'=>'초'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.' 전';
        }
    }
}
@endphp

@extends('master_sub')

@section('title', '질문게시판 - 상세')

@section('content')
<!-- #body -->
<div id="body" tabindex="-1">
<!-- container -->
<div class="container clearfix">


<!-- width1wrap1 -->
<div class="width1wrap1">


<!-- cp1view2 -->
<div class="cp1view2">


	<!-- cp1row1 -->
	<div class="cp1row1">
		<div class="column1">
			<a href="javascript:void(0);" onclick="history.go(-1); return false;" class="cp1b1back1"><i class="ic1"></i><span class="t1">돌아가기</span></a>
		</div>
		<div class="column2">
			<!-- cp1related1 -->
			<div class="cp1related1">
				<div class="hg1">
                    <span class="h1"><i class="h1ic1"></i><span class="h1t1">연관된 강의</span></span>
				</div>
				<ul class="lst1">
                    <li class="li1"><a href="{{ route('learning.main', ['idx' => $myQuestionInfo->lecture_idx, 'uid' => $myQuestionInfo->video_id]) }}" class="a1">{{ $myQuestionInfo->new_video_title }}</a></li>
				</ul>
			</div>
			<!-- /cp1related1 -->
		</div>
	</div>
	<!-- /cp1row1 -->


	<!-- cp1bbs4view1 -->
	<!-- 게시글 항목 item | 댓글 reply | 대댓글 reply2  -->
	<div class="cp1bbs4view1">
		<!-- 게시글 -->
		<div class="w1 item">
			<div class="w1w1">
				<div class="f1">
					<span class="f1p1">
						<img src="{{ asset('assets/images/lib/noimg1face1.png') }}" alt="이미지 없음" />
					</span>
				</div>
			</div>
			<div class="w1w2">
				<div class="tt1" id="title">
					{{ $myQuestionInfo->title }}
				</div>
                {{-- @if ($myQuestionInfo->solution_yn == 'N')
				<span class="st1 s1">#미해결</span>
                @else
				<span class="st1 s2">#해결</span>
                @endif --}}

                <div class="cp1menu3">
					<a href="javascript:void(0);" class="m m1 @if ($myQuestionInfo->solution_yn == 'Y') on @endif" solution_yn="Y" onclick="checkSolution(this)">해결</a>
					<a href="javascript:void(0);" class="m m2 @if ($myQuestionInfo->solution_yn == 'N') on @endif" solution_yn="N" onclick="checkSolution(this)">미해결</a>
				</div>
				<script>/*<![CDATA[*/
					$('.cp1menu3 .m').on('click', function(e){
						e.preventDefault();
						$(this).siblings().removeClass('on').end().addClass('on');
					});
				/*]]>*/</script>


				<div class="tg1">
					<span class="t1">{{ $myQuestionInfo->writer_name }}</span>
					<span class="t2">{{ format_date(strtotime($myQuestionInfo->writed_at)) }}</span>
				</div>
				<div class="tg2" id="content">
					{{ $myQuestionInfo->content }}
				</div>
                <div class="eg2">
                    <a href="#layer1question1edit1" class="a3 edit toggle popup_modify_note" data-toggle="modal" data-idx="{{ $myQuestionInfo->idx }}" data-title="{{ $myQuestionInfo->title }}" data-content="{{ $myQuestionInfo->content }}"><i class="a2ic1"></i><span class="a3t1">수정</span></a>
					<a href="javascript:void(0);" class="a3 del" onclick="deleteQuestion('{{ $myQuestionInfo->idx }}')"><span class="a3t1">삭제</span></a>
				</div>
				<div class="eg1">
					<a href="javascript:void(0);" class="cp1like1"><span class="cp1like1t1">좋아요</span> <span class="cp1like1t2">0</span></a>
					<!-- cp1menu1 -->
					<div class="cp1menu1 toggle1s1">
						<strong><a href="javascript:void(0);" class="b1 toggle-b"><i class="b1ic1"></i><span class="b1t1">(부가메뉴 여닫기)</span></a></strong>
						<div class="cp1menu1c toggle-c">
							<a href="#layer1report1post1" class="b2 report toggle" data-send-focus="that"><i class="b2ic1"></i><span class="b2t1">신고하기</span></a>
						</div>
					</div>
					<!-- /cp1menu1 -->
				</div>
			</div>
		</div>
		<!-- /게시글 -->
		<!-- 댓글작성 -->
		<div class="w1 item reply">
			<textarea rows="3" cols="80" title="댓글작성" class="w100 type1"></textarea>
			<div class="tar">
				<button type="submit" class="button submit semismall">등록하기</button>
			</div>
		</div>
		<!-- /댓글작성 -->
		<!-- 댓글 -->
		<div class="w1 item reply">
			<b class="g1"><i class="g1ic1"></i><span class="g1t1">강사가 채택한 답변입니다.</span></b>
			<div class="w1w1">
				<div class="f1">
					<span class="f1p1">
						<img src="{{ asset('assets/images/lib/noimg1face1.png') }}" alt="이미지 없음" />
					</span>
				</div>
			</div>
			<div class="w1w2">
				<div class="tg1">
					<span class="t1">강사명</span>
					<span class="t2">방금</span>
				</div>
				<div class="tg2">
					질문 답변입니다.질문 답변입니다.질문 답변입니다.질문 답변입니다.질문 답변입니다.질문 답변입니다.질문 답변입니다.질문 답변입니다.질문 답변입니다.질문 답변입니다.
				</div>
				<div class="eg1">
					<a href="#★" class="cp1like2"><span class="cp1like2t1 blind">좋아요</span> <span class="cp1like2t2">0</span></a>
					<!-- cp1menu1 -->
					<div class="cp1menu1 toggle1s1">
						<strong><a href="#★" class="b1 toggle-b"><i class="b1ic1"></i><span class="b1t1">(부가메뉴 여닫기)</span></a></strong>
						<div class="cp1menu1c toggle-c">
							<a href="#layer1report1post1" class="b2 report toggle" data-send-focus="that"><i class="b2ic1"></i><span class="b2t1">신고하기</span></a>
						</div>
					</div>
					<!-- /cp1menu1 -->
				</div>
				<!-- toggle1s1 -->
				<div class="toggle1s1">
					<a href="#★" class="b1 toggle-b fsS2">답글</a>
					<div class="toggle-c">
						<textarea rows="3" cols="80" title="대댓글작성" class="w100 type1"></textarea>
						<div class="tar">
							<button type="button" class="button toggle-close secondary semismall mgr05em">취소</button>
							<button type="submit" class="button submit semismall">등록</button>
						</div>
					</div>
				</div>
				<!-- /toggle1s1 -->
				<!-- toggle1s2 -->
				<div class="toggle1s2">
					<a href="#★" class="b1 toggle1s2-b cp1switch2 switch fsS2">
						<span class="cp1switch2-t1 sw-off">답글 보기</span>
						<span class="cp1switch2-t1 sw-on">답글 숨기기</span>
						<i class="ic1"></i>
					</a>
					<div class="toggle1s2-c">

						<!-- 대댓글 -->
						<div class="w1 item reply2">
							<div class="w1w1">
								<div class="f1">
									<span class="f1p1">
										<img src="{{ asset('assets/images/lib/noimg1face1.png') }}" alt="이미지 없음" />
									</span>
								</div>
							</div>
							<div class="w1w2">
								<div class="tg1">
									<span class="t1">강사명</span>
									<span class="t2">방금</span>
								</div>
								<div class="tg2">
									좋은 평 감사합니다.
								</div>
								<div class="eg1">
									<a href="#★" class="cp1like2"><span class="cp1like2t1 blind">좋아요</span> <span class="cp1like2t2">0</span></a>
									<!-- cp1menu1 -->
									<div class="cp1menu1 toggle1s1">
										<strong><a href="#★" class="b1 toggle-b"><i class="b1ic1"></i><span class="b1t1">(부가메뉴 여닫기)</span></a></strong>
										<div class="cp1menu1c toggle-c">
											<a href="#layer1report1post1" class="b2 report toggle" data-send-focus="that"><i class="b2ic1"></i><span class="b2t1">신고하기</span></a>
										</div>
									</div>
									<!-- /cp1menu1 -->
								</div>
							</div>
						</div>
						<!-- /대댓글 -->

					</div>
				</div>
				<!-- /toggle1s2 -->
			</div>
		</div>
		<!-- /댓글 -->
		<!-- 댓글 -->
		<div class="w1 item reply">
			<div class="w1w1">
				<div class="f1">
					<span class="f1p1">
                        <img src="{{ asset('assets/images/lib/noimg1face1.png') }}" alt="이미지 없음" />
					</span>
				</div>
			</div>
			<div class="w1w2">
				<div class="tg1">
					<span class="t1">누군가</span>
					<span class="t2">1시간전</span>
				</div>
				<div class="tg2">
					일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십
					일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십일이삼사오륙칠팔구십
				</div>
				<div class="eg1">
					<a href="#★" class="cp1like2"><span class="cp1like2t1 blind">좋아요</span> <span class="cp1like2t2">0</span></a>
					<!-- cp1menu1 -->
					<div class="cp1menu1 toggle1s1">
						<strong><a href="#★" class="b1 toggle-b"><i class="b1ic1"></i><span class="b1t1">(부가메뉴 여닫기)</span></a></strong>
						<div class="cp1menu1c toggle-c">
							<a href="#layer1report1post1" class="b2 report toggle" data-send-focus="that"><i class="b2ic1"></i><span class="b2t1">신고하기</span></a>
						</div>
					</div>
					<!-- /cp1menu1 -->
				</div>
				<!-- toggle1s1 -->
				<div class="toggle1s1">
					<a href="#★" class="b1 toggle-b fsS2">답글</a>
					<div class="toggle-c">
						<textarea rows="3" cols="80" title="대댓글작성" class="w100 type1"></textarea>
						<div class="tar">
							<button type="button" class="button toggle-close secondary semismall mgr05em">취소</button>
							<button type="submit" class="button submit semismall">등록</button>
						</div>
					</div>
				</div>
				<!-- /toggle1s1 -->
			</div>
		</div>
		<!-- /댓글 -->
	</div>
	<!-- /cp1bbs4view1 -->


</div>
<!-- /cp1view2 -->


</div>
<!-- /width1wrap1 -->


<!-- (레이어팝업.신고하기) -->
@include('sub.lecture.inc_layer_report_post')

<!-- (레이어팝업.질문수정) -->
@include('sub.management.inc_layer_question_modify')

</div>
<!-- /container -->
</div>
<!-- /#body -->

@endsection

@section('script')
<script>
$(function() {
    // 영상 노트 수정 레이어 팝업창 띄움
    $('.popup_modify_note').click(function() {
        var questionIdx = $(this).data('idx');
        var questionTitle = $(this).data('title');
        var questionContent = $(this).data('content');

        $('#question_idx').val(questionIdx);
        $('#question_title').val(questionTitle);
        $('#question_content').text(questionContent);
    });
});

// 해결/미해결 선택
function checkSolution(e) {
    if ($(e).hasClass('on')) {
        return false;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'json',
        url: "{{ route('sub.management.check_solution') }}",
        data: {
            'question_idx': '{{ $_GET['idx'] }}',
            'solution_yn': $(e).attr('solution_yn')
        },
        success: (data) => {
            if (data.status == 'success') {
                // alert('done!');
                if ($(e).attr('solution_yn') == 'Y') {
                    alert('해결 처리되었습니다.');
                } else {
                    alert('미해결 처리되었습니다.');
                }

            } else {
                alert('질문 목록을 조회하는 도중 문제가 발생했습니다.\n관리자에게 문의 바랍니다.');
                // console.log('code: ' + data.code + '\nmessage: ' + data.msg);
            }
        },
        error: function(request, status, error) {
            //
        },
    });
}

// 질문 수정
function modifyQuestion() {
    var questionIdx = $('#question_idx').val();
    var questionTitle = $('#question_title').val();
    var questionContent = $('#question_content').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'json',
        url: "{{ route('sub.management.modify_question') }}",
        // contentType: false,
        // processData: false,
        data: {
            'question_idx': questionIdx,
            'question_title': questionTitle,
            'question_content': questionContent
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

// 질문 삭제
function deleteQuestion(questionIdx) {
    if (confirm('해당 질문을 삭제하시겠습니까?')) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            url: "{{ route('sub.management.delete_question') }}",
            // contentType: false,
            // processData: false,
            data: {
                'question_idx': questionIdx
            },
            success: (response) => {
                if (response.status == 'success') {
                    location.href='{{ route('sub.management.my_question_list') }}';

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
