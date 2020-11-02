<?php

require 'includes/header.php';
require 'includes/navbar.php';

if (!isset($content)) {
    $content = '
  <section class="hero is-medium is-primary">
    <div class="hero-body">
      <div class="container">
        <div class="columns">
          <div class="column is-8-desktop is-offset-2-desktop">
            <h1 class="title is-2 is-spaced">
              Welcome to Stuliday !
            </h1>
            <h2 class="subtitle is-4">
              Come to discover our places to stay, or you can even add your own !
            </h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  ';
}
echo $content;
// <section class="hero is-medium is-primary">
//   <div class="hero-body">
//     <div class="container">
//       <div class="columns">
//         <div class="column is-8-desktop is-offset-2-desktop">
//           <h1 class="title is-2 is-spaced">
//             Welcome to Stuliday !
//           </h1>
//           <h2 class="subtitle is-4">
//             Come to discover our places to stay, or you can even add your own !
//           </h2>
//         </div>
//       </div>
//     </div>
//   </div>
// </section>
require 'includes/footer.php';
