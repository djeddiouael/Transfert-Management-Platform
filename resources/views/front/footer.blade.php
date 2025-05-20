<footer id="footer" class="footer">
    <div class="footer-top text-center">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-12 col-md-12 footer-about text-center">
                    <div class="footer-contact pt-3">
                        @if(app()->getLocale() == 'ar')
                            <span class="sitename">جامعة بومرداس</span>
                            <p>مرحبًا بكم في دفعة 2025 من طلاب علوم الحاسوب المتخصصين في الأنظمة المعلوماتية</p>
                        @elseif(app()->getLocale() == 'en')
                            <span class="sitename">University of Boumerdes</span>
                            <p>Welcome to the 2025 cohort of Computer Science students specializing in Information Systems</p>
                        @else
                            <span class="sitename">Université de Boumerdes</span>
                            <p>Bienvenue à la promotion 2025 des étudiants en informatique spécialisés dans les systèmes d'information</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center py-3">
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="mx-2"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com" target="_blank" class="mx-2"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com" target="_blank" class="mx-2"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com" target="_blank" class="mx-2"><i class="fab fa-linkedin"></i></a>
        </div>
        @if(app()->getLocale() == 'ar')
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة</p>
        @elseif(app()->getLocale() == 'en')
            <p>&copy; {{ date('Y') }}  All rights reserved.</p>
        @else
            <p>&copy; {{ date('Y') }} Tous droits réservés.</p>
        @endif
    </div>
</footer>