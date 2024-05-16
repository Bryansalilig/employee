<!--
  Activity Module Custom Scripts

  This is used for create and edit page.

  @version 1.0
  @since 2024-03-27

  Changes:
  • 2024-03-27: File creation
  • 2024-04-02:
    - Add function for .img-upload
-->
<script>
$(function () {
  // Initialize minicolors
  $('.minicolors').minicolors({
    control: 'hue',
    swatches: ["#528cd6", "#de9494", "#c6d69c", "#b5a5c6", "#94cede", "#ffc68c", "#a5a5a5", "#212121", "#4a4229", "#10315a", "#316394", "#943131", "#739439", "#5a4a7b", "#31849c", "#e76b08", "#848484", "#080808", "#181810", "#082139", "#214263", "#632121", "#4a6329", "#393152", "#215a63", "#944a00", "#c60000", "#ff0000", "#ffc600", "#ffff00", "#94d652", "#00b552", "#00b5f7", "#0073c6", "#002163", "#7331a5", "#0086cd", "#c65911", "#ffd966", "#7030a0", "#c9c9c9", "#bdd7ee"],
    defaultValue: '#0086cd', // Default color
    change: function (value, opacity) {
      // Handle color change event here
      console.log('Selected color: ' + value);
    }
  });

  $('input.minicolors').closest('.minicolors-theme-default').addClass('d-block');
});
</script>
