<?php
session_start();

if (isset($_COOKIE['counter'])) {
    setcookie('counter', $_COOKIE['counter']+1);
} else {
    setcookie('counter', '1');
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta property="og:url" content="http://localhost/mydesk/mydesk.php" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="mydesk" />
        <meta property="og:description" content="내책상 내자리" />
        <meta property="og:image" content="#" />

        <link rel="stylesheet" type="text/css" href="./semantic/dist/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="./css/sweetalert/sweetalert2.min.css">
        <link rel="stylesheet" type="text/css" href="./css/file-upload-button.css">
        <link rel="shortcut icon" href="./favicon.ico">

        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

        <title>My Desk</title>
    </head>

    <body>
    
    <?php
        if (isset($_COOKIE['counter']) == null) {
    ?>
        <script>
            $(function() {
                $('#first').modal({
                    inverted: true,
                    onHide: function() {
                        $('.ui.dimmer').removeClass('inverted');
                    }
                }).modal('setting', 'transition', 'fade up').modal('show');
            });
        </script>
    <?php
    	} //end if
    ?>
        <!-- 메인 메뉴 -->
        <div class="ui text huge menu">
            <div class="ui container">
                <div class="ui left item">
                    <a class="item" href="./mydesk.php"><i class="home icon"></i>My Desk</a>
                </div>
                <div class="ui right item">
                    <div id="fb-sh" class="item" onclick="fb_sharing();" data-content="페이스북 공유" data-position="bottom center">
                        <i class="facebook f link icon"></i>
                    </div>
                    <div id="tw-sh" class="item" onclick="tw_sharing();" data-content="트위터 공유" data-position="bottom center">
                        <i class="twitter link icon"></i>                        
                    </div>
                    <div id="user-menu" class="ui item top right pointing dropdown" data-content="회원메뉴" data-position="bottom center" style="margin-left:0.5em!important;">
                        <i class="user icon"></i>
                        <div id = "mem-menu" class="menu">
                        <?php
                            if (isset($_SESSION['useremail']) === true) {
                        ?>
                            <div class="header"><?php echo isset($_SESSION['usernickname']) ? $_SESSION['usernickname'] : NULL ?></div>
                            <div class="item"><a href="./user/logout.php" style="color:black;"><i class="sign out icon"></i>로그아웃</a></div>
                        <?php
                            } else {
                        ?>
                            <div id="login-button" class="item"><i class="sign in icon"></i>로그인</div>
                            <div id="join-button" class="item"><i class="add user icon"></i>회원가입</div>
                        <?php
                            } //end if
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 선 -->
        <div class="ui divider"></div>
        
        <!-- 서브메뉴 -->
        <div class="ui text large menu">
            <div class="ui container">
                <div class="ui left item">
                    <button id="random-button" type="button" class="circular ui icon button" data-content="랜덤보기" data-position="top center" data-value="<?php echo isset($_SESSION['useremail']) ? $_SESSION['useremail'] : 'visitor@visitor' ?>"><i class="random icon"></i></button>
                </div>
                <?php
                if (isset($_SESSION['useremail']) === true) {
                ?>
                <div class="ui right item">
                    <button id="write-button" type="button" class="circular ui icon button"  data-content="작성하기" data-position="top center"><i class="write icon"></i></button>
                </div>
                <?php
                } //end if
                ?>
            </div>
        </div>
        
        <!-- 목록 -->
        <div class="ui container" style="margin-top: 2rem; margin-bottom: 3rem;">	
            <div class="ui padded special cards">
                <div id="card-more" class="ui four cards column doubling stackable container">
                    <?php
                        include  './lib/medoo.php';
                        include './lib/dbconn.php';
                        
                        $datas = $database->get('mydesk', 'desk_num');
                        
                        if (!$datas) { // 등록된 글 없을때
                    ?>
                    <div class="ui container center aligned">
                    <?php
                            if (isset($_SESSION['useremail']) === true) {
                    ?>
                        <i id="first-write-button" class="massive disabled photo link icon"></i>
                        <div class="ui medium header">아직 등록된 게시물이 없습니다. <br> 당신의 책상을 찍어 올려보세요! </div>
                    <?php
                            } else {
                    ?>
                        <i id="first-join-button" class="massive disabled add user link icon"></i>
                        <div class="ui medium header">아직 등록된 게시물이 없습니다. <br> 회원가입 후 당신의 책상을 찍어 올려보세요! </div>
                    <?php
                            }
                    ?>
                    </div>
                    <?php
                        } else {  //등록된 글 있을 때
                            $datas = $database->select(
                                'mydesk',
                                array('email', 'desk_num', 'file_thumb', 'vote_good'),
                                array('ORDER' => array('desk_num' => 'DESC'), 'LIMIT' => 8)
                            );

                            foreach ($datas as $data) {
                                $email = $data['email'];
                                $deskNum = $data['desk_num'];
                                $imageName = $data['file_thumb'];
                                $voteGood = $data['vote_good'];

                                $imgName = $imageName;
                                $imgName = './data/thumbnails/'.$imgName;                                    
                    ?>
                    <div class="card" data-value="<?php echo $deskNum ?>">
                        <div class="blurring dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <!-- 글 읽기 버튼 -->
                                    <div id="cen" class="center" data-value="<?php echo isset($_SESSION['useremail']) ? $_SESSION['useremail'] : NULL ?>">
                                        <div id="con-read-button" class="ui inverted button" data-value="<?php echo $deskNum ?>">More</div>
                                    </div>
                                </div>
                            </div>
                            <img src="<?php echo $imgName ?>" data-src="<?php echo $imgName ?>" class="transition visible">
                        </div>
                        <!-- 추천 버튼 -->
                        <div id="vote<?php echo $deskNum ?>" class="ui right aligned extra content" data-value="<?php echo isset($_SESSION['useremail']) ? $_SESSION['useremail'] : NULL ?>">
                        <?php
                        $datas2 = $database->get(
                            'vote',
                            'user_id',
                            array('AND' => array('desk_num' => $deskNum, 'user_id' => isset($_SESSION['useremail']) ? $_SESSION['useremail'] : NULL))
                        );

                        if ($datas2) {?>
                            <i id="vote_button" class="red heart link icon" data-value="<?php echo $deskNum ?>"></i>
                        <?php } else { ?>
                            <i id="vote_button" class="heart link icon" data-value="<?php echo $deskNum ?>"></i>    
                        <?php } ?>
                            <span> <?php if ($voteGood >= 1) { echo "·   $voteGood"; } ?> </span>
                        </div>
                    </div>
                    <?php
                            } //end foreach
                        } //end if
                        $count = $database->count('mydesk');

                        if ($count > 8) {
                    ?>
                    <!-- 더보기 버튼 -->
                    <div class="ui container list-more-box">
                        <input id="useremail" type="hidden" value="<?php echo isset($_SESSION['useremail']) ? $_SESSION['useremail'] : NULL ?>">
                        <button id="list-more-button" class="fluid ui button" data-value="<?php echo $deskNum ?>"><i class="chevron down icon"></i></button>
                    </div>
                    <?php } //end if ?>             
                </div>
            </div>
        </div>
        
        <!-- 콘텐츠 모달 -->
        <div id="user-pr" class="ui large long modal user">
            <i class="close icon"></i>
            <div class="header">
                <span id = "user-name"></span>
                <!-- 글 삭제 버튼 -->
                <div id = "del-icon" style="display: inline-block;"></div>
                <input id = "del-val" type="hidden" value="">
            </div>
            <div class="image content">
                <div id='user-img' class="ui Large image">
                    <img class='ui image'>
                </div>
                <div id='user-content' class="description">
                    <div class="ui header"></div>
                    <p></p>                  
                </div>
            </div>
            <!-- 댓글 -->
            <div class="actions" style="text-align:left; margin-bottom:1em;">
                <div class="ui minimal comments" style="max-width:100%;">
                    <h3 class="ui header">Comments</h3>
                    <div id="reply-con" class="comment">
                    </div>
                    <?php 
                    if (isset($_SESSION['useremail'])) { 
                    ?>
                    <div class="ui reply form" style="text-align:right;">
                        <div class="field">
                            <input id="con-num" type="hidden" name="desknum" value="">
                            <input id="re-usermail" type="hidden" name="useremail" value="<?php echo isset($_SESSION['useremail']) ? $_SESSION['useremail'] : NULL ?>">
                            <input id="re-usernick" type="hidden" name="usernickname" value="<?php echo isset($_SESSION['usernickname']) ? $_SESSION['usernickname'] : NULL ?>">
                            <textarea id="re-con" name="rep-content" style="height:30%; min-height:3em;"></textarea>
                        </div>
                        <button id="reply-button" class="ui blue labeled submit icon button">
                            Add Reply <i class="reply icon"></i>
                        </button>
                    </div>
                    <?php
                    } else { 
                    ?>
                    <div class="ui info message">
                        <div class="header"> 로그인 후 댓글을 작성할 수 있습니다 </div>
                    </div>    
                    <?php 
                    } //end if 
                    ?>
                </div>
            </div>
        </div>
        
        <!-- 작성폼  모달-->
        <div id="write-form" class="ui modal">
            <div class="header" style="border-bottom:none;"><?php echo isset($_SESSION['usernickname']) ? $_SESSION['usernickname'] : NULL ?></div>
            <div class="content">
                <div class="ui equal width form">
                    <form id="write-form" class="ui form" name="write-form" method="post"> 
                        <div class="two fields">
                            <input id="wrt-nick" name="nickname" type="hidden" value="<?php echo isset($_SESSION['usernickname']) ? $_SESSION['usernickname'] : NULL ?>">
                            <input id="wrt-mail" name="email" type="hidden" value="<?php echo isset($_SESSION['useremail']) ? $_SESSION['useremail'] : NULL ?>">
                            <div class="required field">
                                <label>Image</label>
                                <div class="ui action input">
                                    <input id="upload-file-name" type="text" disabled="disabled">
                                    <button id="file-upload-button" class="ui icon button">
                                        <i class="upload icon"></i>
                                        <input id="wrt-file" id="file" type="file" name="upfile">
                                    </button>
                                </div>
                            </div>
                            <div class="field">
                                <label>Job</label>
                                <input id="wrt-job" name="job" type="text" placeholder="Job" maxlength="10">
                            </div>                      
                        </div>
                        <div class="field">
                            <label>Short Text</label>
                            <textarea id="content" name="content" rows="1"></textarea>
                        </div>
                        <div class="actions" style="padding:0; border-top:none;">
                            <div class="ui deny button">Cancle</div>
                            <button id="con-submit" type="submit" class="ui right labeled icon button"><i class="checkmark icon" onClick="this.disabled=true"></i>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- 회원가입  모달-->
        <div id="join-form" class="ui small modal">
            <div class="content">
                <div class="ui equal width form">
                    <div class="ui form" name="join-form"> 
                        <div class="fields">
                            <div class="required field">
                                <label>Email</label>
                                <input id="join-email" type="text" name="email" placeholder="Email" value="">
                            </div>
                            <div class="required field">
                                <label>Password</label>
                                <input id="join-pswd" type="password" name="password" placeholder="Password" value="">
                            </div>
                            <div class="required field">
                                <label>Nickname</label>
                                <input id="join-nick" type="text" name="nickname" placeholder="Nickname" value="" maxlength="10">
                            </div>
                        </div>
                        <div class="ui info message">
                            <ul class="list">
                                <li> @ 포함 이메일 주소 전체 입력</li>
                                <li> 10자 이상 비밀번호 입력</li>
                                <li> 10자 이내 닉네임 입력</li>
                            </ul>
                        </div>
                        <div class="actions" style="padding:0; border-top:none;">
                            <div class="ui deny button">Cancle</div>
                            <button id="join-submit" type="submit" class="ui right labeled icon button"><i class="checkmark icon"></i>Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 로그인 모달 -->
        <div id="login-form" class="ui basic modal">
            <i class="close icon"></i>
            <div class="header">로그인</div>
            <div name="login-form" class="ui form">                            
                <div class="image content">
                    <div class="two fields">
                        <div class="field">
                            <input id="login-email" type="text" name="email" placeholder="Email" value="">
                        </div>
                        <div class="field">
                            <input id="login-pswd" type="password" name="pswd" placeholder="Password" value="" maxlength="10">
                        </div>
                        <div class="ui buttons">
                            <button id="login-submit" type="button" class="ui icon button"><i class="sign in icon"></i></button>
                        </div>                      
                    </div>                    
                </div>
            </div>
        </div>       
        
        <!-- 최초 진입 모달 -->
        <div id="first" class="ui modal">
            <div class="image content">
                <div class="ui medium image">
                    <img src="./data/adm/profile.jpg">
                </div>
                <div class="description">
                    <div class="ui header">header</div>
                    <p>content</p>
                </div>
            </div>
            <div class="actions">
                <div class="ui black basic deny button">확인</div>
            </div>
        </div>

        <script type="text/javascript" src="./semantic/dist/semantic.min.js"></script> <!-- semantic -->
        <script type="text/javascript" src="./js/sweetalert/sweetalert2.min.js"></script> <!-- sweetalert -->
        <!-- <script type="text/javascript" src="http://jsgetip.appspot.com"></script>  추천에 쓰일 IP -->

        <script type="text/javascript" src="./js/content/delete.js"></script> <!-- 목록더보기 -->
        <script type="text/javascript" src="./js/content/insert.js"></script> <!-- 글작성 -->
        <script type="text/javascript" src="./js/content/list-more.js"></script> <!-- 목록더보기 -->    
        <script type="text/javascript" src="./js/content/read-content.js"></script> <!-- 글 읽기 -->
        <script type="text/javascript" src="./js/content/reply-delete.js"></script> <!-- 댓글 삭제-->
        <script type="text/javascript" src="./js/content/reply.js"></script> <!-- 댓글 -->
        <script type="text/javascript" src="./js/content/vote.js"></script> <!-- 추천 -->        
        <script type="text/javascript" src="./js/content/write-form-validation.js"></script> <!-- 글 입력 확인 -->

        <script type="text/javascript" src="./js/tooltip.js"></script> <!-- 툴팁 팝업 -->
        <script type="text/javascript" src="./js/social-share.js"></script> <!-- 소셜 쉐어 -->

        <script type="text/javascript" src="./js/user/join.js"></script> <!-- 회원가입 확인 -->
        <script type="text/javascript" src="./js/user/login.js"></script> <!-- 회원가입 확인 -->

    </body>
</html>