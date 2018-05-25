<div class="jumbotron no-padding-bottom font-rammetto-one text-center" style="background-color: inherit;">
        <h1><span class="text-primary">A</span>bout us</h1>
</div>
<section id="section-main" class="border-boxed expanded padding-left-md padding-right-md">
        <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <article id="article-1" class="border-boxed expanded margin-bottom-md padding-md" style="min-height: 200px;">
                                <p class="no-margin font-times-new-roman font-lg text-info"><i class="fa fa-map-marker"> Location</i></p>
                                <p class="no-margin font-times-new-roman font-sm">Bulevar kralja Aleksandra 73</p>
                                <p class="no-margin font-times-new-roman font-sm"><b>Belgrade, Republic of Serbia</b></p>
                        </article>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <article id="article-2" class="border-boxed expanded margin-bottom-md padding-md" style="min-height: 200px;">
                                <p class="no-margin font-times-new-roman font-lg text-success"><i class="fa fa-phone"> Phone</i></p>
                                <p class="no-margin font-times-new-roman font-md">+381 11/32-26-992</p>
                        </article>
                </div>
        </div>
        <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <article id="article-3" class="border-boxed expanded margin-bottom-md padding-md" style="min-height: 200px;">
                                <p class="no-margin font-times-new-roman font-lg text-danger"><i class="fa fa-envelope"> E-Mail</i></p>
                                <p class="no-margin font-times-new-roman font-md"><a class="hover-text-decor-none" href="mailto:#">dekanat@etf.bg.ac.rs</a></p>
                        </article>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <article id="article-4" class="border-boxed expanded margin-bottom-md padding-md" style="min-height: 200px;">
                                <p class="no-margin font-times-new-roman font-lg text-warning"><i class="fa fa-clock-o"> Business hours</i></p>
                                <p class="no-margin font-times-new-roman font-md">Mon-Fri: 10<sup class="font-sm">00</sup>÷18<sup class="font-sm">00</sup></p>
                        </article>
                </div>
        </div>
        <div class="row margin-bottom-md">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1 class="font-times-new-roman text-info">Who are we?</h1>
                        <p class="font-times-new-roman font-sm">
                                We are a small group of students who work hard on their bright ideas such as this project. This is a product of an assignment we were given to complete a certain web application of our own desire. We wanned to show our TA's how students do everything by the book and do their homework right (as this project was)!
                        </p>
                </div>
        </div>
        <div class="row margin-bottom-md">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1 class="font-times-new-roman text-info">Where are we?</h1>
                        <div id="map" class="border-boxed expanded solid-border border-xs border-gray rounded-xxs" style="height:500px"></div>
                        <script>function initMap() { var mapCanvas = document.getElementById("map"); var mapCenter = new google.maps.LatLng(44.805468, 20.4758449); var mapOptions = { center: mapCenter, zoom: 10, mapTypeId: google.maps.MapTypeId.HYBRID }; var map = new google.maps.Map(mapCanvas, mapOptions); var marker = new google.maps.Marker({ position: mapCenter, animation: google.maps.Animation.BOUNCE }); marker.setMap(map); }</script>
                        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTmjv_17LFv0zZRK8TKPEY8Pghk_x2h0I&callback=initMap" type="text/javascript"></script>
                </div>
        </div>
        <div class="row margin-bottom-md">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1 class="font-times-new-roman text-info">How are we?</h1>
                        <p class="font-times-new-roman font-sm">
                                Send us an e-mail to check how are we. Or if you have any other reason to. :)
                        </p>
                        <form id="mailer">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-font"></i></span>
                                        <input id="mail-name" type="text" class="form-control font-times-new-roman" name="mail-name" placeholder="Your name">
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input id="mail-email" type="email" class="form-control font-times-new-roman" name="mail-email" placeholder="E-Mail">
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-header"></i></span>
                                        <input id="mail-subject" type="text" class="form-control font-times-new-roman" name="mail-subject" placeholder="Subject">
                                </div>
                                <textarea id="mail-message" class="form-control font-times-new-roman" rows="7" name="mail-message" style="resize: none;" placeholder="Type a message you want to send us here!"></textarea>
                                <div class="expanded input-group">
                                        <input id="mail-send" type="button" class="form-control font-times-new-roman" name="mail-send" value="Send!" onclick="sendMail($('#mailer #mail-name')[0].value, $('#mailer #mail-email')[0].value, $('#mailer #mail-subject')[0].value, $('#mailer #mail-message')[0].value);">
                                </div>
                        </form>
                </div>
        </div>
</section>