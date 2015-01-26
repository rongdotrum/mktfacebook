<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
            $this->renderPartial('/partial/_meta');
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                /*$('.btnCoin').click(function(){
                 $('.boxCoin').toggleClass('show');
                 $('.boxRegister').removeClass('show');
                 $('.boxServerLanding').removeClass('show');
                 });*/

                $('.buttonNgay').click(function() {
                    $('html,body').animate({
                        scrollTop: $(".bgLanding").offset().top}, 'slow');
                });

                $('.playLand').click(function() {
                    $('.boxServerLanding').toggleClass('show');
                    $('.boxCoin').removeClass('show');
                    $('.boxRegister').removeClass('show');
                });

                /*=== menu tab ===*/
                $("#subMenuEvent a").click(function() {
                    var param = $(this).attr("rel");
                    $(".publicBox").hide();
                    $("#" + param).show();
                    $("#subMenuEvent a").removeClass("selected");
                    $(this).addClass("selected");
                    $('.subHinh').css({
                        'background': 'url(css/images/' + $(this).attr('data-img') + ')'
                    });
                });

                $("#tabMenuEvent a").click(function() {
                    var param = $(this).attr("rel");
                    $(".subPublic").hide();
                    $("#" + param).show();
                    $("#tabMenuEvent a").removeClass("selected");
                    $(this).addClass("selected");
                });

                $(".tablePrice input[type='radio']").click(function() {
                    if ($("#Zingsoha_txtScoinValue").val() != '')
                    {
                        $("#Zingsoha_txtScoinValue").val('');
                        $("#ajax_scoin").html(' = 0');
                    }
                });
            });

        </script>
    </head>
    <body>
        <div class="hinhEvent bgLanding">
            <div class="subHinh">
                <!--<a class="buttonPlay" href="#">choi ngay</a>         -->
                <div class="menuLanding">
                    <div class="boxServerLanding show">
                        <?php $this->renderPartial('/partial/boxserver'); ?>
                    </div>
                    <div class="childLanding">
                        <div class="subLanding">
                            <a target="_blank" class="gtLand" href="#">gioi thieu</a>
                            <a target="_blank" class="newsLand" href="#">tin tuc</a>
                            <a target="_blank" class="eventLand" href="#">su kien</a>
                            <a class="playLand" href="javascript:;">choi ngay</a>
                            <a target="_blank" class="gamerLand" href="#">tan thu</a>
                            <a target="_blank" class="upLand" href="#">nâng cao</a>
                            <a target="_blank" class="forumLand" href="#">dien dan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="parrentPage parrentLanding">
            <?php echo $content; ?>
        </div>
        <div id="topbar" class="footerLanding">
            <div id="boxTop">

            </div>
        </div>
        <script type="text/javascript">
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-53777971-1', 'auto');
            ga('send', 'pageview');
        </script>
    </body>
</html>
