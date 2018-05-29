<section id="section-main" class="border-boxed expanded padding-left-md padding-right-md">
    <div class="row margin-bottom-md">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="font-times-new-roman text-info">Request for promotion</h1>
            <form id="mailer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-font"></i></span>
                    <input id="mail-name" type="text" class="form-control font-times-new-roman" name="mail-name" placeholder="Position">
                </div>
                <textarea id="mail-message" class="form-control font-times-new-roman" rows="10" name="mail-message" style="resize: none;" placeholder="Type a few words about your request"></textarea>
                <div class="expanded input-group">
                    <span class="input-group-addon" onclick="var a = $('#attach-file'); a.click();"><i class="glyphicon glyphicon-paperclip"></i></span>
                    <input id="attach-file" type="file" style="display: none;" multiple>
                    <p id="name-of-folders" class = "form-control font-times-new-roman"></p>
                </div>
                <script type="text/javascript">
                    $("#attach-file").change(function(event)
                    {
                        var files = $(this).prop("files");
                        var names = $.map(files, function(val) { return val.name; });
                        
                        var s = "";
                        for (var i = 0; i < names.length; i++)
                            s += names[i] + "; ";
                        $("#name-of-folders").html(s);
                    });
                </script>
                <div>
                <input id="mail-send" type="button" class="form-control font-times-new-roman" name="mail-send" value="Send!" onclick="sendMail($('#mailer #mail-name')[0].value, $('#mailer #mail-email')[0].value, $('#mailer #mail-subject')[0].value, $('#mailer #mail-message')[0].value);">
                </div>
                </form>
        </div>
    </div>
</section>