<?php if(!defined('SITE_INCLUDED')) { exit; } ?>
<style>
#play-store{
border-radius:15px;
transition: 0.4s;
transform: perspective(600px) rotateY(0deg);

}
.play-card{
    cursor: pointer;
}
#play-store:hover{

transform:rotate(180deg);

}




</style>
<div class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="cta-text">
                                <h6>Bize Ulaşın</h6>
                                <span><?php echo m_setting('address'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="far fa-envelope-open"></i>
                            <div class="cta-text">
                                <h6>Destek</h6>
                                <span><?php echo m_setting('email'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-phone"></i>
                            <div class="cta-text">
                                <h6>İşbirliği</h6>
                                <span><?php echo m_setting('ads_email'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="<?php echo m_permalink('home'); ?>" title="Açıklıyorum"><img width="152" height="38" src="<?php echo UPLOAD_URL; ?>/1x1.gif" class="lazyload img-fluid" data-src="<?php echo m_setting('logo'); ?>" alt="Açıklıyorum"></a>
                            </div>
                            <div class="footer-text">
                                <p><?php echo m_setting('copyright'); ?></p>
                            </div>
                            <div class="footer-social-icon">
                                <span>Bizi takip edin</span>
                                <a href="<?php echo m_setting('facebook'); ?>" title="Facebook" target="_blank"><i class="fab fa-facebook-f facebook-bg"></i></a>
                                <a href="<?php echo m_setting('twitter'); ?>" title="Twitter" target="_blank"><i class="fab fa-twitter twitter-bg"></i></a>
                                <a href="<?php echo m_setting('instagram'); ?>" title="İnstagram" target="_blank"><i class="fab fa-instagram google-bg"></i></a>
                                <a href="<?php echo m_setting('linkedin'); ?>" title="Linkedin" target="_blank"><i class="fab fa-linkedin bg-primary"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h6>Site Haritası</h6>
                            </div>
                            <ul>
                                <li><a href="<?php echo m_permalink('home'); ?>" title="Anasayfa">Anasayfa</a></li>
                                <li><a href="<?php echo m_permalink('how_to_work'); ?>" title="Nasıl Çalışır ?">Nasıl Çalışır ?</a></li>
                                <li><a href="<?php echo m_permalink('positive_reviews'); ?>" title="Olumlu Yorumlar">Olumlu Yorumlar</a></li>
                                <li><a href="<?php echo m_permalink('login'); ?>" title="Giriş Yap">Giriş Yap</a></li>
                                <li><a href="<?php echo m_permalink('negative_reviews'); ?>" title="Olumsuz Yorumlar">Olumsuz Yorumlar</a></li>
								<li><a href="<?php echo m_permalink('register'); ?>" title="Kayıt Ol">Kayıt Ol</a></li>
                                <li><a href="<?php echo m_permalink('brands'); ?>" title="En İyi Markalar">En İyi Markalar</a></li>
                                <li><a href="<?php echo m_permalink('page','vakit-gecir-kazan'); ?>" title="Vakit Geçir Kazan">Vakit Geçir Kazan</a></li>
                                <li><a href="<?php echo m_permalink('tops'); ?>" title="En İyi Kullanıcılar">En İyi Kullanıcılar</a></li>
                                <li><a href="<?php echo m_permalink('page','ortaklik-programi'); ?>" title="Ortaklık Programı">Ortaklık Programı</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h6>Mobil</h6>
                            </div>
                            <div class="subscribe-form play-card" >
                                <a href="<?php echo m_setting('google_app_link'); ?>" title="Açıklıyorum Mobil"><img id="play-store" width="150" height="130" alt="Açıklıyorum Mobil" src="<?php echo UPLOAD_URL; ?>/1x1.gif" class="lazyload" data-src="<?php echo SITE_THEME_URL; ?>/assets/img/google-play.png">
                                
                                <img id="play-store" width="150" height="130" alt="Açıklıyorum Mobil" src="<?php echo UPLOAD_URL; ?>/1x1.gif" class="lazyload" data-src="<?php echo SITE_THEME_URL; ?>/assets/img/google-play-z.png">
                                
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="copyright-text">
                            <p>Copyright &copy; 2021, Tüm hakları saklıdır. <a href="<?php echo m_permalink('home'); ?>" title="Acikliyorum.com">Acikliyorum.com</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="<?php echo m_permalink('home'); ?>" title="Anasayfa">Anasayfa</a></li>
                                <li><a href="<?php echo m_permalink('page','gizlilik-politikasi'); ?>" title="Gizlilik Politikası">Gizlilik Politikası</a></li>
                                <li><a href="<?php echo m_permalink('page','acikliyorum-web'); ?>" title="Gizlilik Politikası">Gizlilik Politikası web </a></li>
                                <li><a href="<?php echo m_permalink('page','kullanici-sozlesmesi'); ?>" title="Kullanıcı Sözleşmesi">Kullanıcı Sözleşmesi</a></li>
                                <li><a href="<?php echo m_permalink('page','sss'); ?>" title="Sıkça Sorulan Sorular">S.S.S</a></li>
								<li><a href="<?php echo m_permalink('page','kunye'); ?>" title="Künye">Künye</a></li>
                                <li><a href="<?php echo m_permalink('contact'); ?>" title="İletişim">İletişim</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php echo m_setting('footer_codes'); ?>

<script src="<?php echo SITE_THEME_URL; ?>/assets/js/jquery.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/js/popper.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/js/bootstrap.bundle.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/fancybox/jquery.fancybox.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/sweetalert2/sweetalert2.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/select2/select2.full.min.js" defer></script>
<?php
if(strstr(m_u_g('page'),'account') or strstr(m_u_g('page'),'support'))
{
?>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/datatable/jquery.dataTables.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/datatable/dataTables.bootstrap5.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/datatable/dataTables.responsive.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/datatable/responsive.bootstrap5.min.js" defer></script>
<?php
}
?>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/lazysizes.min.js" defer></script>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/custom.min.js?v=<?php echo PROJECT_VERSION; ?>" defer></script>

<?php
if(m_u_g('page')=='add_review_detail' or m_u_g('page')=='revise_review')
{
?>
<script src="<?php echo SITE_THEME_URL; ?>/assets/custom/review_add.min.js?v=<?php echo PROJECT_VERSION; ?>" defer></script>
<?php
}
?>

</body>
</html>