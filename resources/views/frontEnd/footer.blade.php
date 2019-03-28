<?php
use Illuminate\Support\Facades\DB;
$header = DB::select('select * from header');
$fb = DB::select('select links from social_link where title="facebook" limit 1');
$tw = DB::select('select links from social_link where title="twitter" limit 1');
$go = DB::select('select links from social_link where title="googleplus" limit 1');
$pi = DB::select('select links from social_link where title="pintrest" limit 1');
$sk = DB::select('select links from social_link where title="skype" limit 1');
foreach ($tw as $t){$twitter = $t->links;}
foreach ($fb as $f){$facebook = $f->links;}
foreach ($sk as $s){$skype = $s->links;}
foreach ($go as $g){$googleplus = $g->links;}
foreach ($pi as $p){$pintrest = $p->links;}
?>

<footer class="copyright-area ">
    <div class="container">
        <div class="row">
                <div class="copyright-text col-md-4">
                    <p>All Rights Reserved © <a class="homeLink" href="{{url('/home')}}">Messenger</a></p>
                </div>

                <div class="copyright-text col-md-4 pull-right">
                    <div class="footer-social">
                        <a target="_blank" href="{{$twitter }}"><i class="fa fa-twitter"></i></a>
                        <a target="_blank" href="{{$facebook }}"><i class="fa fa-facebook"></i></a>
                        <a target="_blank" href="{{$skype }}"><i class="fa fa-skype"></i></a>
                        <a target="_blank" href="{{$googleplus }}"><i class="fa fa-google-plus"></i></a>
                        <a target="_blank" href="{{$pintrest }}"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
        </div>
    </div>
</footer>
<!---- copyright area ends ---->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/todc-bootstrap/3.3.7-3.3.13/js/bootstrap.min.js"></script>
<script src="{{asset('public/js/main_script.js')}}"></script>