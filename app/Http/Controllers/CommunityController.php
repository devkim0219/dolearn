<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class CommunityController extends Controller{
    public function notice() {
        return view('sub.community.notice');
    }

    public function noticeDetail() {
        return view('sub.community.notice_detail');
    }

    public function trend() {
        return view('sub.community.insight_trend');
    }

    public function trendDetail() {
        return view('sub.community.insight_trend_detail');
    }

    public function ranking(Request $request) {
        if($request->isMethod('get')){
            $type = $request->get('type', '');

            if ($type == '' || $type == 'lecture') {
                $lectureList = DB::select('SELECT l.*,COUNT(ml.status="complete") complete_cnt FROM lecture l LEFT JOIN my_lecture ml ON l.idx = ml.lecture_idx GROUP BY l.idx ORDER BY l.student_cnt DESC LIMIT 9');
                $totalCnt =DB::select('select count(*) count from lecture')[0]->count;
                return view('sub.community.insight_ranking_lecture', compact('lectureList', 'totalCnt'));
            } else if ($type == 'instructor') {
                $instructorList = DB::select('SELECT u.*, SUM(l.student_cnt) total_student, AVG(l.rating) score_avg FROM users u LEFT JOIN lecture l ON l.owner_id = u.email WHERE role = "instructor" GROUP BY u.email ORDER BY SUM(l.student_cnt) desc LIMIT 9');
                $totalCnt =DB::select('select count(*) count from users where role = "instructor"')[0]->count;
                return view('sub.community.insight_ranking_instructor', compact('instructorList','totalCnt'));
            } else if ($type == 'youtuber') {
                $youtuberList = DB::select('SELECT  sum(y.hit_cnt) sum_hit, u.* FROM users u inner join _youtube_fulldata_temp y ON u.nickname = y.channel GROUP BY CHANNEL ORDER BY sum(y.hit_cnt) desc limit 9');
                $totalCnt =DB::select('SELECT COUNT(*) count FROM users u WHERE u.nickname in (SELECT distinct channel FROM _youtube_fulldata_temp y)')[0]->count;
                return view('sub.community.insight_ranking_youtuber', compact('youtuberList', 'totalCnt'));
            }
        }
        else if($request->isMethod('post')){
            $type = $request->post('type', '');
            $sort = $request->post('sort', '');
            $cnt = $request->post('cnt', 0);
            $limit = ($cnt!=0)?' LIMIT '.$cnt.', 5':' LIMIT 9';
            $html = '';
            $result = array();
            if ($type == '' || $type == 'lecture') {
                if($sort == '????????? ???'){
                    $lectureList = DB::select('SELECT l.*,COUNT(ml.status="complete") complete_cnt FROM lecture l LEFT JOIN my_lecture ml ON l.idx = ml.lecture_idx GROUP BY l.idx ORDER BY l.student_cnt DESC '.$limit);
                }else if($sort =='?????????'){
                    $lectureList = DB::select('SELECT l.*,COUNT(ml.status="complete") complete_cnt FROM lecture l LEFT JOIN my_lecture ml ON l.idx = ml.lecture_idx GROUP BY l.idx ORDER BY COUNT(ml.status="complete")/l.student_cnt  DESC '.$limit);
                }else if($sort =='??????'){
                    $lectureList = DB::select('SELECT l.*,COUNT(ml.status="complete") complete_cnt FROM lecture l LEFT JOIN my_lecture ml ON l.idx = ml.lecture_idx GROUP BY l.idx ORDER BY l.rating DESC '.$limit);
                }
                try{
                    foreach($lectureList as $lecture){
                        $html .='<li class="li1">';
                        $html .='   <a href="'.route('sub.lecture.lecture_detail', ['idx' => $lecture->idx]).'" class="w1 a1">';
                        $html .='       <div class="w1w1">';
                        $html .='           <div class="w1w1w1">';
                        $html .='               <b class="g1"><span class="g1t1">'.++$cnt.'</span><span class="g1t2">???</span></b>';
                        $html .='           </div>';
                        $html .='           <div class="w1w1w2">';
                        $html .='               <div class="f1">';
                        $html .='                   <span class="f1p1">';
                        if($lecture->save_thumbnail !='')
                            $html .='                       <img src="'.asset('storage/uploads/thumbnail/'.$lecture->save_thumbnail).'" alt="????????????????????????" />';
                        else{
                            $html .='                       <img src="'.asset('assets/images/main/x1/x1p010.jpg').'" alt="????????????????????????" />';
                        }
                        $html .='                   </span>';
                        $html .='               </div>';
                        $html .='           </div>';
                        $html .='           <div class="w1w1w3">';
                        $html .='               <div class="t1">';
                        $html .=                    $lecture->title;
                        $html .='               </div>';
                        $html .='               <div class="t2">';
                        $html .=                    $lecture->owner_name;
                        $html .='               </div>';
                        $html .='           </div>';
                        $html .='       </div>';
                        $html .='       <div class="w1w2">';
                        $html .='           <div class="w1w2w1">';
                        $html .='               <span class="t3">?????????</span>';
                        $html .='               <span class="t4">';
                        if ($lecture->student_cnt != 0){
                        $html .=                    round(((int)$lecture->complete_cnt / $lecture->student_cnt) * 100, 0).'%';
                        } else{
                        $html .='                   0%';
                        }
                        $html .='               </span>';
                        $html .='           </div>';
                        $html .='           <div class="w1w2w2">';
                        $html .='               <span class="t3">?????? ??????</span>';
                        $html .='               <span class="t4">'.$lecture->rating.'</span>';
                        $html .='           </div>';
                        $html .='           <div class="w1w2w3">';
                        $html .='               <span class="t3">????????? ???</span>';
                        $html .='               <span class="t4">'.$lecture->student_cnt.'</span>';
                        $html .='           </div>';
                        $html .='       </div>';
                        $html .='</a>';
                        $html .='</li>';
                    }
                    $result['status'] = "success";
                    $result['html'] = $html;
                }catch(Exception $e){
                    $result['status'] = 'fail';
                    $result['msg'] = $e->getMessage();
                    $result['code'] = $e->getCode();
                }
            } else if ($type == 'instructor') {
                if($sort == '????????? ???'){
                    $instructorList =  DB::select('SELECT  u.*, SUM(l.student_cnt) total_student, AVG(l.rating) score_avg FROM users u LEFT JOIN lecture l ON l.owner_id = u.email WHERE role = "instructor" GROUP BY u.email ORDER BY SUM(l.student_cnt) desc '.$limit);
                }else if($sort =='?????????'){
                    $instructorList =  DB::select('SELECT u.*, SUM(l.student_cnt) total_student, AVG(l.rating) score_avg FROM users u LEFT JOIN lecture l ON l.owner_id = u.email WHERE role = "instructor" GROUP BY u.email ORDER BY SUM(l.student_cnt) desc '.$limit);
                }else if($sort =='??????'){
                    $instructorList = DB::select('SELECT u.*, SUM(l.student_cnt) total_student, AVG(l.rating) score_avg FROM users u LEFT JOIN lecture l ON l.owner_id = u.email WHERE role = "instructor" GROUP BY u.email ORDER BY  AVG(l.rating) desc '.$limit);
                }
                try{
                    foreach($instructorList as $instructor){
                        $html .= '<li class="li1">';
                        $html .= '	 <a href="'.route('etc.user_introduction', ['type'=>'instructor', 'user_idx'=>$instructor->id]).'" class="w1 a1">';
                        $html .= '		<div class="w1w1">';
                        $html .= '			<div class="w1w1w1">';
                        $html .= '				<b class="g1"><span class="g1t1">'.++$cnt.'</span><span class="g1t2">???</span></b>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w1w2">';
                        $html .= '				<div class="f1">';
                        $html .= '					<span class="f1p1">';
                        if($instructor->save_profile_image!=''){
                            $html .= '                  <img src="'.asset('storage/uploads/profile/'.$instructor->save_profile_image).'" alt="????????? ??????" />';
                        }else{
                            $html .= '                  <img src="'.asset('assets/images/lib/noimg1face1.png').'" alt="????????? ??????" />';
                        }
                        $html .= '					</span>';
                        $html .= '				</div>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w1w3">';
                        $html .= '				<div class="t1">';
                        $html .=                    $instructor->nickname;
                        $html .= '				</div>';
                        $html .= '				<div class="t2">';
                        $html .=    			    $instructor->introduction;
                        $html .= '				</div>';
                        $html .= '			</div>';
                        $html .= '		</div>';
                        $html .= '		<div class="w1w2">';
                        $html .= '			<div class="w1w2w1">';
                        $html .= '				<span class="t3">?????? ?????? ??????</span>';
                        $html .= '				<span class="t4">';
                        $html .=                    ($instructor->score_avg!='')? number_format($instructor->score_avg, 1):'-';
                        $html .= '              </span>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w2w2">';
                        $html .= '				<span class="t3">????????? ???</span>';
                        $html .= '				<span class="t4">';
                        $html .=                    ($instructor->total_student!='')? $instructor->total_student:'0';
                        $html .= '              </span>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w2w3">';
                        $html .= '				<span class="t3">?????????</span>';
                        $html .= '				<span class="t4">-</span>';
                        $html .= '			</div>';
                        $html .= '		</div>';
                        $html .= '	</a>';
                        $html .= '</li>';
                    }
                    $result['status'] = "success";
                    $result['html'] = $html;
                }catch(Exception $e){
                    $result['status'] = 'fail';
                    $result['msg'] = $e->getMessage();
                    $result['code'] = $e->getCode();
                }
            } else if ($type == 'youtuber') {
                if($sort == '????????? ?????????'){
                    $youtuberList =  DB::select('SELECT  sum(y.hit_cnt) sum_hit, u.* FROM users u inner join _youtube_fulldata_temp y ON u.nickname = y.channel GROUP BY CHANNEL ORDER BY sum(y.hit_cnt) desc '.$limit);
                }else if($sort =='?????? ?????????'){
                    $youtuberList =   DB::select('SELECT  sum(y.hit_cnt) sum_hit, u.* FROM users u inner join _youtube_fulldata_temp y ON u.nickname = y.channel GROUP BY CHANNEL '.$limit);
                }else if($sort =='??????'){
                    $youtuberList =   DB::select('SELECT  sum(y.hit_cnt) sum_hit, u.* FROM users u inner join _youtube_fulldata_temp y ON u.nickname = y.channel GROUP BY CHANNEL '.$limit);
                } try{
                    foreach($youtuberList as $youtuber){
                        $html .= '<li class="li1">';
                        $html .= '	<a href="'.route('etc.user_introduction', ['type'=>'youtuber', 'user_idx'=>$youtuber->id]).'" class="w1 a1">';
                        $html .= '		<div class="w1w1">';
                        $html .= '			<div class="w1w1w1">';
                        $html .= '				<b class="g1"><span class="g1t1">'.++$cnt.'</span><span class="g1t2">???</span></b>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w1w2">';
                        $html .= '				<div class="f1">';
                        $html .= '					<span class="f1p1">';
                        if ($youtuber->save_profile_image!=''){
                            $html .= '                  <img src="'.asset('storage/uploads/profile/'.$youtuber->save_profile_image).'" alt="????????? ??????" />';
                        } else{
                            $html .= '                  <img src="'.asset('assets/images/lib/noimg1face1.png').'" alt="????????? ??????" />';
                        }
                        $html .= '					</span>';
                        $html .= '				</div>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w1w3">';
                        $html .= '				<div class="t1">';
                        $html .= 					$youtuber->nickname;
                        $html .= '				</div>';
                        $html .= '				<div class="t2">';
                        $html .= 					$youtuber->introduction;
                        $html .= '				</div>';
                        $html .= '			</div>';
                        $html .= '		</div>';
                        $html .= '		<div class="w1w2">';
                        $html .= '			<div class="w1w2w1">';
                        $html .= '				<span class="t3">?????? ??????</span>';
                        $html .= '				<span class="t4">-</span>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w2w2">';
                        $html .= '				<span class="t3">YouTube ?????????</span>';
                        $html .= '				<span class="t4">';
                        $html .= (strlen($youtuber->sum_hit)>4)?number_format($youtuber->sum_hit/10000, 1).'???':number_format($youtuber->sum_hit/10000, 1) ;
                        $html .= '</span>';
                        $html .= '			</div>';
                        $html .= '			<div class="w1w2w3">';
                        $html .= '				<span class="t3">?????? ?????????</span>';
                        $html .= '				<span class="t4">-</span>';
                        $html .= '			</div>';
                        $html .= '		</div>';
                        $html .= '	</a>';
                        $html .= '</li>';
                    }
                    $result['status'] = "success";
                    $result['html'] = $html;
                }catch(Exception $e){
                    $result['status'] = 'fail';
                    $result['msg'] = $e->getMessage();
                    $result['code'] = $e->getCode();
                }
            }
            return response()->json($result, 200);
        }

    }

    public function serviceQna() {
        return view('sub.community.service_qna');
    }

    public function getServiceQnaData(Request $request) {
        $type = $request->post('type', '');
        $resData = '';

        try {
            $result['status'] = 'success';

        } catch(Exception $e) {
            $result['status'] = 'fail';
            $result['msg'] = $e->getMessage();
            $result['code'] = $e->getCode();
        } finally {
            $result['resData'] = $resData;

            return response()->json($result);
        }
    }

    public function oneToOne() {
        return view('sub.community.one_to_one');
    }

    public function oneToOneDetail() {
        return view('sub.community.one_to_one_detail');
    }

    public function reviewAll(Request $request) {
        $keyword = $request->get('keyword', '');
        $query = '';
        $where = '';

        if ($keyword != '') {
            $where = ' AND content LIKE "%'.$keyword.'%"';
        }

        $query = 'SELECT rev.*, lec.idx AS lecutre_idx, lec.title, lec.save_thumbnail
                    FROM lecture_review rev, lecture lec
                    WHERE rev.lecture_idx = lec.idx'.$where.'
                    ORDER BY rev.writed_at DESC
                    LIMIT 5';

        $reviewList = DB::select($query);

        return view('sub.community.review_all', compact('reviewList'));
    }
}
