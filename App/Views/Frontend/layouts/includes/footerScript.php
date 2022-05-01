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
<script src="<?= asset_url_front() ?>js/wow.min.js"></script>
<script src="<?= asset_url_front() ?>js/bootstrap.min.js"></script>
<script src="<?= asset_url_front() ?>js/jquery.hover3d.min.js"></script>
<script src="<?= asset_url_front() ?>js/all.js"></script>
<script src="<?= asset_url_front() ?>js/my.web.js"></script>

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

        $("#work_samples .Type-design").click(function() {
            $("#work_samples .Type-design").find(".flip-box-front , .flip-box-back").removeClass("border border-secondary text-muted ");
            $("#Type-design-offer section").stop().fadeOut(0);

            var index = $(this).index();
            var section_selected = $("#Type-design-offer section").eq(index);

            $.ajax({
                type: "post",
                url: '<?= base_url() ?>work_samples',
                data: {
                    type: index,
                },
                success: function(response) {

                    data = JSON.parse(response);

                    $(data).each(function(key, value) {

                        // section_selected.html(value);
                    });



                },
            });
            $(this).find(".flip-box-front , .flip-box-back").addClass("border border-secondary text-muted ");
        });
    });
</script>