{{-- 기본정보입력 --}}
<div class="tac fsB4 wwbw wbka">
	<i class="ic1 indy ic40notice1"></i>
	<div class="mgt05em mgb2em">
		강좌의 기본 정보를 입력해주세요.<br />
		이 강좌에 대한 정보를 쉽게 알 수 있도록 설정해보세요.<br />
		<div class="mgt05em mgb05em">
			<a href="#layer1tip1write1" class="dpib fsS2 vam toggle" data-send-focus="that">
				<span class="dpib mgr025em bdb1px">기본 정보 작성</span>
				<span class="bgc4 pdl05em pdr05em round ls0 cvf">TIP!</span>
			</a>
		</div>
	</div>
</div>

<!-- (레이어팝업. 기본 정보 작성 TIP) -->
@include('sub.lecture.inc_layer_tip_basic')

<script>/*<![CDATA[*/
	$(function(){
		// 레이어팝업 템플릿 바로 확인
		//$('[href="#layer1tip1write1"]').first().triggerHandler('click');
	});
/*]]>*/</script>

<hr class="bdt1px mgt125em mgb125em" />

<!-- even-grid -->
<div class="even-grid float-left gap5pct vgap0">
	<div class="small-12 medium-4 column">

		<!-- cp1new1lecture1write1 -->
		<div class="cp1new1lecture1write1">
			<div class="f1">
				<div class="f1p1">
                    @if (isset($tempInfo))
                        @if ($tempInfo->save_thumbnail == '')
                        <img src="{{ asset('assets/images/lib/noimg1.png') }}" id="thumb-image" alt="★대체텍스트필수" />
                        @else
                        <img src="{{ asset('storage/uploads/'.$tempInfo->save_thumbnail) }}" id="thumb-image" alt="★대체텍스트필수" />
                        @endif
                    @else
                    <img src="{{ asset('assets/images/lib/noimg1.png') }}" id="thumb-image" alt="★대체텍스트필수" />
                    @endif
				</div>
			</div>
			<!-- cp1upload1 -->
			<div class="cp1upload1">
				<label for="★1file0" class="label">이미지업로드</label>
                <form method="POST" id="image-upload-form" action="" enctype="multipart/form-data">
                    @csrf
                    <span class="w1file">
                        <input type="file" id="★1file0" name="file" class="file" />
                        <input type="text" value="" title="업로드 파일명" class="file" />
                        <button type="button" class="b1 del">파일 지우기</button>
                    </span>
                </form>
			</div>
			<!-- /cp1upload1 -->
		</div>
		<!-- /cp1new1lecture1write1 -->

		<script>/*<![CDATA[*/
			//$(function(){
				/** ◇◆ 이미지업로드 input[type='file'] 고도화. 20210215. 20210218. @m.
				 */
				(function(){
					var $my = $('.cp1upload1'),
						$file = $('[type="file"]', $my),
						$text = $('[type="text"]', $my),
						$del = $('.b1.del', $my);

					// 초기 호출
					isVal();

					// 파일값 동기화
					$file.on('change', function(){
						$text.val( getFileName( $file.val() ) );
						isVal();
					});

					// 파일 지우기
					$del.on('click', function(e){
						e.preventDefault();
						$file.val('').triggerHandler('change'); // triggerHandler() 강제
						$text.val('');
					});

					// 파일명.확장자 만 추출
					function getFileName(v){
						var arr = v.split("\\"); // 로컬경로는 / 아닌 \ 로 분리
						return arr[arr.length-1]; // 배열의 맨 끝이 파일명
					}

					// 파일값 유무 구분
					function isVal(){
						//console.log( !!$file.val() );
						if( !$file.val() ){ // 값 없으면
							$my.addClass('off');
						}else{
							$my.removeClass('off');
						}
					}

				})();
			//});
		/*]]>*/</script>

	</div>
	<div class="small-12 medium-8 column">

		<!-- <p class="tar"><i class="required" title="필수항목">*</i> 는 필수 입력 <span class="dpib">항목입니다.</span></p> -->

		<!-- 폼아이템들 -->
        <input type="hidden" id="input-filename" name="filename" value="@if (isset($tempInfo)) {{ $tempInfo->save_thumbnail }} @endif" />

		<div class="form1item1">
			<label for="★1text0" class="tt1">강좌 제목 <i class="required" title="필수항목">*</i></label>
			<input type="text" id="title" name="title" value="@if (isset($tempInfo)) {{ $tempInfo->title }} @endif" placeholder="강좌명을 입력하세요" class="w100 type1" />
		</div>

		<div class="form1item1">
			<label for="★1textarea0" class="tt1">강좌 설명 <i class="required" title="필수항목">*</i></label>
			<!-- <input type="text" id="★1textarea0" value="" class="w100 type1" /> -->
			<textarea id="description" name="description" rows="5" cols="80" placeholder="학습내용, 수강대상 등 강좌 요약을 2문장 이상 작성하는 것을 추천드립니다.">@if (isset($tempInfo)) {{ $tempInfo->description }} @endif</textarea>
		</div>

		<div class="form1item1">
			<label for="★1text0" class="tt1">난이도 <i class="required" title="필수항목">*</i></label>
			<div>
				<span class="dpib mgr15em">
					{{-- <input type="checkbox" name="★1checkbox0" id="★1checkbox0e0" /> <label for="★1checkbox0e0">초급</label> --}}
                    <input type="radio" id="level" name="level" value="low" @if (isset($tempInfo)) @if ($tempInfo->level == 'low') checked @endif @else checked @endif />초급
				</span>
				<span class="dpib mgr15em">
					{{-- <input type="checkbox" name="★1checkbox0" id="★1checkbox0e1" /> <label for="★1checkbox0e1">중급</label> --}}
                    <input type="radio" id="level" name="level" value="medium" @if (isset($tempInfo)) @if ($tempInfo->level == 'medium') checked @endif @endif />중급
				</span>
				<span class="dpib mgr15em">
					{{-- <input type="checkbox" name="★1checkbox0" id="★1checkbox0e2" /> <label for="★1checkbox0e2">중급 이상</label> --}}
                    <input type="radio" id="level" name="level" value="high" @if (isset($tempInfo)) @if ($tempInfo->level == 'high') checked @endif @endif />중급 이상
				</span>
			</div>
		</div>

		<!-- even-grid -->
		<div class="even-grid float-left gap2pct vgap00">
			<div class="small-12 large-8 column">

				<div class="form1item1">
					<label for="★1price1" class="tt1">가격 <i class="required" title="필수항목">*</i></label>
					<div>
						<div class="cp1menu4 mgr05em">
							<a href="javascript:void(0);" class="m m1 @if (isset($tempInfo)) @if ($tempInfo->free_yn == 'Y') on @endif @else on @endif" onclick="toggleFreeValue('Y');">무료</a>
							<a href="javascript:void(0);" class="m m2 @if (isset($tempInfo)) @if ($tempInfo->free_yn == 'N') on @endif @endif" onclick="toggleFreeValue('N');">유료</a>
						</div>
                        <input type="hidden" id="is_free" name="is_free" @if(isset($tempInfo)) @if ($tempInfo->free_yn == '') value="Y" @else value="{{ $tempInfo->free_yn }}" @endif @else value="Y" @endif />
						<script>/*<![CDATA[*/
							$('.cp1menu4 .m').on('click', function(e){
								e.preventDefault();
								$(this).siblings().removeClass('on').end().addClass('on');
							});
						/*]]>*/</script>
                        <input type="text" id="price" name="price" value="@if (isset($tempInfo)) {{ $tempInfo->price }} @endif" onkeydown="checkInputInteger()" placeholder="원" class="type1 tar w12em" />
					</div>
					<div class="fsS2 op05">
						<ul class="bi1 mgt0">
						<li class="li1">유튜브영상만으로 구성된 강좌는 유료로 설정하실 수 없습니다.</li>
						</ul>
					</div>
				</div>

			</div>
			<div class="small-12 large-4 column">

				<div class="form1item1" id="div_duration">
					<label for="★1term1" class="tt1">수강 기간 <i class="required" title="필수항목">*</i></label>
					<input type="text" id="duration" name="duration" value="@if (isset($tempInfo)) {{ $tempInfo->duration }} @endif" onkeydown="checkInputInteger()" placeholder="(일)" class="w100 type1 tar" />
					<div class="fsS2 op05">
						<ul class="bi1 mgt0">
						<li class="li1">비워둘 경우 수강 기간 제한 없음.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- /even-grid -->

		<!-- even-grid -->
		<div class="form1item1 even-grid gap2pct vgap00">
			<div class="small-12 xlarge-3 column vam">
				<span class="tt1">강좌 필수 카테고리 <i class="required" title="필수항목">*</i></span>
			</div>
			<div class="small-4 xlarge-3 column vam">
				<select title="필수 대분류" class="w100 type1" id="main_bcate" name="sel_main_cate">
                    <option value="">선택하세요</option>
                    @foreach ($bcategoryList as $bcategory)
                        <option value="{{ $bcategory->bcate_id }}" @if (isset($tempInfo)) @if ($bcategory->bcate_id == $tempInfo->main_bcate_id) selected @endif @endif>{{ $bcategory->bcate_name }}</option>
                    @endforeach
				</select>
			</div>
			<div class="small-4 xlarge-3 column vam">
				<select title="필수 소분류" class="w100 type1" id="main_scate" name="sel_main_cate">
                        <option value="">선택하세요</option>
                    @if (isset($tempInfo))
                        @if (count($existMainSCategoryList) > 0)
                            @foreach ($existMainSCategoryList as $existMainSCategory)
                            <option value="{{ $existMainSCategory->scate_id }}" @if ($existMainSCategory->scate_id == $tempInfo->main_scate_id) selected @endif>{{ $existMainSCategory->scate_name }}</option>
                            @endforeach
                        @endif
                    @endif
				</select>
			</div>
			<div class="small-4 xlarge-3 column vam">
				<select title="필수 인기 주제" class="w100 type1" id="main_psubject">
                    <option value="">선택하세요</option>
                    @if (isset($tempInfo))
                        @if (count($existMainPSubjectList) > 0)
                            @foreach ($existMainPSubjectList as $existMainPSubject)
                            <option value="{{ $existMainPSubject->psubject_name }}" @if ($existMainPSubject->psubject_name == $tempInfo->main_subject) selected @endif>{{ $existMainPSubject->psubject_name }}</option>
                            @endforeach
                        @endif
                    @endif
				</select>
			</div>
		</div>
		<!-- /even-grid -->

		<!-- even-grid -->
		<div class="form1item1 even-grid gap2pct vgap00 mgb2em">
			<div class="small-12 xlarge-3 column vam">
				<span class="tt1">강좌 서브 카테고리</span>
			</div>
			<div class="small-4 xlarge-3 column vam">
				<select title="서브 대분류" class="w100 type1" id="sub_bcate" name="sel_sub_cate">
                    <option value="">선택하세요</option>
					@foreach ($bcategoryList as $bcategory)
                        <option value="{{ $bcategory->bcate_id }}" @if (isset($tempInfo)) @if ($bcategory->bcate_id == $tempInfo->sub_bcate_id) selected @endif @endif>{{ $bcategory->bcate_name }}</option>
                    @endforeach
				</select>
			</div>
			<div class="small-4 xlarge-3 column vam">
				<select title="서브 소분류" class="w100 type1" id="sub_scate" name="sel_sub_cate">
                    <option value="">선택하세요</option>
                    @if (isset($tempInfo))
                        @if (count($existSubSCategoryList) > 0)
                            @foreach ($existSubSCategoryList as $existSubSCategory)
                            <option value="{{ $existSubSCategory->scate_id }}" @if (isset($tempInfo)) @if ($existSubSCategory->scate_id == $tempInfo->sub_scate_id) selected @endif @endif>{{ $existSubSCategory->scate_name }}</option>
                            @endforeach
                        @endif
                    @endif
				</select>
			</div>
			<div class="small-4 xlarge-3 column vam">
				<select title="서브 인기 주제" class="w100 type1" id="sub_psubject">
                    <option value="">선택하세요</option>
                    @if (isset($tempInfo))
                        @if (count($existSubPSubjectList) > 0)
                            @foreach ($existSubPSubjectList as $existSubPSubject)
                            <option value="{{ $existSubPSubject->psubject_name }}" @if ($existSubPSubject->psubject_name == $tempInfo->sub_subject) selected @endif>{{ $existSubPSubject->psubject_name }}</option>
                            @endforeach
                        @endif
                    @endif
				</select>
			</div>
		</div>
		<!-- /even-grid -->

		<!-- cp1tag2 -->
		<div class="cp1tag2">
			<strong class="h1"></strong>
			<div class="cont">
				<div class="tg1" id="add_subject">
                    {{-- 추가 버튼 클릭 시 주제가 해당 위치에 추가됨 --}}
				</div>
				<div class="eg1">
					<input type="text" value="" placeholder="주제를 추가해서 수강자들이 쉽게 강좌를 찾을 수 있도록 해보세요!" title="추가 주제" class="text1 type1" id="input_subject"/>
					<button type="button" class="b1 add button gray4">추가</button>
				</div>
			</div>
		</div>
		<!-- /cp1tag2 -->

        <script>/*<![CDATA[*/
			$(function(){

				/** ◇◆ 강좌 주제 제거 추가. 20210218. @m.
				 */
				(function(){
					var my = '.cp1tag2',
						tg1 = '.tg1', // 주제 그룹
						a1on = '.a1.on', // 주제
						text1 = '.text1', // 입력
						b1add = '.b1.add', // 추가 버튼
						v = '';

						// 미래 주제 클릭
						$(my).on('click', a1on, function(e){
							e.preventDefault();
							$(this).remove();
						});

						// 미래 추가 클릭
						$(my).on('click', b1add, function(){
                            if ($('#input_subject').val() != '') {
                                var $last = $(this).closest(my).find(a1on).last();
                                $('<a href="javascript:void(0);" class="a1 on" />').appendTo( $(this).closest(my).find(tg1) ).text( $(this).prevAll('.text1').val() );
                                $('#input_subject').val('');
                            }
                            $('#input_subject').focus();
						});
				})();
			});
		/*]]>*/</script>

	</div>
</div>
<!-- /even-grid -->
{{-- /기본정보입력 --}}