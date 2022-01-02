
<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>


<!-- Trigger/Open The Modal -->
<!-- <button id="myBtn">Open Modal</button> -->

<!-- The Modal -->
<div id="myModal" class="modal">
<div class="yprm-popup-block" style="opacity: 1;">
      <div class="close popup-icon-close"></div>
      <div class="overlay"></div>
      <div class="prev popup-icon-left-arrow" style="display: none;"></div>
      <div class="next popup-icon-right-arrow" style="display: none;"></div>
      <div class="items">
      <div class="item build" data-video="{&quot;html&quot;:&quot;<iframe class=\&quot;pswp__video\&quot; width=\&quot;1920\&quot; height=\&quot;1080\&quot; src=\&quot;https://youtube.com/embed/q76bMs-NwRk?rel=0&amp;showinfo=0&amp;enablejsapi=1\&quot; frameborder=\&quot;0\&quot; allowfullscreen=\&quot;\&quot;></iframe>&quot;,&quot;w&quot;:1920,&quot;h&quot;:1080}" style="transform: translate(-50%, -50%); height: 226px; width: 401.778px; z-index: 100; opacity: 1;"><iframe class="pswp__video" width="1920" height="1080" src="https://youtube.com/embed/q76bMs-NwRk?rel=0&amp;showinfo=0&amp;enablejsapi=1" frameborder="0" allowfullscreen=""></iframe>
          
        </div></div>
      <div class="buttons">
        <div class="prev popup-icon-prev" style="display: none;"></div>
        <div class="counter" style="display: none;">
          <div class="current">1</div>
          <div class="sep">/</div>
          <div class="total">1</div>
        </div>
        <div class="next popup-icon-next" style="display: none;"></div>
        <div class="back-link popup-icon-apps" style="opacity: 1;"></div>
        <div class="fullscreen popup-icon-full-screen-selector" style="opacity: 1;"></div>
        <div class="autoplay" style="display: none;">
          <i class="popup-icon-play-button"></i>
          <i class="popup-icon-pause-button"></i>
        </div>
        <div class="share popup-icon-share" style="opacity: 1;"></div>
        <div class="likes" data-id="" style="display: none;">
          <i class="popup-icon-heart"></i>
          <span></span>
        </div>
        <a href="#" class="read-more" style="display: none;">
          <i class="popup-icon-maximize-size-option"></i>
          <span>view project</span>
        </a>
      </div>
    </div>
  <!-- Modal content -->
  <!-- <div class="modal-content">
    <span class="close">&times;</span>
    <p>Some text in the Modal..</p>
  </div> -->

</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
// var btn = document.querySelectorAll(".myBtn");
var x, i;
       x = document.querySelectorAll(".myBtn");
       for (i = 0; i < x.length; i++) {
         // x[i].style.display = "none";
           x[i].onclick = function() {
            console.log("hello");
  modal.style.display = "block";
}
       }


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

