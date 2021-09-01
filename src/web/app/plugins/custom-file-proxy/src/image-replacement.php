<?php
// TODO:: 
// - srcset
// - data-src
// - style="background-image:url(...)
// if img not loaded yet, wait until it is
// check if window.location is not same as url in backend
// make timeout editable
if (!is_admin()) {
  $sfp_field = get_option('custom_file_proxy_options');
?>
  <script>
    window.addEventListener("load", function() {

      setTimeout(() => {
        const imageArray = document.querySelectorAll("img");
        const oldHostname = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port

        imageArray.forEach((image) => {
          if (!!new URL(image.src)) {
            const newHostname = "https://<?php echo $sfp_field["production_cname"] ?>";
            image.src = image.src.replace(oldHostname, newHostname)
            image.src = image.src.replace('/app/', '/wp-content/')

            if (image.srcset) {
              const newSrcSet = image.srcset.replaceAll(oldHostname, newHostname)
              image.srcset = newSrcSet
            }
          }
        });
      }, 300);
    });
  </script>

<?php
}
