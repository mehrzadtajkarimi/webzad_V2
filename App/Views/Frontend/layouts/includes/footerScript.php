<script async src="https://www.googletagmanager.com/gtag/js?id=UA-136110471-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-136110471-1');
</script>
<!-- ================================================== -->
<script src="<?= base_url() ?>Public/Assets/Frontend/js/wow.min.js"></script>
<script src="<?= base_url() ?>Public/Assets/Frontend/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>Public/Assets/Frontend/js/jquery.hover3d.min.js"></script>
<script src="<?= base_url() ?>Public/Assets/Frontend/js/all.js"></script>
<script src="<?= base_url() ?>Public/Assets/Frontend/js/my.web.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var typed = new Typed("#typing-big-banner", {
            strings: [
                "طراحی وب سایت   مطابق با استاندارد های جهانی"
            ],
            typeSpeed: 60,
            startDelay: 4000,
            showCursor: false
        });

        $("#nemonekar .Type-design").click(function() {
            $("#nemonekar .Type-design").find(".flip-box-front , .flip-box-back").removeClass("border border-secondary text-muted ");
            $("#Type-design-offer section").stop().fadeOut(0);

            var index = $(this).index();
            var section_selected = $("#Type-design-offer section").eq(index);

            var url = '<?= base_url() ?>index/tab';
            var data = {
                'number': index
            };

            $.post(url, data, function(msg) {
                section_selected.html(msg);
            });
            section_selected.fadeIn(500);
            $(this).find(".flip-box-front , .flip-box-back").addClass("border border-secondary text-muted ");
        });
    });
</script>