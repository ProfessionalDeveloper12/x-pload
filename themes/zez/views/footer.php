    <?php if($show){?>
		<footer class="site-footer">
            <div class="site-footer__main-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget footer-widget--about-widget">
                                <a href="<?=PATH?>" class="footer-widget__footer-logo"><img src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>" alt="<?=get_option("website_title", "X-Pload - Social Marketing Tool")?>" /></a>
                                <p>Call us at 407-337-4777</p>
                                <p>info@xpload.com</p>
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="footer-widget">
                                <h3 class="footer-widget__title">
                                    Explore
                                </h3><!-- /.footer-widget__title -->
                                <ul class="footer-widget__link-list">
                                    <li><a href="<?=cn("p/about")?>">About</a></li>
                                    <li><a href="<?=cn("p/our_team")?>">Our Team</a></li>
                                    <li><a href="<?=BASE?>blog">Blog</a></li>
                                    <li><a href="<?=cn("p/how_it_works")?>">How It Works</a></li>
                                </ul><!-- /.footer-widget__link-list -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-lg-2 -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget">
                                <h3 class="footer-widget__title">
                                    Legal
                                </h3><!-- /.footer-widget__title -->
                                <ul class="footer-widget__link-list">
                                    <li><a href="<?=cn("p/privacy_policy")?>"><?=lang("privacy_policy")?></a></li>
							      	<li><a href="<?=cn("p/terms-of-service")?>"><?=lang("terms_of_service")?></a></li>
							      	<li><a href="<?=cn("p/affiliate-agreement")?>"><?=lang("affiliate_agreement")?></a></li>
							      		<li><a href="<?=cn("p/gdpr-policy")?>"><?=lang("gdpr_policy")?></a></li>
							      			<li><a href="<?=cn("p/income-disclosure")?>"><?=lang("income_disclosure")?></a></li>
                                </ul><!-- /.footer-widget__link-list -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-lg-3 -->
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="footer-widget">
                                <h3 class="footer-widget__title">
                                    Links
                                </h3><!-- /.footer-widget__title -->
                                <ul class="footer-widget__link-list">
                                    <li><a href="<?=cn("p/help")?>">Help</a></li>
                                    <li><a href="<?=BASE?>support">Support</a></li>
                                    <li><a href="<?=cn("p/clients")?>">Clients</a></li>
                                    <li><a href="<?=cn("p/contact")?>">Contact</a></li>
                                </ul><!-- /.footer-widget__link-list -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-lg-2 -->
                        <div class="col-lg-2 col-md-6 col-sm-12 d-flex">
                            <div class="footer-widget my-auto">
                                <div class="social-block">
	                                <?php if(get_option("social_page_twitter", "") != ""){?>
                                    <a href="<?=get_option("social_page_twitter", "")?>"><i class="fa fa-twitter"></i></a>
                                    <?php }?>
                                    <?php if(get_option("social_page_facebook", "") != ""){?>
                                    <a href="<?=get_option("social_page_facebook", "")?>"><i class="fa fa-facebook-f"></i></a>
                                    <?php }?>
                                    <?php if(get_option("social_page_google", "") != ""){?>
                                    <a href="<?=get_option("social_page_google", "")?>"><i class="fa fa-google"></i></a>
                                    <?php }?>
                                    <?php if(get_option("social_page_instagram", "") != ""){?>
                                    <a href="<?=get_option("social_page_instagram", "")?>"><i class="fa fa-instagram"></i></a>
                                    <?php }?>
                                    <?php if(get_option("social_page_pinterest", "") != ""){?>
                                    <a href="<?=get_option("social_page_pinterest", "")?>"><i class="fa fa-pinterest"></i></a>
                                    <?php }?>
                                </div><!-- /.social-block -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-lg-2 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.site-footer__main-footer -->
            <div class="site-footer__bottom-footer text-center">
                <div class="container">
                    <p><?=lang("copyright_2018_all_rights_reserved")?></p>
                </div><!-- /.container -->
            </div><!-- /.site-footer__bottom-footer -->
        </footer><!-- /.site-footer -->
    </div><!-- /.page-wrapper -->
    <?php }?>
	<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- /.scroll-to-top -->
	<!--Javascript-->
	<script src="<?=BASE?>themes/zez/assets/js/jquery.js"></script>
    <script src="<?=BASE?>themes/zez/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?=BASE?>themes/zez/assets/js/owl.carousel.min.js"></script>
    <script src="<?=BASE?>themes/zez/assets/js/waypoints.min.js"></script>
    <script src="<?=BASE?>themes/zez/assets/js/jquery.counterup.min.js"></script>
    <script src="<?=BASE?>themes/zez/assets/js/jquery.bxslider.min.js"></script>
    <script src="<?=BASE?>themes/zez/assets/js/jquery.easing.min.js"></script>
    <script src="<?=BASE?>themes/zez/assets/js/theme.js"></script>
    <!--Javascript-->
    <script type="text/javascript" src="<?=BASE?>themes/zez/assets/plugins/ladda/spin.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>themes/zez/assets/plugins/ladda/ladda.min.js"></script>
	<script type="text/javascript" src="<?=BASE?>themes/zez/assets/js/jquery.aniview.js"></script>
	<script type="text/javascript" src="<?=BASE?>themes/zez/assets/js/main.js"></script>
    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</body>
</html>