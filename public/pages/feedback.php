<h2>Testemunhos</h2>
<section id="testemunhos" style="padding: 2rem;">
  <div class="grid-gallery">
    <!-- The images -->
    <?php
      $dir = "img/testemunhos";
      $images = glob($dir . "/*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
      foreach ($images as $image) {
          echo "<div class='image-card'><img src='$image' alt='Testemunho'></div>";
      }
    ?>
  </div>
</section>