<script type="text/javascript">
    replies =
    [
        // generated on server
        new Reply(1, "miodrag-milošević", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.", "16.04.2018.", false),
        new Reply(2, "predrag-mitrović", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.", "16.04.2018.", false),
        new Reply(3, "vladimir-sivčev", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.", "16.04.2018.", true),
        new Reply(4, "predrag-mitrović", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.", "16.04.2018.", false),
        new Reply(5, "vladimir-sivčev", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.", "16.04.2018.", true)
    ];
    isActorOP = true;
    isActorModerator = false;
    acceptedAnswer = 4;
</script>

<div class="border-boxed expanded padding-bottom-md" style="background-color: inherit;">
    <h1 id="post-title" class="font-rammetto-one font-lg text-center padding-top-sm padding-bottom-sm">Post title</h1>
    <div id="post-content" class="border-boxed expanded font-times-new-roman font-sm text-justify solid-border-top border-top-xs border-top-gray solid-border-bottom border-bottom-xs border-bottom-gray padding-md padding-top-sm">
        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type
            specimen book. It has survived not only five centuries, but also the leap into
            electronic typesetting, remaining essentially unchanged. It was popularised in
            the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including
            versions of Lorem Ipsum.
        </p>
        <div id="post-controls" class="border-boxed expanded">
            <button id="post-lock" type="button" class="btn btn-primary btn-sm font-xs"><i class="fa fa-key"></i> Lock</button>
            <button id="post-release" type="button" class="btn btn-warning btn-sm font-xs"><i class="fa fa-unlock-alt"></i> Release</button>
            <button id="post-submit-tokens" type="button" class="btn btn-success btn-sm font-xs" onclick="submitTokensPopupFeed.Toggle(0);"><i class="fa fa-money"></i> Submit Tokens</button>
            <button id="post-review" type="button" class="btn btn-warning btn-sm font-xs" onclick="reviewPopupFeed.Toggle(0);"><i class="fa fa-star"></i> Review</button>
            <br>
            <button id="attach" type="button" class="btn btn-info" onclick="$('#attach-files').click();"><i class="fa fa-file-zip-o"></i> Attach file(s)...</button>
            <input id="attach-files" type="file" style="display: none;" multiple>
            <p id="attached-files-display" class="font-times-new-roman font-xs"></p>
            <script type="text/javascript">
                $("#post-controls #attach-files").change(function(event)
                {
                    var names = $.map($(this).prop("files"), function(val) { return val.name; });
                    
                    var filenames = "";
                    for (var i = 0; i < names.length; i++)
                        filenames += names[i] + " | ";
                    $("#post-controls #attached-files-display").html(filenames.substring(0, filenames.length - 3));
                });
            </script>
            <p id="post-info" class="font-times-new-roman font-xs">
                Locked by: &lt;none&gt;
                <br>
                Submitted tokens: 0.00t
                <br>
                Attached files: &lt;none&gt;
            </p>
        </div>
    </div>
    <div class="border-boxed expanded font-rammetto-one font-xs text-align-left padding-xs" style="line-height: 200%;">
        <a href="section.html?id=c++" class="hover-text-decor-none bg-lightblue padding-left-xs padding-right-xs"><span class="bg-secondary">C++</span></a>&nbsp;
        <a href="section.html?id=c#" class="hover-text-decor-none bg-lightblue padding-left-xs padding-right-xs"><span class="bg-secondary">C#</span></a>&nbsp;
        <a href="section.html?id=OOP" class="hover-text-decor-none bg-lightblue padding-left-xs padding-right-xs"><span class="bg-secondary">OOP</span></a>&nbsp;
        <a href="section.html?id=DP" class="hover-text-decor-none bg-lightblue padding-left-xs padding-right-xs"><span class="bg-secondary">Design Patterns</span></a>&nbsp;
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-8"></div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
            <div class="border-boxed text-center padding-xs bg-lightblue rounded-xxs">
                <p class="font-times-new-roman font-xs no-margin">Posted on: <i id="post-date">16.04.2018.</i></p>
                <b id="active-indicator" class="font-times-new-roman text-success no-margin">active</b> /
                <b id="active-indicator" class="font-times-new-roman text-danger no-margin">inactive</b><br>
                <p id="original-poster" class="font-times-new-roman font-xs no-margin">
                    <a href="profile.html?id=vladimir-sivčev"><img class="edged" src="storage/users/vladimir-sivčev/avatar.png" width="50" height="50"></a><br>
                    <a href="profile.html?id=vladimir-sivčev" class="hover-text-decor-none">vladimir-sivčev</a>
                </p>
            </div>
        </div>
    </div>
</div>
<section id="section-main" class="border-boxed expanded padding-left-md padding-right-md">
</section>
<div class="border-boxed expanded font-times-new-roman">
    <article name="reply" class="border-boxed expanded no-margin padding-sm">
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-4 text-right">
                <a href="profile.html?id=miodrag-milošević" class="font-times-new-roman hover-text-decor-none">
                    <img src="storage/users/miodrag-milošević/avatar.png" width="60" height="60"><br>
                    miodrag-milošević
                </a>
                <p class="font-times-new-roman">Posted on: <i>16.04.2018</i></p>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-4">
                <div class="border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs" style="line-height: 0;">
                    <textarea class="border-boxed expanded padding-xs" style="line-height: 20px; height: 100px; resize: none;" onkeydown="return onReplyKeydown(this, event);"></textarea>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-4 text-left">
            </div>
        </div>
    </article>
</div>